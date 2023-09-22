<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class say extends Model
{
    use HasFactory;
    protected $table = "says";
    protected $fillable = [
        'user_name','company_name','description'
    ];
}
