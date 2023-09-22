<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class packageFetures extends Model
{
    use HasFactory;
    protected $table = "package_fetures";
    protected $fillable = [
        'package_id','name' ,'value'
    ];
}
