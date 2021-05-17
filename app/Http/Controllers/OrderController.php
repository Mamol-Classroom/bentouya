<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class OderController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();
        $user_id = Auth::id();
    }
