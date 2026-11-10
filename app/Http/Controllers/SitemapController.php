<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\JobVacancy;
use App\Models\Product;

class SitemapController extends Controller
{
    public function __invoke()
    {
        $static = collect([
            '', 'tentang-kami/sejarah', 'tentang-kami/visi-misi-budaya', 'tentang-kami/kebijakan-mutu',
            'tentang-kami/penghargaan', 'produk', 'maklon', 'kunjungan-industri',
            'karir/benefit', 'karir/tim', 'karir/lowongan', 'artikel', 'kontak', 'kebijakan-privasi',
        ])->map(fn ($p) => ['path' => $p, 'lastmod' => null]);

        $products = Product::select('slug', 'updated_at')->get()
            ->map(fn ($m) => ['path' => 'produk/'.$m->slug, 'lastmod' => $m->updated_at]);

        $articles = Article::published()->select('slug', 'updated_at')->get()
            ->map(fn ($m) => ['path' => 'artikel/'.$m->slug, 'lastmod' => $m->updated_at]);

        $jobs = JobVacancy::open()->select('slug', 'updated_at')->get()
            ->map(fn ($m) => ['path' => 'karir/lowongan/'.$m->slug, 'lastmod' => $m->updated_at]);

        $urls = $static->concat($products)->concat($articles)->concat($jobs);

        $locales = ['id', 'en'];
        $link    = fn (string $loc, string $path) => url(trim($loc.'/'.$path, '/'));

        $xml  = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">'."\n";

        foreach ($urls as $u) {
            foreach ($locales as $loc) {
                $xml .= "  <url>\n";
                $xml .= '    <loc>'.e($link($loc, $u['path']))."</loc>\n";

                foreach ($locales as $alt) {
                    $xml .= '    <xhtml:link rel="alternate" hreflang="'.$alt.'" href="'.e($link($alt, $u['path']))."\"/>\n";
                }

                if ($u['lastmod']) {
                    $xml .= '    <lastmod>'.$u['lastmod']->toAtomString()."</lastmod>\n";
                }

                $xml .= "  </url>\n";
            }
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}