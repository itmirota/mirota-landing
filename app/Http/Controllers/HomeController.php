<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'products' => Product::orderByDesc('is_featured')->latest()->take(4)->get(),
            'articles' => Article::published()->latest('published_at')->take(3)->get(),
        ]);
    }
}