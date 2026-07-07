<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageTour extends Model
{
    use HasFactory;

    protected $table = 'package_tours';

    protected $fillable = [
        'title',
        'price',
        'duration',
        'description',
        'features',
        'tour_guide_id',
    ];

    public function tourGuide()
    {
        return $this->belongsTo(TourGuide::class, 'tour_guide_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'package_id');
    }
}


