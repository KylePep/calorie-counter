<?php

namespace App\Http\Controllers;

use App\Models\Carrot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
            'success' => 'Carrot created successfully!',
            'carrot' => $carrot,
        ]);
    }

    public function update(Request $request, Carrot $carrot)
    {

        Gate::authorize('update', $carrot);

        $attributes = $request->validate([
            'description' => ['required'],
            'goalPost' => ['required'],
            'value'  => ['required'],
            'category'  => ['required'],
            'complete' => ['required'],
        ]);

        $carrot->update($attributes);

        return back()->with([
            'success' => 'Carrot updated successfully!',
            'carrot' => $carrot,
        ]);
    }

    public function destroy( Carrot $carrot)
    {
        Gate::authorize('delete', $carrot);

        $user = User::find(Auth::id());

        if($user->carrots()->where('id', $carrot->id)->exists()){
            $carrot->delete();
        } 
        return redirect()->back();
    }
}
