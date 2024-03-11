<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RealtorListingController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Listing::class, 'listing');
    }

    public function index(Request $request)
    {
        $filters = [
            'deleted' => $request->boolean('deleted'),
            ...$request->only(['by', 'order'])
        ];
        return inertia('Realtor/Index', [
            'listings' => Auth::user()
                ->listings()
                // ->mostRecent()
                ->filter($filters)
                ->withCount('images')
                ->withCount('offers')
                ->paginate(10)
                ->withQueryString(),
            'filters' => $filters
        ]);
    }

    public function show(Listing $listing)
    {
        return inertia('Realtor/Show', [
            'listing' => $listing->load('offers', 'offers.bidder')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Realtor/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->user()->listings()->create(
            // Listing::create(
            $request->validate([
                'beds' => 'required|integer|min:1|max:20',
                'baths' => 'required|integer|min:1|max:20',
                'area' => 'required|integer|min:1|max:1500',
                'city' => 'required',
                'code' => 'required',
                'street' => 'required',
                'street_nr' => 'required|integer|min:1|max:1000',
                'price' => 'required|integer|min:1|max:1000000',
            ])
        );

        return redirect()->route('realtor.listing.index')->with('message', 'Listing is created');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        return inertia('Realtor/Edit', ['listing' => $listing]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        $listing->update(
            $request->validate([
                'beds' => 'required|integer|min:1|max:20',
                'baths' => 'required|integer|min:1|max:20',
                'area' => 'required|integer|min:1|max:1500',
                'city' => 'required',
                'code' => 'required',
                'street' => 'required',
                'street_nr' => 'required|integer|min:1|max:1000',
                'price' => 'required|integer|min:1|max:1000000',
            ])
        );

        return redirect()->route('realtor.listing.index')->with('message', 'Listing is edited');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        $listing->delete();

        return redirect()->back()
            ->with('message', 'Listing record is deleted');
    }

    public function restore(Listing $listing)
    {
        $listing->restore();

        return redirect()->back()
            ->with('message', 'Listing record is deleted');
    }
}
