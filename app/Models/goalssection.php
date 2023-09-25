<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class goalssection extends Model
{
    use HasFactory;
    protected $table = "goalssection";
    protected $fillable = [
        'path','description','description_ar'
    ];
}

