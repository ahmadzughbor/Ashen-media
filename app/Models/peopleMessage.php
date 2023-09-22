<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peopleMessage extends Model
{
    use HasFactory;

    protected $table = "people_messages";
    protected $fillable = [
        'first_name',
        'last_name',
        'Email',
        'Phone',
        'Message',
    ];
}
