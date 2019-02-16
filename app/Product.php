<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'summary', 'description',
        'media_id', 'code', 'price',
        'inventory','productcat_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany('App\Gallery');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo
     */
    public function category()
    {
        return $this->belongsTo('App\Productcat');
    }

    /**
     *
     */
    public function cover()
    {
        $this->belongsTo('App\Media');
    }
}
