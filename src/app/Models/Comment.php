<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'gitlab_id',
        'author_id',
        'noteable_id',
        'project_id',
        'system',
        'noteable_type',
        'body',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'gitlab_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'noteable_id', 'project_id');
    }

    public function issue(): BelongsTo
    {
        return $this->belongsTo(Issue::class, 'noteable_id', 'gitlab_id');
    }
}
