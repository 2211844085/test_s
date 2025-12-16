<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function store(DonationRequest $request)
    {
        $data = $request->validated();

        $tier = Tier::findOrFail($data['tier_id']);

        $donation = Donation::create([
            'backer_id' => auth()->user()->id,
            'tier_id' => $tier->id,
            'amount' => $tier->amount
        ]);

        if ($tier->project->funding_goal <= $tier->project->tiers->flatMap->donations->sum('amount')) {
            $tier->project->update([
                'status' => 'achieved'
            ]);
            foreach ($tier->project->tiers->flatMap->donations->map->backer->unique('id') as $backer) {
                $backer->notify('milestone', $tier->project);
            }
        }

        return redirect()->back();
    }
}
