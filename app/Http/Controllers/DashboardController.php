<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $account = $user->account;

        // Pass the data to the Inertia view
        return Inertia::render('Dashboard', [
            'account' => $account,
        ]);
    }
}
