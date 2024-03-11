<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\ListingImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealtorListingImageController extends Controller
{
    public function create(Listing $listing)
    {
        $listing->load(['images']);
        return inertia(
            'Realtor/ListingImage/Create',
            ['listing' => $listing]
        );
    }

    public function store(Listing $listing, Request $request)
    {
        if ($request->hasFile('images')) {
            $request->validate([
                'images.*' => 'mimes:jpg,png,jpeg|max:5000' // 5mb filesize
            ], [
                'images.*.mimes' => 'The file should be in one of the formats: jpg, png, jpeg, webp'
            ]);

            foreach ($request->file('images') as $image) {
                $path = $image->store('image', 'public');
                $listing->images()->save(
                    new ListingImages([
                        'filename' => $path
                    ])
                );
            }
        }

        return redirect()->back()->with('message', 'Image is uploaded successfully!');
    }

    public function destroy(Listing $listing, ListingImages $image)
    {
        Storage::disk('public')->delete($image->filename);
        $image->delete();

        return redirect()->back()->with('message', 'Image deleted!');
    }
}
