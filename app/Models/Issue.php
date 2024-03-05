<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Issue extends Model
{
    use HasFactory;

    public function getRouteKeyName(): string
    {
        return 'gitlab_id';
    }

    protected $fillable = [
        'gitlab_id', 'internal_id', 'project_id', 'closed_by', 'title', 'description', 'state', 'closed_at', 'labels',
        'assignees', 'due_date', 'assigned_to',
    ];

    protected $casts = [
        'closed_at' => 'timestamp',
        'labels' => 'array',
        'assignees' => 'array',
        'due_date' => 'timestamp',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function assigned(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to', 'gitlab_id');
    }
}
