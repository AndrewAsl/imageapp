<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anyimage extends Model
{
    protected $table = 'anyimages';
    protected $primaryKey = 'image_id';
    protected $fillable = [
        'is_active',
        'is_featured',
        'image_name',
        'image_path',
        'image_extension',
        'mobile_image_name',
        'mobile_image_path',
        'mobile_extension'
    ];
}
