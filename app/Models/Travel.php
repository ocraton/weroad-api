<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Travel extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'isPublic',
        'slug',
        'name',
        'description',
        'numberOfDays',
        'numberOfNights',
        'moods',
    ];

    protected $casts = [
        'moods' => 'array',
    ];

    protected static function booted(): void
    {
        static::saving(function (Travel $travel) {
            $travel->slug = Str::slug($travel->name, '-');
        });
    }

    public function tours()
    {
        return $this->hasMany(Tour::class, 'travelId');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
