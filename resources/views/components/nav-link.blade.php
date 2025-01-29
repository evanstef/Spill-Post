@props(['active'])

@php
$classes = ($active ?? false)
            ? 'bg-blue-600 px-4 py-5 sm:py-3 text-white sm:text-sm md:text-xl lg:text-2xl hover:cursor-pointer'
            : 'hover:bg-blue-600 hover:text-white hover:cursor-pointer px-4 py-5 sm:py-3 text-white sm:text-sm md:text-xl lg:text-2xl duration-300 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
