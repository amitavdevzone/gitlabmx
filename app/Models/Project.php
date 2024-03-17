<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'client_id', 'name', 'name_with_namespace', 'description', 'web_url',
        'visibility', 'project_created_date',
    ];

    public function issues(): HasMany
    {
        return $this->hasMany(Issue::class, 'project_id', 'project_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function time_entries(): HasMany
    {
        return $this->hasMany(TimeEntry::class);
    }
}
