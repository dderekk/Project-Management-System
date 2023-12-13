<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectFiles extends Model
{
    use HasFactory;

    protected $table = 'projectFiles';

    protected $fillable = [
        'name',
        'type',
        'file_path',
        'project_id',
    ];
}
