<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function index()
    {
        // $list = Listing::find(20);
        // $list->price = 3000;
        // $list->save();

        dd(Auth::user());
        return inertia('Index/Index', ['message'=>'This is Index Action']);
    }

    public function show()
    {
        return inertia('Index/Show', ['message'=>'This is Show Action']);   
    }
}
