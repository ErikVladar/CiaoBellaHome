@props(['active' => false, 'type' => 'a'])

@php
$baseClasses = 'relative text-white after:content-[""] after:absolute after:bottom-0 after:left-0 after:h-[2px] after:w-0 after:bg-white after:transition-all after:duration-300 hover:after:w-full';
$activeClasses = 'bg-gray-900 px-3 py-2 text-sm font-medium text-white';
$inactiveClasses = $baseClasses;
@endphp

@if ($type == 'a')
    <a 
        class="{{ $active ? $activeClasses : $inactiveClasses }}"
        aria-current="{{ $active ? 'page' : 'false'}}"
        {{ $attributes }}
    >
        {{ $slot }}
    </a>
@else
    <button 
        class="{{ $active ? $activeClasses : $inactiveClasses }}"
        aria-current="{{ $active ? 'page' : 'false'}}"
        {{ $attributes }}
    >
        {{ $slot }}
    </button>
@endif
