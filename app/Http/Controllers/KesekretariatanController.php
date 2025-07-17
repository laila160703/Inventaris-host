<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KesekretariatanController extends Controller
{
    public function index()
    {
        return view('kesekretariatan.dashboard');
    }
}
