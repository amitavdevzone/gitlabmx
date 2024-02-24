<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id', 'name', 'name_with_namespace', 'description', 'web_url',
        'visibility', 'project_created_date',
    ];
}
