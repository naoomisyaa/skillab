<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollaborationRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'status'       => $this->status->value,
            'message'      => $this->message,
            'requester'    => new UserResource($this->whenLoaded('requester')),
            'requested'    => new UserResource($this->whenLoaded('requested')),
            'created_at'   => $this->created_at->diffForHumans(),
        ];
    }
}
