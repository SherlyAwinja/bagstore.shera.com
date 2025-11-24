<?php

namespace App\Http\Controllers;

use App\Models\HomePageSetting;
use illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        $homepagesetting = HomePageSetting::with([
            'discountedProduct.images',
            'featuredProduct1.images',
            'featuredProduct2.images',
        ])->first();
        return view('home.index', compact('homepagesetting'));
    }
}
