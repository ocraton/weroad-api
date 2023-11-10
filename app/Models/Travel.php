<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'travels';

    protected $fillable = [
        'isPublic',
        'slug',
        'name',
        'description',
        'numberOfDays',
        'numberOfNights',
        'moods'
    ];

    protected $casts = [
        'moods' => 'array'
    ];

    protected static function booted(): void
    {
        static::creating(function (Travel $travel) {
            $travel->numberOfNights = $travel->numberOfDays - 1;
        });

        static::updating(function (Travel $travel) {
            $travel->numberOfNights = $travel->numberOfDays - 1;
        });
    }


}
