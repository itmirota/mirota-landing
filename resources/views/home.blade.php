@extends('layouts.app')

@section('content')
    <x-hero />
    <x-sections.keunggulan />
    <x-sections.about-teaser />
    <x-sections.featured-products :products="$products" />
    <x-sections.maklon-highlight />
    <x-sections.latest-articles :articles="$articles" />
    <x-sections.cta-contact />
@endsection