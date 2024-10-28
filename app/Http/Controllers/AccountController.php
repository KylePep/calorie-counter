<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\User;
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
        //
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
            'goal' => ['required', 'integer'],
            'goalModifier' => ['required', 'integer'],
            'carrot' => ['string'],
            'age' => ['required', 'integer'],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'height' => ['required', 'numeric'],
            'weight' => ['required', 'integer'],
            'activity' => ['required', 'string'],
            'timezone' => ['required', 'string'],
        ]);
        
        // Get the signed-in user
        $user = $request->user();
        
        if (!$user->account){
            // Create the account for the authenticated user
            $user->account()->create($validated);
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
        $user = User::find(Auth::id());

        $account = $user->account;

        $calorieDays = $user->calorieDays() //TODO - Return only calorieDays that date back within 7 days
        ->orderBy('created_at', 'desc') 
        ->take(7) 
        ->get();

        $account->carrot = json_decode($account->carrot, true);

        return Inertia::render('Account/Show', [
            'status' => session('status'),
            'account' => $account,
            'calorieDays' => $calorieDays,
        ]);
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
            'goalModifier' => [],
            'carrot' => [],
            'age' => [],
            'gender' => [Rule::in(['Male', 'Female'])],
            'height' => [],
            'weight' => [],
            'activity' => [],
            'timezone' => [],
        ]);

        $account->update($validated);

        return Redirect::route('account.show');
    }

    public function updateCarrot(UpdateAccountRequest $request, Account $account)
    {
        $validated = $request->validate([
            'carrot' => [],
        ]);

        $existingCarrots = json_decode($account->carrot, true) ?? [];

        $account->carrot = json_encode(array_merge($existingCarrots, $validated['carrot']));

        $account->save();


        return Redirect::route('account.show');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Account $account)
    {
        //
    }
}
