<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Observers\TestObserver;

class Test extends Model
{
    use SoftDeletes;

    protected $fillable = [
        // Specify your fillable fields here...
    ];

   

    /**
     * Eager load with every debt.
     */

    protected $with = [
       // Eager load
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public static function booted()
    {
        static::observe(new TestObserver());
    }

    /**
     * Relationships
     */

        // RELATIONSHIPS HERE

    /**
     * Methods
     */

       // Methods HERE
}