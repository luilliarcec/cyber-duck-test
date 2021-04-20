<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'logo',
        'website',
    ];

    public function getLogoUrlAttribute(): ?string
    {
        if ($this->logo) {
            return Storage::url($this->logo);
        }

        return null;
    }
}
