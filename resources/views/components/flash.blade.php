@if (session('status') || session('error'))
    <div class="pointer-events-none fixed inset-x-0 top-20 z-50 flex justify-center px-4">
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 5000)"
            x-show="show"
            x-transition.opacity
            role="status"
            class="pointer-events-auto flex max-w-md items-start gap-3 rounded-xl border px-4 py-3 text-sm shadow-lg
                {{ session('error') ? 'border-red-200 bg-red-50 text-red-800' : 'border-accent/30 bg-accent-soft text-primary' }}"
        >
            <x-icon :name="session('error') ? 'circle-x' : 'circle-check'" class="mt-0.5 size-5" />
            <p class="flex-1">{{ session('error') ?? session('status') }}</p>
            <button type="button" @click="show = false" class="text-current/60 hover:text-current" aria-label="Tutup notifikasi">
                <x-icon name="x" class="size-4" />
            </button>
        </div>
    </div>
@endif
