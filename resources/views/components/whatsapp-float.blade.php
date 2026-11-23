
@props(['href'])

<div
    x-data="{ show: false, closed: false }"
    x-init="setTimeout(() => show = true, 4000)"
    class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3"
>

    {{-- Gelembung sapaan --}}
    <div
        x-show="show && !closed"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-3 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative w-72 max-w-[calc(100vw-3rem)] rounded-2xl border border-slate-100 bg-white p-4 shadow-xl"
    >

        {{-- Tombol tutup --}}
        <button
            type="button"
            @click="closed = true"
            aria-label="Close"
            class="absolute right-3 top-3 flex h-7 w-7 items-center justify-center rounded-full text-slate-400 transition hover:bg-slate-100 hover:text-slate-700"
        >
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="2"
                 stroke-linecap="round">
                <path d="M6 6l12 12M18 6L6 18"/>
            </svg>
        </button>

        {{-- Teks sapaan --}}
        <div class="pr-5">
            <p class="text-sm font-bold text-primary-dark">
                {{ __('maklon.wa_title') }}
            </p>

            <p class="mt-1.5 text-xs leading-relaxed text-slate-500">
                {{ __('maklon.wa_text') }}
            </p>
        </div>

        {{-- Tombol WhatsApp --}}
        <a
            href="{{ $href }}"
            target="_blank"
            rel="noopener noreferrer"
            class="mt-4 flex items-center justify-center gap-2.5 rounded-xl bg-[#25D366] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#1ebe5d] hover:shadow-md"
        >
            {{-- Logo WhatsApp --}}
            <svg viewBox="0 0 24 24" class="h-5 w-5 shrink-0" fill="currentColor" aria-hidden="true">
                <path d="M20.52 3.48A11.85 11.85 0 0 0 12.08 0C5.48 0 .1 5.37.1 11.98c0 2.11.55 4.17 1.6 5.98L0 24l6.19-1.62a11.98 11.98 0 0 0 5.88 1.5h.01c6.61 0 11.99-5.38 11.99-11.99a11.9 11.9 0 0 0-3.55-8.41ZM12.08 21.85a9.9 9.9 0 0 1-5.04-1.38l-.36-.21-3.67.96.98-3.58-.23-.37a9.86 9.86 0 0 1-1.52-5.29c0-5.44 4.43-9.87 9.88-9.87a9.8 9.8 0 0 1 6.98 2.9 9.8 9.8 0 0 1 2.89 6.99c0 5.45-4.43 9.88-9.87 9.88Zm5.42-7.4c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.16-.18.2-.35.22-.65.08-.3-.15-1.26-.47-2.4-1.48-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.91-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.06 2.88 1.21 3.08c.15.2 2.1 3.2 5.08 4.49.71.3 1.26.49 1.69.62.71.23 1.36.2 1.87.12.57-.08 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.42-.07-.12-.27-.2-.57-.35Z"/>
            </svg>

            {{ __('maklon.wa_button') }}
        </a>
    </div>

    {{-- Tombol WhatsApp mengambang --}}
    <a
        href="{{ $href }}"
        target="_blank"
        rel="noopener noreferrer"
        aria-label="{{ __('maklon.wa_button') }}"
        class="group flex h-14 w-14 items-center justify-center rounded-full bg-[#25D366] text-white shadow-lg shadow-green-900/20 transition duration-300 hover:scale-110 hover:bg-[#1ebe5d] hover:shadow-xl"
    >

        <svg viewBox="0 0 24 24"
             class="h-8 w-8"
             fill="currentColor"
             aria-hidden="true">
            <path d="M20.52 3.48A11.85 11.85 0 0 0 12.08 0C5.48 0 .1 5.37.1 11.98c0 2.11.55 4.17 1.6 5.98L0 24l6.19-1.62a11.98 11.98 0 0 0 5.88 1.5h.01c6.61 0 11.99-5.38 11.99-11.99a11.9 11.9 0 0 0-3.55-8.41ZM12.08 21.85a9.9 9.9 0 0 1-5.04-1.38l-.36-.21-3.67.96.98-3.58-.23-.37a9.86 9.86 0 0 1-1.52-5.29c0-5.44 4.43-9.87 9.88-9.87a9.8 9.8 0 0 1 6.98 2.9 9.8 9.8 0 0 1 2.89 6.99c0 5.45-4.43 9.88-9.87 9.88Zm5.42-7.4c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.97-.94 1.16-.18.2-.35.22-.65.08-.3-.15-1.26-.47-2.4-1.48-.88-.79-1.48-1.76-1.65-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.03-.52-.07-.15-.67-1.61-.91-2.21-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.79.37-.27.3-1.04 1.02-1.04 2.48s1.06 2.88 1.21 3.08c.15.2 2.1 3.2 5.08 4.49.71.3 1.26.49 1.69.62.71.23 1.36.2 1.87.12.57-.08 1.76-.72 2.01-1.41.25-.7.25-1.29.17-1.42-.07-.12-.27-.2-.57-.35Z"/>
        </svg>

    </a>
</div>
