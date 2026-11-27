@props(['name', 'label', 'type' => 'text', 'value' => null])

@php $id = $attributes->get('id', $name); @endphp

<div>
    <div class="relative rounded-lg border border-slate-200 bg-white shadow-sm transition focus-within:border-primary focus-within:ring-2 focus-within:ring-primary/20">
        <input id="{{ $id }}" type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}" placeholder=" "
               {{ $attributes->except('id')->merge(['class' => 'peer w-full bg-transparent px-5 pb-2 pt-6 text-slate-700 outline-none']) }}>

        <label for="{{ $id }}"
               class="pointer-events-none absolute left-5 top-1.5 max-w-[calc(100%-2.5rem)] truncate text-xs text-slate-500 transition-all duration-150 peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-focus:top-1.5 peer-focus:text-xs">
            {{ $label }}
        </label>
    </div>

    {{ $slot }}

    <x-form-error :name="$name" />
</div>