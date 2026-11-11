@props(['title' => 'Belum ada data', 'description' => null, 'icon' => 'inbox'])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center rounded-xl border border-dashed border-line bg-surface/60 px-6 py-12 text-center']) }}>
    <span class="grid size-12 place-items-center rounded-full bg-primary-ghost text-muted">
        <x-icon :name="$icon" class="size-6" />
    </span>
    <p class="mt-4 font-semibold">{{ $title }}</p>
    @if ($description)
        <p class="mt-1 max-w-sm text-sm text-muted">{{ $description }}</p>
    @endif
    @isset($action)
        <div class="mt-5">{{ $action }}</div>
    @endisset
</div>
