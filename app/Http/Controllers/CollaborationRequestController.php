<?php

namespace App\Http\Controllers;

use App\Enums\CollaborationStatus;
use App\Http\Requests\StoreCollaborationRequest;
use App\Http\Resources\CollaborationRequestResource;
use App\Models\CollaborationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CollaborationRequestController extends Controller
{
    public function index(Request $request): View
    {
        $authId = $request->user()->id;

        $sentRequests = CollaborationRequest::with('requested.skills')
            ->where('requester_id', $authId)
            ->latest()
            ->get();

        $receivedRequests = CollaborationRequest::with('requester.skills')
            ->where('requested_id', $authId)
            ->latest()
            ->get();

        return view('collaboration-requests.index', compact('sentRequests', 'receivedRequests'));
    }

    public function apiIndex(Request $request): JsonResponse
    {
        $authId = $request->user()->id;

        $sentRequests = CollaborationRequest::with('requested.skills')
            ->where('requester_id', $authId)
            ->latest()
            ->get();

        $receivedRequests = CollaborationRequest::with('requester.skills')
            ->where('requested_id', $authId)
            ->latest()
            ->get();

        return response()->json([
            'sent'     => CollaborationRequestResource::collection($sentRequests),
            'received' => CollaborationRequestResource::collection($receivedRequests),
            'pending_count' => $receivedRequests->filter(
                fn($r) => $r->status->value === 'pending'
            )->count(),
        ]);
    }

    public function store(StoreCollaborationRequest $request): RedirectResponse
    {
        $authUser    = $request->user();
        $requestedId = $request->validated('requested_id');

        $alreadyPending = CollaborationRequest::where('requester_id', $authUser->id)
            ->where('requested_id', $requestedId)
            ->pending()
            ->exists();

        if ($alreadyPending) {
            return back()->withErrors([
                'collaboration' => 'Kamu sudah punya pending request ke user ini.',
            ]);
        }

        $collab = CollaborationRequest::create([
            'requester_id' => $authUser->id,
            'requested_id' => $requestedId,
            'message'      => $request->validated('message'),
            'status'       => CollaborationStatus::Pending,
        ]);

        $collab->load('requested');

        return redirect()
            ->route('matchmaking.index')
            ->with('success', 'Collaboration request sent!');
    }

    public function accept(CollaborationRequest $collaborationRequest): RedirectResponse
    {
        Gate::authorize('respond', $collaborationRequest);

        $collaborationRequest->update(['status' => CollaborationStatus::Accepted]);

        return back()->with('success', 'Collaboration request diterima! 🎉');
    }

    public function decline(CollaborationRequest $collaborationRequest): RedirectResponse
    {
        Gate::authorize('respond', $collaborationRequest);

        $collaborationRequest->update(['status' => CollaborationStatus::Declined]);

        return back()->with('info', 'Collaboration request ditolak.');
    }
}
