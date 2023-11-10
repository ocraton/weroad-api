<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'travelId',
        'name',
        'startingDate',
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

    protected function getPrice(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => ($value / 100),
        );
    }

    public function travel()
    {
        return $this->hasOne(Travel::class, 'id', 'travelId');
    }
}
