<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';

    protected $fillable = [
        'GPA',
        'studentID',
        'softwareDeveloper',
        'projectManager',
        'businessAnalyst',
        'tester',
        'clientLiaison',
    ];

    function users(){
        return $this->belongsTo('App\Models\User','studentID');
    }
}
