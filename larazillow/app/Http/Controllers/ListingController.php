<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\Offer;
use Auth;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth")->except(['index', 'show']);
        $this->authorizeResource(Listing::class, 'listing');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // return inertia('Listing/Index', ['listings' => Listing::all()]);
        $filters = $request->only([
            'priceFrom', 'priceTo', 'beds', 'baths', 'areaFrom', 'areaTo'
        ]);

        /*if ($filters['priceFrom'] ?? false) {
            $query = $query->where('price', '>=', $filters['priceFrom']);
        }*/


        $query = Listing::mostRecent()
            ->filter($filters)
            ->withoutSold()
            ->paginate(5)
            ->withQueryString();

        return inertia('Listing/Index', [
            'filters' => $filters,
            'listings' => $query
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        /*if(Auth::user()->cannot('view', $listing)){
            abort(403);
        }*/
        // $this->authorize('view', $listing);
        $offer = !Auth::user() ? null : $listing->offers()->byMe()->first();

        $listing->load(['images']);
        return inertia('Listing/Show', [
            'listing' => $listing,
            'offerMade' => $offer
        ]);
    }
}
