<?php

namespace App\Models;

use App\Traits\HasMoney;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory, HasMoney, HasUuids;

    protected $fillable = [
        'travelId',
        'name',
        'startingDate',
        'endingDate',
        'price',
    ];

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getMoneyFromDatabase($value),
            set: fn ($value) => $this->saveMoneyToDatabase($value)
        );
    }

    public function travel()
    {
        return $this->hasOne(Travel::class, 'id', 'travelId');
    }
}
