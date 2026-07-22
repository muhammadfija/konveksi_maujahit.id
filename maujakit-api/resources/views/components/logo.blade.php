@props([
    'variant' => 'dark',
    'size' => 'md',
    'showText' => true,
    'href' => '/',
    'class' => ''
])

@php
    $sizes = [
        'sm' => ['img' => 36, 'title' => 'text-sm', 'sub' => 'text-[9px]'],
        'md' => ['img' => 44, 'title' => 'text-base', 'sub' => 'text-[10px]'],
        'lg' => ['img' => 64, 'title' => 'text-xl', 'sub' => 'text-xs'],
    ];
    $s = $sizes[$size];
    $textColor = $variant === 'light' ? 'text-white' : 'text-[#1e3a6e]';
    $subColor = $variant === 'light' ? 'text-white/50' : 'text-gray-500';
@endphp

@if($href)
    <a href="{{ $href }}" class="hover:opacity-90 transition-opacity">
@endif

    <div class="flex items-center gap-2.5 {{ $class }}">
        <img 
            src="{{ asset('logo.png') }}" 
            alt="MauJahit.id Logo" 
            width="{{ $s['img'] }}" 
            height="{{ $s['img'] }}" 
            class="rounded-xl flex-shrink-0 object-cover"
        >
        @if($showText)
            <div>
                <div class="font-black tracking-wide leading-tight {{ $s['title'] }} {{ $textColor }}">
                    MAUJAHIT.ID
                </div>
                <div class="font-medium tracking-widest uppercase {{ $s['sub'] }} {{ $subColor }}">
                    Clothing Vendor
                </div>
            </div>
        @endif
    </div>

@if($href)
    </a>
@endif
