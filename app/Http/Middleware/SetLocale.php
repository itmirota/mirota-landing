<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {  
    $locale = $request->route('locale');

        app()->setLocale($locale);
        \Illuminate\Support\Carbon::setLocale($locale);
        URL::defaults(['locale' => $locale]);   // route('produk.index') otomatis ikut bahasa aktif
        $request->route()->forgetParameter('locale'); // controller tidak perlu menerima $locale

        return $next($request);
    }
}