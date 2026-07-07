<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_CONFIRMED = 'confirmed';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'package_id',
        'visit_date',
        'guests',
        'message',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'visit_date' => 'date',
        ];
    }

    public static function statusOptions(): array
    {
        return [
            self::STATUS_PENDING => 'Menunggu Konfirmasi',
            self::STATUS_CONFIRMED => 'Dikonfirmasi',
            self::STATUS_COMPLETED => 'Selesai',
            self::STATUS_CANCELLED => 'Dibatalkan',
        ];
    }

    public function getStatusLabelAttribute(): string
    {
        return self::statusOptions()[$this->status] ?? 'Menunggu Konfirmasi';
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_CONFIRMED => 'bg-primary',
            self::STATUS_COMPLETED => 'bg-success',
            self::STATUS_CANCELLED => 'bg-danger',
            default => 'bg-warning text-dark',
        };
    }

    public function getWhatsappUrlAttribute(): ?string
    {
        $number = $this->normalizedWhatsappNumber();

        if (! $number) {
            return null;
        }

        $packageName = $this->package?->title ?? 'paket wisata';
        $visitDate = $this->visit_date?->translatedFormat('d M Y') ?? $this->visit_date;
        $message = "Halo {$this->name}, kami dari Admin Desa Wisata Sasak Sade ingin mengonfirmasi booking {$packageName} untuk tanggal {$visitDate}.";

        return 'https://wa.me/'.$number.'?text='.rawurlencode($message);
    }

    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    public function canBeReviewed(): bool
    {
        return $this->isCompleted();
    }

    public function package()
    {
        return $this->belongsTo(PackageTour::class, 'package_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function review()
    {
        return $this->hasOne(BookingReview::class, 'booking_id');
    }

    private function normalizedWhatsappNumber(): ?string
    {
        $number = preg_replace('/\D+/', '', $this->phone ?? '');

        if (! $number) {
            return null;
        }

        if (str_starts_with($number, '0')) {
            return '62'.substr($number, 1);
        }

        if (str_starts_with($number, '8')) {
            return '62'.$number;
        }

        return $number;
    }
}
