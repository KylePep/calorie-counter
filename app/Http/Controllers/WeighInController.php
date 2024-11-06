<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WeighIn;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class WeighInController extends Controller
{
    public function store(Request $request)
    {
        $user = User::find(Auth::id());

        $account = $user->account;
        
        $validated = $request->validate([
            'weight' => ['required', 'integer'],
            'date' => ['string', 'nullable']
        ]);
        
            $userTimezone = $account->timezone;
            
            $givenDay = Carbon::parse($validated['date'], $userTimezone)->startOfDay()->setTimezone('UTC');

            $existsWeighIn = $user->weigh_ins()
            ->whereDate('created_at', $givenDay->toDateString())
            ->exists();

            if($existsWeighIn){
                return Redirect::route('history')->withErrors(['date' => 'A weigh in already exists for the selected date.']);
            }
            $weighIn = $user->weigh_ins()->create([
                'weight' => $validated['weight'],
                'created_at' => $givenDay
            ]);

        // Check carrot for weight requirement -> notify user of distance to carrot

        return back()->with([
            'success' => 'Weigh in recorded successfully',
            'weighIn' => $weighIn
        ]);
    }

    public function update(Request $request, WeighIn $weighIn)
    {
        $validated = $request->validate([
            'weight' => ['required', 'integer']
        ]);

        $weighIn->update($validated);

        //Recheck carrot for weight requirement -> notify user of distance to carrot

        return back()->with([
            'success' => 'Weigh in updated successfully',
            'weighIn' => $weighIn
        ]);
    }

    public function destroy(WeighIn $weighIn)
    {
        $user = User::find(Auth::id());
        if($user->weigh_ins()->where('id', $weighIn->id)->exists()){
            $weighIn->delete();
        }
        return redirect()->back();
    }
}
