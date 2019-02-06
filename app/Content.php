<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    protected $fillable = [
        'title', 'summary', 'description', 'media_id'
    ];
    public function category()
    {
        return $this->belongsTo('App\Contentcat');
    }
}

