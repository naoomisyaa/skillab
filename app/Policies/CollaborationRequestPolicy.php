<?php

namespace App\Policies;

use App\Enums\CollaborationStatus;
use App\Models\CollaborationRequest;
use App\Models\User;

class CollaborationRequestPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Hanya user yang DIMINTA (requested) yang bisa Accept/Decline,
     * dan hanya kalau statusnya masih pending.
     */
    public function respond(User $user, CollaborationRequest $collaborationRequest): bool
    {
        return $user->id === $collaborationRequest->requested_id
            && $collaborationRequest->status === CollaborationStatus::Pending;
    }
}
