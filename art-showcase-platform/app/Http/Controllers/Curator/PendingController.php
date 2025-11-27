<?php

namespace App\Http\Controllers\Curator;

use App\Http\Controllers\Controller;

class PendingController extends Controller
{
    public function index()
    {
        return view('curator.pending');
    }
}