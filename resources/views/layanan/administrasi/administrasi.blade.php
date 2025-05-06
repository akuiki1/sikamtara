<x-layout>

    <section class="max-w-7xl mx-auto px-4 py-12">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-4">Layanan Administrasi</h1>
        <p class="text-lg text-gray-500 mb-10">
            Jelajahi berbagai layanan administrasi desa dengan kemudahan dan kenyamanan.
        </p>

        <!-- Search Bar -->
        <div class="flex items-center justify-center mb-12">
            <div class="relative w-full max-w-2xl">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1116.65 5.65a7.5 7.5 0 010 10.6z" />
                    </svg>
                </div>
                <input type="text" placeholder="Cari layanan administrasi..."
                    class="w-full py-3 pl-12 pr-4 text-gray-700 bg-white border border-gray-300 rounded-full shadow-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
            </div>
        </div>

        <!-- Card Layanan -->
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3" x-data="{ selectedService: null }">

            @foreach ($services as $service)
                <div
                    class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-2xl transition-shadow duration-300 flex flex-col justify-between">
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $service['title'] }}</h2>
                        <p class="text-gray-500 mb-6">{{ $service['short_description'] }}</p>
                    </div>
                    <div class="flex justify-between items-center p-4 border-t">
                        <button @click="selectedService = {{ json_encode($service) }}"
                            class="text-blue-600 hover:text-blue-800 font-semibold text-sm">
                            Detail
                        </button>
                        <a href="{{ route('services.apply', $service['id']) }}"
                            class="px-4 py-2 bg-green-500 text-white rounded-full text-sm hover:bg-green-600 transition">
                            Ajukan Sekarang
                        </a>
                    </div>
                </div>
            @endforeach

            <!-- Modal Detail -->
            <div x-show="selectedService"
                class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50 backdrop-blur-sm"
                x-transition>
                <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8 relative">
                    <button @click="selectedService = null"
                        class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <h2 class="text-2xl font-extrabold text-gray-800 mb-4" x-text="selectedService.title"></h2>
                    <p class="text-gray-600 mb-6" x-text="selectedService.full_description"></p>

                    <div class="flex justify-end space-x-4">
                        <button @click="selectedService = null"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-full hover:bg-gray-300 text-sm">
                            Kembali
                        </button>
                        <a :href="'/services/apply/' + selectedService.id"
                            class="px-4 py-2 bg-green-500 text-white rounded-full hover:bg-green-600 text-sm">
                            Ajukan Sekarang
                        </a>
                    </div>
                </div>
            </div>

        </div>

        {{-- tombol hubungi admin via whatsapp --}}
        <div class="mt-8 flex justify-center">
            <a href="https://wa.me/YourPhoneNumber?text=Hello,%20I%20have%20a%20question%20about%20services."
                target="_blank"
                class="inline-flex items-center gap-2 px-6 py-3 bg-green-500 text-white rounded-full font-bold text-lg hover:bg-green-600 hover:scale-105 transition-transform duration-300 shadow-lg">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path fill="currentColor" fill-rule="evenodd" d="M12 4a8 8 0 0 0-6.895 12.06l.569.718-.697 2.359 2.32-.648.379.243A8 8 0 1 0 12 4ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10a9.96 9.96 0 0 1-5.016-1.347l-4.948 1.382 1.426-4.829-.006-.007-.033-.055A9.958 9.958 0 0 1 2 12Z" clip-rule="evenodd"/>
                    <path fill="currentColor" d="M16.735 13.492c-.038-.018-1.497-.736-1.756-.83a1.008 1.008 0 0 0-.34-.075c-.196 0-.362.098-.49.291-.146.217-.587.732-.723.886-.018.02-.042.045-.057.045-.013 0-.239-.093-.307-.123-1.564-.68-2.751-2.313-2.914-2.589-.023-.04-.024-.057-.024-.057.005-.021.058-.074.085-.101.08-.079.166-.182.249-.283l.117-.14c.121-.14.175-.25.237-.375l.033-.066a.68.68 0 0 0-.02-.64c-.034-.069-.65-1.555-.715-1.711-.158-.377-.366-.552-.655-.552-.027 0 0 0-.112.005-.137.005-.883.104-1.213.311-.35.22-.94.924-.94 2.16 0 1.112.705 2.162 1.008 2.561l.041.06c1.161 1.695 2.608 2.951 4.074 3.537 1.412.564 2.081.63 2.461.63.16 0 .288-.013.4-.024l.072-.007c.488-.043 1.56-.599 1.804-1.276.192-.534.243-1.117.115-1.329-.088-.144-.239-.216-.43-.308Z"/>
                  </svg>               
                Hubungi Admin via WhatsApp
            </a>
        </div>

    </section>

    <!-- Section 2: Riwayat Pengajuan -->
    <section class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-3xl font-extrabold text-gray-800 mb-6">Riwayat Pengajuan Anda</h2>

        <div class="overflow-x-auto bg-white shadow-xl rounded-2xl">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left">Tanggal</th>
                        <th class="px-6 py-4 text-left">Layanan</th>
                        <th class="px-6 py-4 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($submissions as $submission)
                        <tr>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($submission->created_at)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">{{ $submission->service_title }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold
                            @if ($submission->status == 'disetujui') bg-green-10 text-green
                            @elseif($submission->status == 'ditolak') bg-red text-red
                            @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ ucfirst($submission->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

</x-layout>
