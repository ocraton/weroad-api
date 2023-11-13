<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Travel extends Model
{
    use HasFactory, HasSlug, HasUuids;

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

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
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
