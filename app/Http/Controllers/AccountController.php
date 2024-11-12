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
            'bmr' => ['required', 'numeric'],
            'goal' => ['required', 'numeric'],
            'goalModifier' => ['required', 'numeric'],
            'carrot' => ['string'],
            'age' => ['required', 'numeric'],
            'gender' => ['required', Rule::in(['Male', 'Female'])],
            'height' => ['required', 'numeric'],
            'weight' => ['required', 'numeric'],
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
            'goal' => ['numeric'],
            'goalModifier' => ['numeric'],
            'bmr' => ['numeric'],
            'age' => ['numeric'],
            'gender' => [Rule::in(['Male', 'Female'])],
            'height' => ['numeric'],
            'weight' => ['numeric'],
            'activity' => ['string'],
            'theme' => ['string'],
            'timezone' => ['string'],
            'trackMacros' => ['boolean'],
            'macros.carbohydrates' => ['numeric', 'min:0'],
            'macros.protein' => ['numeric', 'min:0'],
            'macros.fats' => ['numeric', 'min:0'],
            'macros' => ['json']
        ]);

        $macros = [
            'carbohydrates' => $validated['macros']['carbohydrates'] ?? 0,
            'protein' => $validated['macros']['protein'] ?? 0,
            'fats' => $validated['macros']['fats'] ?? 0,
        ];

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
