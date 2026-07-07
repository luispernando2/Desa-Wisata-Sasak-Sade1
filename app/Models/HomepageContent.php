<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomepageContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'group',
        'key',
        'title',
        'subtitle',
        'body',
        'icon',
        'button_label',
        'button_url',
        'image_path',
        'image_url',
        'sort_order',
        'is_active',
        'meta',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'meta' => 'array',
        'sort_order' => 'integer',
    ];

    public static function groupOptions(): array
    {
        return [
            'hero' => 'Hero Beranda',
            'about' => 'Tentang Desa',
            'about_highlight' => 'Highlight Tentang',
            'home_menu' => 'Kartu Menu Beranda',
            'home_intro' => 'Intro Beranda',
            'home_culture' => 'Panel Budaya',
            'home_culture_item' => 'Item Budaya',
            'home_journey' => 'Judul Rute Pengalaman',
            'home_journey_step' => 'Langkah Rute Pengalaman',
            'home_packages' => 'Preview Paket',
            'home_events' => 'Preview Event',
            'home_market' => 'Preview Market',
            'home_gallery' => 'Preview Galeri',
            'home_reviews' => 'Preview Review',
            'home_cta' => 'CTA Beranda',
            'home_custom' => 'Konten Tambahan Beranda',
            'footer' => 'Footer',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('group')->orderBy('sort_order')->orderBy('id');
    }

    public function getGroupLabelAttribute(): string
    {
        return self::groupOptions()[$this->group] ?? $this->group;
    }

    public function getImageSrcAttribute(): ?string
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }

        if ($this->image_url) {
            if (preg_match('#^(https?:)?//#', $this->image_url)) {
                return $this->image_url;
            }

            return asset(ltrim($this->image_url, '/'));
        }

        return null;
    }
}
