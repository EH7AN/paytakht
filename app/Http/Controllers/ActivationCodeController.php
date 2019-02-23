<?php

namespace App\Http\Controllers;

use App\ActivationCode;
use Illuminate\Http\Request;

class ActivationCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
}
