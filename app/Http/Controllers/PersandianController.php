<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PersandianController extends Controller
{
    public function index()
    {
        return view('persandian.dashboard');
    }
}
