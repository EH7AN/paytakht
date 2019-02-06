<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productcat extends Model
{
    protected $fillable = [
        'title'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function products()
    {
        return $this->hasMany('App\Product');
    }
}
