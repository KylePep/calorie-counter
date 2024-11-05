<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WeighIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeighInController extends Controller
{
    public function store(Request $request)
    {
        $user = User::find(Auth::id());

        $validated = $request->validate([
            'weight' => ['required', 'integer']
        ]);

        $weighIn = $user->weigh_ins()->create($validated);

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
