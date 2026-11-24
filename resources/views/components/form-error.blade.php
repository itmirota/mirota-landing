@props(['name'])

@error($name)
    <p class="mt-1.5 flex items-start gap-2 rounded-md bg-red-50 px-3 py-2 text-sm font-medium text-red-700" role="alert">
        <svg class="mt-0.5 h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>
        </svg>
        <span>{{ $message }}</span>
    </p>
@enderror