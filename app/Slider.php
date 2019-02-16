<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title', 'link', 'image_media_id',
        'logo_media_id', 'type'
    ];
}
