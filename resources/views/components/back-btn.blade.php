@props(['href' => '#'])

<a href="{{ $href }}" {!! $attributes->merge([
    'class' => 'bg-dark border shadow-sm d-flex justify-content-center p-1 align-items-center rounded-circle',
]) !!} style="width:2.5rem;height:2.5rem;">
    @if ($settings->dir == 'rtl')
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="hero-icon text-white">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15m0 0l6.75 6.75M4.5 12l6.75-6.75" />
        </svg>
    @else
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="hero-icon text-white">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
        </svg>
    @endif
</a>
