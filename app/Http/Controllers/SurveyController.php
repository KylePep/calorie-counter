<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class SurveyController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        
        $account = $user->account;

        return Inertia::render('Survey/index', [
            'status' => session('status'),
            'account' => $account,
        ]);
    }
}
