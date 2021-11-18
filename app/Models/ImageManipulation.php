<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageManipulation extends Model
{
    use HasFactory;

    const TYPE_RESIZE = 1;
    const TYPE_OPTIMIZE = 2;
    const TYPE_CONVERSION = 3;

    const UPDATED_AT = null;

    protected $fillable = [
        'type',
        'name',
        'path',
        'data',
        'output_path',
        'user_id',
        'album_id'
    ];

}
