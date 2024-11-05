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
            'bmr' => ['required', 'integer'],
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
        
        $user = $request->user();

        $latestCalorieDay = $user->calorieDays()->orderBy('created_at', 'desc')->first();

        if($latestCalorieDay){
            $latestCalorieDay->goal = $validated['goal'];
            $latestCalorieDay->bmr = $validated['bmr'];
            $latestCalorieDay->save();
        }
        
        if (!$user->account){
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

        $carrots = $user->carrots()->get();


        return Inertia::render('Account/Show', [
            'status' => session('status'),
            'carrots' => $carrots,
            'account' => $account,
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

        $user = User::find(Auth::id());

        $validated = $request->validate([
            'goal' => ['integer'],
            'goalModifier' => ['integer'],
            'bmr' => ['integer'],
            'age' => ['integer'],
            'gender' => [Rule::in(['Male', 'Female'])],
            'height' => ['numeric'],
            'weight' => ['numeric'],
            'activity' => ['string'],
            'theme' => ['string'],
            'timezone' => ['string'],
        ]);

        $latestCalorieDay = $user->calorieDays()->orderBy('created_at', 'desc')->first();

        if($latestCalorieDay){
            $latestCalorieDay->goal = $validated['goal'];
            $latestCalorieDay->bmr = $validated['bmr'];
            $latestCalorieDay->save();
        }

        $account->update($validated);

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
