<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class missionsection extends Model
{
    use HasFactory;
    protected $table = "missionsection";
    protected $fillable = [
        'path','description','description_ar'
    ];
}
