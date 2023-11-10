<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tour extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'travel_id',
        'name',
        'startingSate',
        'endingDate',
        'price',
    ];

    protected static function booted(): void
    {
        static::creating(function (Tour $tour) {
            $tour->price = $tour->price * 100;
        });

        static::updating(function (Tour $tour) {
            $tour->price = $tour->price * 100;
        });
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => $value/100,
        );
    }
}
