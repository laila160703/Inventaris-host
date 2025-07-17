<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IkpController extends Controller
{
    public function index()
    {
        return view('ikp.dashboard');
    }
}
