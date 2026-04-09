<?php

namespace App\Models;

use App\Enums\CollaborationStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollaborationRequest extends Model
{
    protected $fillable = [
        'requester_id',
        'requested_id',
        'status',
        'message',
    ];

    protected function casts(): array
    {
        return [
            'status' => CollaborationStatus::class,
        ];
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function requested(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requested_id');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', CollaborationStatus::Pending);
    }

    public function scopeAccepted(Builder $query): Builder
    {
        return $query->where('status', CollaborationStatus::Accepted);
    }

    public function scopeDeclined(Builder $query): Builder
    {
        return $query->where('status', CollaborationStatus::Declined);
    }
}
