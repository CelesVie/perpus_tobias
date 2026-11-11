@php
    $file = resource_path("views/components/icons/{$name}.svg");
    $svg = is_file($file) ? preg_replace('/<!--.*?-->/s', '', file_get_contents($file)) : '';
    $svg = trim((string) $svg);
@endphp

@if ($svg !== '')
    <span {{ $attributes->merge(['class' => 'inline-flex shrink-0']) }} aria-hidden="true">
        {!! str_replace('<svg', '<svg class="size-full"', $svg) !!}
    </span>
@endif
