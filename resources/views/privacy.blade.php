@extends('layouts.app')
@section('title', __('privacy.title').' | PT Mirota KSM')

@section('content')
<x-page-header :title="__('privacy.title')" :subtitle="__('privacy.updated')" :label="__('footer.privacy')" />

<section class="bg-white py-16">
    <div class="container mx-auto grid max-w-6xl gap-10 px-6 lg:grid-cols-4">

        {{-- Daftar isi --}}
        <aside class="lg:sticky lg:top-28 lg:self-start">
            <p class="text-sm font-bold uppercase tracking-wider text-primary">{{ __('privacy.toc') }}</p>
            <ol class="mt-4 space-y-2 text-sm">
                @foreach(trans('privacy.sections') as $i => $s)
                    <li><a href="#s{{ $i + 1 }}" class="text-slate-600 hover:text-accent">{{ $i + 1 }}. {{ $s['title'] }}</a></li>
                @endforeach
            </ol>
        </aside>

        <div class="lg:col-span-3">
            

            @foreach(trans('privacy.sections') as $i => $s)
                <article id="s{{ $i + 1 }}" class="mb-10 scroll-mt-28">
                    <h2 class="text-2xl font-bold text-primary">{{ $i + 1 }}. {{ $s['title'] }}</h2>
                    <p class="mt-3 leading-relaxed text-slate-700">{{ $s['text'] }}</p>
                    @if(!empty($s['items']))
                        <ul class="mt-3 list-disc space-y-1.5 pl-6 text-slate-700">
                            @foreach($s['items'] as $item) <li>{{ $item }}</li> @endforeach
                        </ul>
                    @endif
                </article>
            @endforeach
        </div>
    </div>
</section>
@endsection