@if (session('status') || session('error'))
    <div class="pointer-events-none fixed inset-x-0 top-20 z-50 flex justify-center px-4">
        <div
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 5000)"
            x-show="show"
            x-transition.opacity
            role="status"
            class="pointer-events-auto flex max-w-md items-start gap-3 rounded-none border border-black px-4 py-3 text-sm
                {{ session('error') ? 'border-red-600 bg-white text-red-800' : 'border-black bg-white text-black' }}"
        >
            <x-icon :name="session('error') ? 'circle-x' : 'circle-check'" class="mt-0.5 size-5" />
            <p class="flex-1">{{ session('error') ?? session('status') }}</p>
            <button type="button" @click="show = false" class="text-current/60 hover:text-current" aria-label="Tutup notifikasi">
                <x-icon name="x" class="size-4" />
            </button>
        </div>
    </div>
@endif
