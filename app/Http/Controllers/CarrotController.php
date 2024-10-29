<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarrotController extends Controller
{
    public function store(Request $request)
    {
        $user = User::find(Auth::id());
    
        $attributes = $request->validate([
            'description' => ['required'],
            'goalPost' => ['required'],
            'value'  => ['required'],
            'category'  => ['required'],
            'complete' => ['required'],
        ]);

        $carrot = $user->carrots()->create($attributes);

        return back()->with([
            'success' => 'Food item created successfully!',
            'carrot' => $carrot,
        ]);
    }
}
