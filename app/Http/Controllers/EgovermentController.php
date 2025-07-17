<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EgovermentController extends Controller
{
    public function index()
    {
        return view('egoverment.dashboard');
    }
}
