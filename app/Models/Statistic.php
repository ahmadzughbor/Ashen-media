<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;
    protected $table = "statistics";
    protected $fillable = [
        'num1','section1','section1_ar',
        'num2','section2','section2_ar',
        'num3','section3','section3_ar',
        'num4','section4','section4_ar',
    ];
}
