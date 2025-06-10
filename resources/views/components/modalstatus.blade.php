{{-- modal status --}}
<div x-data="{ showSuccess: {{ session('success') ? 'true' : 'false' }}, showError: {{ session('error') ? 'true' : 'false' }} }" x-init="setTimeout(() => {
    showSuccess = false;
    showError = false
}, 10000)" class="fixed top-5 right-5 z-50 space-y-2">

    <!-- Berhasil -->
    <div x-show="showSuccess" x-transition
        class="flex items-center gap-3 p-4 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-lg">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>

    <!-- Gagal -->
    <div x-show="showError" x-transition
        class="flex items-center gap-3 p-4 bg-red-100 border border-red-300 text-red-800 rounded-lg shadow-lg">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
        <span>{{ session('error') }}</span>
    </div>
</div>
