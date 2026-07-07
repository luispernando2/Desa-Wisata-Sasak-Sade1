<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    public const STATUS_SCHEDULED = 'scheduled';

    public const STATUS_ONGOING = 'ongoing';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'name',
        'description',
        'date',
        'time',
        'location',
        'image_path',
        'tour_guide_id',
        'status',
    ];

    public static function statusOptions(): array
    {
        return [
            self::STATUS_SCHEDULED => 'Terjadwal',
            self::STATUS_ONGOING => 'Berlangsung',
            self::STATUS_COMPLETED => 'Selesai',
            self::STATUS_CANCELLED => 'Dibatalkan',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusOptions()[$this->status] ?? 'Terjadwal';
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_ONGOING => 'bg-primary',
            self::STATUS_COMPLETED => 'bg-secondary',
            self::STATUS_CANCELLED => 'bg-danger',
            default => 'bg-success',
        };
    }

    public function tourGuide()
    {
        return $this->belongsTo(TourGuide::class, 'tour_guide_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'event_id');
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }
}
