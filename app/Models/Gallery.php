<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_url',
        'image_path',
        'caption',
        'uploaded_at',
    ];

    public $timestamps = false;
}
