@props(['job'])

@php $days = $job->daysLeft(); @endphp

@if($days !== null)
    <span class="inline-flex items-center gap-1.5 {{ $days <= 3 ? 'font-semibold text-accent' : 'text-slate-500' }}"
          title="{{ __('career.jobs.deadline') }}: {{ \Illuminate\Support\Carbon::parse($job->closing_date)->translatedFormat('d F Y') }}">
        <svg class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
        </svg>
        @if($days === 0)
            {{ __('career.jobs.closes_today') }}
        @elseif($days === 1)
            {{ __('career.jobs.closes_tomorrow') }}
        @else
            {{ __('career.jobs.closes_in', ['days' => $days]) }}
        @endif
    </span>
@endif