<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use HasFactory;
    protected $table = "statistics";
    protected $fillable = [
        'num1','section1',
        'num2','section2',
        'num3','section3',
        'num4','section4',
    ];
}
