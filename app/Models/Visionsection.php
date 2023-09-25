<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visionsection extends Model
{
    use HasFactory;
    protected $table = "visionsection";
    protected $fillable = [
        'path','description','description_ar'
    ];
}
