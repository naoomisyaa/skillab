<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MatchmakingController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::with(['skills', 'neededSkills'])
            ->where('id', '!=', $request->user()->id);

        if ($request->filled('skill')) {
            $query->whereHas(
                'skills',
                fn($q) =>
                $q->where('slug', $request->skill)
            );
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('username', 'like', '%' . $request->search . '%');
            });
        }

        $users  = $query->latest()->paginate(8)->withQueryString();
        $skills = Skill::orderBy('name')->get();

        $pendingRequestedIds = $request->user()
            ->sentRequests()->pending()
            ->pluck('requested_id')->toArray();

        return view('matchmaking.index', compact('users', 'skills', 'pendingRequestedIds'));
    }
}
