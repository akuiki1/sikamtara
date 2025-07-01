<x-layout>
    <section class="relative bg-gradient-to-r from-blue-700 to-blue-900 text-white py-9 px-6 text-center">
    </section>

    <section class="bg-gray-100 py-8">
        <div class="container mx-auto px-4" x-data="pendudukData()">

            {{-- header --}}
            <div class="bg-white p-6 rounded-xl mb-4 shadow-md">
                <h1 class="text-2xl font-bold">Penduduk Desa Kambat Utara</h1>
                <p class="text-gray-600">Statistik jumlah penduduk berdasarkan jenis kelamin dan usia.</p>
            </div>

            {{-- Card Statistik Jumlah Penduduk --}}
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-4">

                {{-- Total Penduduk --}}
                <div class="bg-white border shadow-md rounded-xl p-4 sm:p-6 text-center">
                    <div class="w-12 sm:w-16 h-12 sm:h-16 mx-auto">
                        <svg class="w-full h-full text-slate-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.25-2.095c.478-.86.75-1.85.75-2.905a5.973 5.973 0 0 0-.75-2.906 4 4 0 1 1 0 5.811ZM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.535Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">Total Penduduk</h3>
                    <p class="text-sm text-gray-500">{{ number_format($total) }} Jiwa</p>
                </div>

                {{-- Total Keluarga --}}
                <div class="bg-white border shadow-md rounded-xl p-4 sm:p-6 text-center">
                    <div class="w-12 sm:w-16 h-12 sm:h-16 mx-auto">
                        <svg class="w-full h-full text-emerald-600" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 6a3.5 3.5 0 1 0 0 7 3.5 3.5 0 0 0 0-7Zm-1.5 8a4 4 0 0 0-4 4 2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-3Zm6.82-3.096a5.51 5.51 0 0 0-2.797-6.293 3.5 3.5 0 1 1 2.796 6.292ZM19.5 18h.5a2 2 0 0 0 2-2 4 4 0 0 0-4-4h-1.1a5.503 5.503 0 0 1-.471.762A5.998 5.998 0 0 1 19.5 18ZM4 7.5a3.5 3.5 0 0 1 5.477-2.889 5.5 5.5 0 0 0-2.796 6.293A3.501 3.501 0 0 1 4 7.5ZM7.1 12H6a4 4 0 0 0-4 4 2 2 0 0 0 2 2h.5a5.998 5.998 0 0 1 3.071-5.238A5.505 5.505 0 0 1 7.1 12Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">Total Keluarga</h3>
                    <p class="text-sm text-gray-500">{{ number_format($keluarga) }} Keluarga</p>
                </div>

                {{-- Laki-laki --}}
                <div class="bg-white border shadow-md rounded-xl p-4 sm:p-6 text-center">
                    <div class="w-12 sm:w-16 h-12 sm:h-16 mx-auto">
                        <svg class="w-full h-full text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">Laki-laki</h3>
                    <p class="text-sm text-gray-500">{{ number_format($laki) }} Jiwa</p>
                </div>

                {{-- Perempuan --}}
                <div class="bg-white border shadow-md rounded-xl p-4 sm:p-6 text-center">
                    <div class="w-12 sm:w-16 h-12 sm:h-16 mx-auto">
                        <svg class="w-full h-full text-pink-600" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-800">Perempuan</h3>
                    <p class="text-sm text-gray-500">{{ number_format($perempuan) }} Jiwa</p>
                </div>
            </div>

            {{-- Card Kelompok Umur & Pendidikan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                {{-- Kelompok Umur --}}
                <div class="bg-white rounded-xl shadow-md p-4 space-y-4">
                    <h2 class="text-sm sm:text-base font-semibold text-center">Kelompok Umur</h2>

                    <div class="h-56">
                        <canvas id="umurChart" class="w-full h-full"></canvas>
                    </div>

                    <div class="text-xs sm:text-sm text-gray-600 grid grid-cols-2 gap-2 text-center px-2">
                        <div>
                            <span class="font-medium text-blue-600">Laki-laki:</span>
                            Umur <span class="font-semibold">{{ $tertinggi['L']['label'] }}</span>,
                            <span class="font-semibold">{{ $tertinggi['L']['jumlah'] }} org</span>
                            ({{ $tertinggi['L']['persentase'] }}%)
                        </div>
                        <div>
                            <span class="font-medium text-pink-600">Perempuan:</span>
                            Umur <span class="font-semibold">{{ $tertinggi['P']['label'] }}</span>,
                            <span class="font-semibold">{{ $tertinggi['P']['jumlah'] }} org</span>
                            ({{ $tertinggi['P']['persentase'] }}%)
                        </div>
                    </div>
                </div>

                {{-- Berdasarkan Perkawinan --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 space-y-6">
                    <h2 class="text-base sm:text-lg font-semibold text-center text-gray-800">Status Perkawinan</h2>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-center text-sm text-gray-700">
                        {{-- Belum Kawin --}}
                        <div
                            class="flex flex-col items-center gap-2 bg-white p-4 rounded-2xl border border-gray-200 hover:shadow-md transition">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="font-semibold text-lg text-gray-900">{{ $perkawinan['Belum Kawin'] }}</div>
                            <div class="text-xs text-gray-500 tracking-wide">Belum Kawin</div>
                        </div>

                        {{-- Kawin --}}
                        <div
                            class="flex flex-col items-center gap-2 bg-white p-4 rounded-2xl border border-gray-200 hover:shadow-md transition">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4H6Zm7.25-2.095c.478-.86.75-1.85.75-2.905a5.973 5.973 0 0 0-.75-2.906 4 4 0 1 1 0 5.811ZM15.466 20c.34-.588.535-1.271.535-2v-1a5.978 5.978 0 0 0-1.528-4H18a4 4 0 0 1 4 4v1a2 2 0 0 1-2 2h-4.535Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="font-semibold text-lg text-gray-900">{{ $perkawinan['Kawin'] }}</div>
                            <div class="text-xs text-gray-500 tracking-wide">Kawin</div>
                        </div>

                        {{-- Cerai Mati --}}
                        <div
                            class="flex flex-col items-center gap-2 bg-white p-4 rounded-2xl border border-gray-200 hover:shadow-md transition">
                            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600"
                                    viewBox="0 0 32 32">
                                    <path fill="currentColor"
                                        d="M9 4C7.355 4 6 5.355 6 7v18c0 1.645 1.355 3 3 3h17V4H9zm0 2h15v16H9a2.93 2.93 0 0 0-1 .188V7c0-.566.434-1 1-1zm7 3c-5.926 0-4.938 8-4.938 8H13v2h6v-2h1.938S21.925 9 16 9zm-2 4c.55 0 1 .45 1 1s-.45 1-1 1s-1-.45-1-1s.45-1 1-1zm4 0c.55 0 1 .45 1 1s-.45 1-1 1s-1-.45-1-1s.45-1 1-1zm-2 2l1 2h-2l1-2zm-7 9h15v2H9c-.566 0-1-.434-1-1c0-.566.434-1 1-1z" />
                                </svg>
                            </div>
                            <div class="font-semibold text-lg text-gray-900">{{ $perkawinan['Cerai Mati'] }}</div>
                            <div class="text-xs text-gray-500 tracking-wide">Cerai Mati</div>
                        </div>

                        {{-- Cerai Hidup --}}
                        <div
                            class="flex flex-col items-center gap-2 bg-white p-4 rounded-2xl border border-gray-200 hover:shadow-md transition">
                            <div class="w-10 h-10 rounded-full bg-pink-100 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-600"
                                    viewBox="0 0 24 24">
                                    <path fill="currentColor" fill-rule="evenodd"
                                        d="M8.979 6.145c-1.322-.588-2.983-.286-3.977.995l-.31.399a4.203 4.203 0 0 0 .443 5.64L12 19.628l6.865-6.449a4.203 4.203 0 0 0 .443-5.64l-.31-.399c-1.179-1.52-3.294-1.662-4.673-.576l-1.237-1.57c2.196-1.73 5.59-1.53 7.49.92l.31.399a6.203 6.203 0 0 1-.654 8.324l-6.953 6.531l-.02.019c-.101.095-.224.21-.341.301a1.499 1.499 0 0 1-.631.298c-.19.037-.387.037-.578 0a1.5 1.5 0 0 1-.63-.298c-.118-.09-.24-.206-.342-.301l-.02-.019l-6.953-6.531a6.203 6.203 0 0 1-.654-8.324l.79.613l-.79-.613l.31-.399c1.955-2.52 5.487-2.661 7.676-.768l.723.626l-.592.75l-1.036 1.313c-.347.44-.54.687-.65.875a1.23 1.23 0 0 0-.004.008a.962.962 0 0 0 .007.005c.17.137.438.3.918.589l1.252.751l.048.029c.38.228.748.449 1.025.67c.311.25.632.597.749 1.117c.116.52-.025.97-.2 1.329c-.154.32-.392.676-.638 1.045l-.031.047l-.837 1.255l-1.664-1.11l.837-1.255c.289-.433.447-.675.535-.856l.003-.007a.158.158 0 0 0-.006-.004c-.157-.127-.403-.277-.85-.545l-1.253-.751l-.05-.03c-.41-.247-.803-.482-1.096-.719c-.326-.264-.664-.635-.766-1.19c-.102-.557.083-1.023.294-1.386c.19-.325.474-.684.77-1.06l.037-.046zm.51 2.675l-.001.002z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="font-semibold text-lg text-gray-900">{{ $perkawinan['Cerai Hidup'] }}</div>
                            <div class="text-xs text-gray-500 tracking-wide">Cerai Hidup</div>
                        </div>

                        {{-- Kawin Tercatat --}}
                        <div
                            class="flex flex-col items-center gap-2 bg-white p-4 rounded-2xl border border-gray-200 hover:shadow-md transition">
                            <div class="w-10 h-10 rounded-full bg-purple-200 flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-600" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m8.032 12 1.984 1.984 4.96-4.96m4.55 5.272.893-.893a1.984 1.984 0 0 0 0-2.806l-.893-.893a1.984 1.984 0 0 1-.581-1.403V7.04a1.984 1.984 0 0 0-1.984-1.984h-1.262a1.983 1.983 0 0 1-1.403-.581l-.893-.893a1.984 1.984 0 0 0-2.806 0l-.893.893a1.984 1.984 0 0 1-1.403.581H7.04A1.984 1.984 0 0 0 5.055 7.04v1.262c0 .527-.209 1.031-.581 1.403l-.893.893a1.984 1.984 0 0 0 0 2.806l.893.893c.372.372.581.876.581 1.403v1.262a1.984 1.984 0 0 0 1.984 1.984h1.262c.527 0 1.031.209 1.403.581l.893.893a1.984 1.984 0 0 0 2.806 0l.893-.893a1.985 1.985 0 0 1 1.403-.581h1.262a1.984 1.984 0 0 0 1.984-1.984V15.7c0-.527.209-1.031.581-1.403Z" />
                                </svg>

                            </div>
                            <div class="font-semibold text-lg text-gray-900">{{ $perkawinan['Kawin Tercatat'] }}</div>
                            <div class="text-xs text-gray-500 tracking-wide">Kawin Tercatat</div>
                        </div>

                        {{-- Kawin Tidak Tercatat --}}
                        <div
                            class="flex flex-col items-center gap-2 bg-white p-4 rounded-2xl border border-gray-200 hover:shadow-md transition">
                            <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-600" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                    viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m8.032 12 1.984 1.984 4.96-4.96m4.55 5.272.893-.893a1.984 1.984 0 0 0 0-2.806l-.893-.893a1.984 1.984 0 0 1-.581-1.403V7.04a1.984 1.984 0 0 0-1.984-1.984h-1.262a1.983 1.983 0 0 1-1.403-.581l-.893-.893a1.984 1.984 0 0 0-2.806 0l-.893.893a1.984 1.984 0 0 1-1.403.581H7.04A1.984 1.984 0 0 0 5.055 7.04v1.262c0 .527-.209 1.031-.581 1.403l-.893.893a1.984 1.984 0 0 0 0 2.806l.893.893c.372.372.581.876.581 1.403v1.262a1.984 1.984 0 0 0 1.984 1.984h1.262c.527 0 1.031.209 1.403.581l.893.893a1.984 1.984 0 0 0 2.806 0l.893-.893a1.985 1.985 0 0 1 1.403-.581h1.262a1.984 1.984 0 0 0 1.984-1.984V15.7c0-.527.209-1.031.581-1.403Z" />
                                </svg>

                            </div>
                            <div class="font-semibold text-lg text-gray-900">{{ $perkawinan['Kawin Tidak Tercatat'] }}
                            </div>
                            <div class="text-xs text-gray-500 tracking-wide">Kawin Tidak Tercatat</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Berdasarkan Pekerjaan & Status Perkawinan --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                {{-- Berdasarkan Pekerjaan --}}
                <div class="bg-white rounded-xl shadow-md p-4 space-y-4">
                    <h2 class="text-sm sm:text-base font-semibold text-center">5 Pekerjaan Teratas</h2>

                    <div class="h-64">
                        <canvas id="pekerjaanChart" class="w-full h-full"></canvas>
                    </div>

                    {{-- Keterangan --}}
                    <div
                        class="text-xs sm:text-sm text-gray-600 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 gap-2 px-2">
                        @foreach ($pekerjaanTop as $item)
                            @php
                                $persen = $totalPekerjaan > 0 ? round(($item->jumlah / $totalPekerjaan) * 100, 2) : 0;
                            @endphp
                            <div>
                                <span class="font-medium text-blue-600">{{ $item->pekerjaan }}:</span>
                                <span class="font-semibold">{{ $item->jumlah }} org</span>
                                ({{ $persen }}%)
                            </div>
                        @endforeach

                        @if ($jumlahLainnya > 0)
                            <div x-data="{ open: false }">
                                {{-- Tombol --}}
                                <div class="text-right mt-2">
                                    <button @click="open = true"
                                        class="text-sm text-blue-600 hover:underline focus:outline-none">Lihat semua
                                        pekerjaan</button>
                                </div>

                                {{-- Modal --}}
                                <div x-show="open"
                                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                                    x-cloak>
                                    <div
                                        class="bg-white rounded-xl shadow-lg w-full max-w-xl max-h-[80vh] overflow-y-auto p-6 relative">
                                        <button @click="open = false"
                                            class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-lg">&times;</button>

                                        <h3 class="text-base font-semibold mb-4 text-center">Semua Pekerjaan</h3>

                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700">
                                            @foreach ($pekerjaanSemua as $item)
                                                @php
                                                    $persen =
                                                        $totalPekerjaan > 0
                                                            ? round(($item->jumlah / $totalPekerjaan) * 100, 2)
                                                            : 0;
                                                @endphp
                                                <div class="bg-gray-50 border p-3 rounded-md">
                                                    <p class="font-medium">{{ $item->pekerjaan }}</p>
                                                    <p class="text-xs">{{ $item->jumlah }} org ({{ $persen }}%)
                                                    </p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                </div>

                {{-- Chart Agama --}}
                <div class="bg-white rounded-xl shadow-md p-4 space-y-4">
                    <h2 class="text-base sm:text-lg font-semibold text-center">Agama</h2>

                    <div class="grid md:grid-cols-2 gap-6 items-center">
                        {{-- CHART --}}
                        <div class="flex justify-center">
                            <div class="h-52 w-52">
                                <canvas id="agamaChart" class="w-full h-full"></canvas>
                            </div>
                        </div>

                        {{-- DETAIL KARTU --}}
                        <div class="grid grid-cols-2 sm:grid-cols-2 gap-2">
                            @php
                                $colors = [
                                    'Islam' => '#34d399',
                                    'Protestan' => '#fbbf24',
                                    'Katolik' => '#fbbf24',
                                    'Hindu' => '#f87171',
                                    'Budha' => '#60a5fa',
                                    'Konghucu' => '#a78bfa',
                                    'Lainnya' => '#a78bfa',
                                ];
                            @endphp
                            @foreach ($agamaData as $agama => $jumlah)
                                @php
                                    $persen = $totalAgama > 0 ? round(($jumlah / $totalAgama) * 100, 2) : 0;
                                    $bgColor = $colors[$agama] ?? '#e5e7eb';
                                @endphp
                                <div class="rounded-xl p-4 shadow-md text-center border"
                                    style="background-color: {{ $bgColor }}20"> {{-- transparansi warna --}}
                                    <p class="text-xs text-gray-600">{{ $agama }}</p>
                                    <p class="text-lg font-bold text-gray-800">{{ $jumlah }} orang</p>
                                    <p class="text-xs text-gray-500">{{ $persen }}%</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card Berdasarkan Agama & GolDar --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Berdasarkan Pendidikan --}}
                <div class="bg-white rounded-xl shadow-md p-4 space-y-4">
                    <h2 class="text-sm sm:text-base font-semibold text-center">Pendidikan</h2>

                    <div class="h-64">
                        <canvas id="pendidikanChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                {{-- Chart Goldar --}}
                <div class="bg-white rounded-xl shadow-md p-4 space-y-4">
                    <h2 class="text-base sm:text-lg font-semibold text-center">Golongan Darah</h2>
                    {{-- Chart Bar --}}
                    <div class="h-64">
                        <canvas id="darahChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Script Chart.js & Alpine.js --}}
    <script>
        // PENDUDUK BERDASARKAN USIA
        const umurLabels = {!! json_encode(array_keys($umurData['L'])) !!};
        const dataL = {!! json_encode(array_values($umurData['L'])) !!};
        const dataP = {!! json_encode(array_values($umurData['P'])) !!};

        //Pendidikan
        const pendidikanLabels = {!! json_encode($pendidikanData->keys()) !!};
        const pendidikanValues = {!! json_encode($pendidikanData->values()) !!};

        //PEKERJAAN
        const pekerjaanLabels = {!! json_encode($pekerjaanData->keys()) !!};
        const pekerjaanValues = {!! json_encode($pekerjaanData->values()) !!};

        // AGAMA
        const agamaLabels = {!! json_encode(array_keys($agamaData)) !!};
        const agamaValues = {!! json_encode(array_values($agamaData)) !!};

        // GOLDAR
        const darahLabels = {!! json_encode($golonganDarah->keys()) !!};
        const darahValues = {!! json_encode($golonganDarah->values()) !!};

        function pendudukData() {
            return {
                init() {
                    // UMUR CHART (Dapatkan data dari Blade jika ingin dinamis)
                    const umurChart = new Chart(document.getElementById('umurChart'), {
                        type: 'bar',
                        data: {
                            labels: umurLabels,
                            datasets: [{
                                    label: 'Laki-laki',
                                    backgroundColor: '#3b82f6',
                                    data: dataL,
                                    borderRadius: 6
                                },
                                {
                                    label: 'Perempuan',
                                    backgroundColor: '#ec4899',
                                    data: dataP,
                                    borderRadius: 6
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // PENDIDIKAN CHART
                    const pendidikanChart = new Chart(document.getElementById('pendidikanChart'), {
                        type: 'bar',
                        data: {
                            labels: pendidikanLabels,
                            datasets: [{
                                label: 'Jumlah',
                                backgroundColor: '#facc15',
                                data: pendidikanValues,
                                borderRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // PEKERJAAN CHART (Ganti horizontalBar -> bar + indexAxis: 'y')
                    const pekerjaanChart = new Chart(document.getElementById('pekerjaanChart'), {
                        type: 'bar',
                        data: {
                            labels: pekerjaanLabels,
                            datasets: [{
                                label: 'Jumlah',
                                backgroundColor: '#818cf8',
                                data: pekerjaanValues,
                                borderRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            indexAxis: 'y',
                            scales: {
                                x: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    // AGAMA CHART
                    const agamaChart = new Chart(document.getElementById('agamaChart'), {
                        type: 'doughnut',
                        data: {
                            labels: agamaLabels,
                            datasets: [{
                                backgroundColor: ['#f87171', '#fbbf24', '#34d399', '#60a5fa', '#a78bfa',
                                    '#f472b6', '#c084fc'
                                ],
                                data: agamaValues
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });

                    //GOLONGAN DARAH
                    const darahChart = new Chart(document.getElementById('darahChart'), {
                        type: 'bar',
                        data: {
                            labels: darahLabels,
                            datasets: [{
                                label: 'Jumlah Penduduk',
                                backgroundColor: '#f87171',
                                borderRadius: 8,
                                data: darahValues
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 10
                                    }
                                }
                            }
                        }
                    });
                }
            }
        }
    </script>
</x-layout>
