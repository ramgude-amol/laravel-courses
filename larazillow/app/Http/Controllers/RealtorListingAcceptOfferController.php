<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;

class RealtorListingAcceptOfferController extends Controller
{
    public function __invoke(Offer $offer)
    {
        $listing = $offer->listing;
        $this->authorize('update', $listing);
        $offer->update(['accepted_at' => now()]);

        $offer->listing
            ->offers()
            ->except($offer)
            ->update([
                'rejected_at' => now()
            ]);

        $listing->sold_at = now();
        $listing->save();

        return redirect()->back()->with('message', "Offer #{$offer->id} accepted!");
    }
}
