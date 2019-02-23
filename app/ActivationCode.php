<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivationCode extends Model
{
    protected $fillable = ['phone_number', 'activation_code',
        'expiration_time', 'is_active'];
}
