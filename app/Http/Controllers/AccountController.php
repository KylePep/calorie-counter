<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();

        $account = $user->account;

        return Inertia::render('Account/Index', [
            'status' => session('status'),
            'account' => $account,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountRequest $request)
    {
        $validated  = $request->validate([
            'goal' => ['required'],
            'age' => ['required'],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'height' => ['required'],
            'weight' => ['required'],
            'activity' => ['required'],
        ]);
        
        // Get the signed-in user
        $user = $request->user();
        
        if (!$user->account){
            // Create the account for the authenticated user
            $account = $user->account()->create($validated);
        } else {
            $user->account->update($validated);
        }

        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Account $account)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {
        $validated = $request->validate([
            'goal' => [],
            'age' => [],
            'gender' => [Rule::in(['Male', 'Female'])],
            'height' => [],
            'weight' => [],
            'activity' => [],
        ]);

        $account->update($validated);

        return Redirect::route('account.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        //
    }
}
