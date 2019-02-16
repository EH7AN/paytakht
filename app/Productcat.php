<?php

namespace App;

use Carbon\Carbon;
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

    /**
     * @param $date
     * @return float|int
     */
    protected function getCreatedAtAttribute($date)
    {
        $dt = Carbon::parse($date);
        return $dt->timestamp * 1000;
    }

}
