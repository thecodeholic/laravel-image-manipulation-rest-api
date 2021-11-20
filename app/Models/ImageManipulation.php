<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageManipulation extends Model
{
    use HasFactory;

    const TYPE_RESIZE = 'resize';
    const TYPE_OPTIMIZE = 'optimize';
    const TYPE_CONVERSION = 'convert';

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
