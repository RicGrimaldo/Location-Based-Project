<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ubication extends Model
{
    protected $fillable = [
            'tag',
            'file',
            'file_type',
            'latitude',
            'longitude',
            'text',
    ];
}
