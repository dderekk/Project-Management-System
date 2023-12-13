<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $table = 'application';

    protected $fillable = [
        'justification',
        'studentID',
        'projectID',
    ];
    

    function users(){
        return $this->belongsTo('App\Models\User','studentID');
    }
    function project(){
        return $this->belongsTo('App\Models\Project','projectID');
    }
}
