<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_name',
        'rating',
        'comment',
        'event_id',
        'package_id',
        'user_id',
    ];

    public function packageTour()
    {
        return $this->belongsTo(PackageTour::class, 'package_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
