<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderByDesc('is_featured')->latest()->get();

        return view('produk.index', compact('products'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        $related = Product::where('id', '!=', $product->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('produk.show', compact('product', 'related'));
    }
}