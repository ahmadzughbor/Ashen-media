<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class settings extends Model
{
    use HasFactory;
    protected $table = "settings";
    protected $fillable = [
        'whatsappLink',
        'facebookLink',
        'twitterLink',
        'instagramLink',
        'tiktokLink',
        'snapchatLink',
        'app_logo'
    ];

}
