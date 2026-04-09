<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'username'          => $this->username,
            'gender'            => $this->gender,
            'bio'               => $this->bio,
            'bio_truncated'     => $this->bio ? Str::limit($this->bio, 100) : null,
            'member_since'      => $this->created_at->format('M Y'),
            'profile_photo_url' => $this->profile_photo_url,
            'portfolio_pdf_url' => $this->portfolio_pdf_url,
            'whatsapp_url'      => $this->whatsapp_url,
            'phone_number'      => preg_replace('/\D/', '', $this->phone_number ?? ''), // ← tambah
            'skills'            => SkillResource::collection($this->whenLoaded('skills')),
            'needed_skills'     => SkillResource::collection($this->whenLoaded('neededSkills')),
        ];
    }
}
