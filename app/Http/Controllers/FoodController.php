<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class FoodController extends Controller
{
    public function index()
    {
        return Inertia::render('Food', [
            'status' => session('status'),
        ]);
    }
}
