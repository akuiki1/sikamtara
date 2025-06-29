<x-layout>
    <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-9 px-6 text-center">
    </section>

    <section>
        {{-- container card --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- card 1 --}}
            <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Pengaduan Masuk</p>
                        <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $total }}</h2>
                    </div>

                    <div class="text-violet-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text">
                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z" />
                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                            <path d="M10 9H8" />
                            <path d="M16 13H8" />
                            <path d="M16 17H8" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- card 2 --}}
            <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Pengaduan Baru</p>
                        <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $terkirim }}</h2>
                    </div>
                    <div class="text-teal-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-file-input-icon lucide-file-input">
                            <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                            <path d="M2 15h10" />
                            <path d="m9 18 3-3-3-3" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- card 3 --}}
            <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Diproses</p>
                        <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $diproses }}</h2>
                    </div>
                    <div class="text-amber-400 scale-x-[-1]">
                        <svg class="w-[36px] h-[36px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="1.2"
                                d="M18 5V4a1 1 0 0 0-1-1H8.914a1 1 0 0 0-.707.293L4.293 7.207A1 1 0 0 0 4 7.914V20a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-5M9 3v4a1 1 0 0 1-1 1H4m11.383.772 2.745 2.746m1.215-3.906a2.089 2.089 0 0 1 0 2.953l-6.65 6.646L9 17.95l.739-3.692 6.646-6.646a2.087 2.087 0 0 1 2.958 0Z" />
                        </svg>

                    </div>
                </div>
            </div>

            {{-- card 4 --}}
            <div class="bg-white rounded-2xl shadow-sm p-5 border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Ditutup</p>
                        <h2 class="text-xl font-bold text-gray-900 mt-1">{{ $ditutup }}</h2>
                    </div>
                    <div class="text-sky-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-file-check2-icon lucide-file-check-2">
                            <path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4" />
                            <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                            <path d="m3 15 2 2 4-4" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
