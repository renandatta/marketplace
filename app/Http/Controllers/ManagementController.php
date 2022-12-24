<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('management');
    }

    public function index()
    {
        Session::put('menu_active', 'home');
        return view('layouts.management');
    }
}
