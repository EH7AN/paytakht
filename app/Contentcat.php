<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contentcat extends Model
{
    protected $fillable = [
        'title'
    ];
    public function contents()
    {
        return $this->hasMany('App\Content');
    }
}
