<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class package extends Model
{
    use HasFactory;
    protected $table = "packages";
    protected $fillable = [
        'name','amount'
    ];



    public function features()
    {
        return $this->hasMany(packageFetures::class ,'package_id');
    }
}

