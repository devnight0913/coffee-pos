<div {{ $attributes->merge(['class' => 'card shadow-sm border-0 rounded-3 w-100']) }}>
    <div class="px-4 py-4">
        {{ $slot }}
    </div>
</div>
