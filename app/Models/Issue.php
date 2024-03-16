<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Issue extends Model
{
    use HasFactory;

    public function getRouteKeyName(): string
    {
        return 'gitlab_id';
    }

    protected $fillable = [
        'gitlab_id', 'internal_id', 'project_id', 'author_id', 'closed_by', 'title', 'description', 'state', 'closed_at', 'labels',
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

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'gitlab_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'noteable_id', 'gitlab_id')
            ->where('noteable_type', 'Issue')
            ->orderByDesc('updated_at');
    }
}
