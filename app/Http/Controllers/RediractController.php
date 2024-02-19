<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RediractController extends Controller
{
    public  function organizaton()
    {
         return view('pages.dashboard.organizaton');
    }
}
