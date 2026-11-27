<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Product;
use App\Models\HomeBanner;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'banners'  => HomeBanner::where('is_published', true)->orderBy('sort_order')->get(),
            'products' => Product::orderByDesc('is_featured')->latest()->take(4)->get(),
            'articles' => Article::published()->latest('published_at')->take(3)->get(),
        ]);
    }
}