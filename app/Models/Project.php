<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'title',
        'description',
        'trimester',
        'team_size',
        'year',
        'inpID',
        'coordinator_name',
        'coordinator_email',
    ];
    
    function users(){
        return $this->belongsTo('App\Models\User','inpID');
    }
    function applications(){
        return $this->hasMany('App\Models\Application','projectID');
    }
    function projectFiles(){
        return $this->hasMany('App\Models\ProjectFiles','project_id');
    }
    function assignedStudents(){
        return $this->hasMany(User::class, 'assigned_project_id');
    }
}
