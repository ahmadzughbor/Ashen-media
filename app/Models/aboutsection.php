<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class aboutsection extends Model
{
    use HasFactory;
    protected $table = "aboutsection";
    protected $fillable = [
        'path','description','description_ar'
    ];
}
