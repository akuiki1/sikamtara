<x-admin-layout>
    <x-slot:title>Kelola User</x-slot>

    {{-- logika table --}}
    <div class="p-6" x-data="{
        search: '',
        filterRole: '',
        filterStatus: '',
        email: '',
        showPassword: false,
        showPassword2: false,
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        showDetailModal: false,
        selectedUser: null,
        user: @js($userJs),
        get filteredUser() {
            return this.user.filter(item => {
                const matchesSearch = `${item.id_user}`.toLowerCase().includes(this.search.toLowerCase());
                const matchesRole = this.filterRole === '' || item.role === this.filterRole;
                const matchesStatus = this.filterStatus === '' || item.status_verifikasi === this.filterStatus;
                return matchesSearch && matchesRole && matchesStatus;
            });
        }
    }">


        {{-- Search bar + filter + tambah keluarga --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
            {{-- LEFT SECTION: Search, Filter, Clear --}}
            <div class="flex flex-wrap items-center gap-2">
                {{-- SEARCH FORM --}}
                <form method="GET" class="relative w-full md:w-80">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                        {{-- Search Icon --}}
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-width="2"
                                d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>
                    </span>
                    <input type="text" name="search" placeholder="Cari User..." value="{{ request('search') }}"
                        class="pl-10 pr-24 py-2 w-full rounded-full border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"
                        @keydown.enter="$event.target.form.submit()">
                    <x-button type="submit"
                        class="absolute right-1 top-1 bottom-1 bg-indigo-400 hover:bg-indigo-600 text-white px-4 py-1 rounded-full text-sm">
                        Cari
                    </x-button>
                </form>

                {{-- FILTER DROPDOWN --}}
                @php
                    $filterAktif = collect([
                        'search' => request('search'),
                        'role' => request('role'),
                        'status' => request('status'),
                    ])
                        ->filter()
                        ->count();
                @endphp

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" type="button"
                        class="relative flex items-center gap-2 px-4 py-2 rounded-full border border-gray-300 bg-white text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        aria-expanded="true" aria-haspopup="true">
                        <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
                        </svg>
                        Filter

                        <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>

                        {{-- BADGE ANGKA --}}
                        @if ($filterAktif > 0)
                            <span
                                class="absolute top-0 right-0 -mt-1 -mr-1 min-w-[1rem] h-auto px-1 text-xs bg-indigo-500 text-white font-bold rounded-full ring-2 ring-white flex items-center justify-center">
                                {{ $filterAktif }}
                            </span>
                        @endif
                    </button>

                    {{-- FILTER PANEL --}}
                    <div x-show="open" @click.outside="open = false" x-transition.opacity.scale.origin.top.right
                        class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-10 z-50 p-4">
                        <form method="GET" class="space-y-4">
                            <input type="hidden" name="search" value="{{ request('search') }}">

                            {{-- Role --}}
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                <select id="role" name="role"
                                    class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Semua Role</option>
                                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User
                                    </option>
                                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin
                                    </option>
                                    <option value="kepala desa"
                                        {{ request('role') == 'kepala desa' ? 'selected' : '' }}>
                                        Kepala Desa</option>
                                </select>
                            </div>

                            {{-- Status --}}
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status
                                    Akun</label>
                                <select id="status" name="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Semua Status</option>
                                    <option value="Terverifikasi"
                                        {{ request('status') == 'Terverifikasi' ? 'selected' : '' }}>
                                        Terverifikasi</option>
                                    <option value="Belum Terverifikasi"
                                        {{ request('status') == 'Belum Terverifikasi' ? 'selected' : '' }}>
                                        Belum Terverifikasi</option>
                                </select>
                            </div>

                            <x-button type="submit" class="w-full justify-center">Terapkan Filter</x-button>
                        </form>
                    </div>
                </div>


                {{-- TOMBOL CLEAR FILTER (hanya muncul kalau filter aktif) --}}
                @if (request()->has('search') || request()->has('role') || request()->has('status'))
                    <a href="{{ url()->current() }}"
                        class="px-3 py-2 text-sm bg-gray-200 hover:bg-gray-400 text-gray-600 rounded-full">
                        Tampilkan Semua
                    </a>
                @endif
            </div>

            {{-- RIGHT SECTION: Tambah User --}}
            <div>
                <x-button @click="selectedUser = null; showAddModal = true">
                    {{-- Plus Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span>Tambah User</span>
                </x-button>
            </div>
        </div>

        {{-- Tabel User --}}
        <x-table>
            <x-slot name="head">
                <tr>
                    <th class="px-4 py-3 text-center">Nama</th>
                    <th class="px-4 py-3 text-center">Email</th>
                    <th class="px-4 py-3 text-center">Role</th>
                    <th class="px-6 py-3 text-center">Status Akun</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </x-slot>
            <x-slot name="body">
                <template x-if="filteredUser.length === 0">
                    <tr>
                        <td colspan="5" class="text-center text-gray-500 py-6">
                            Data User tidak ditemukan.
                        </td>
                    </tr>
                </template>
                <template x-for="item in filteredUser" :key="item.id_user">
                    <tr class="even:bg-gray-50 hover:bg-gray-100">
                        <td class="px-4 py-3 text-gray-800 font-medium">
                            <span x-text="item.nama"></span>
                            <template x-if="item.status_verifikasi === 'Terverifikasi'">
                                <svg class="w-4 h-4 inline-block text-blue-500 ml-1"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </template>
                        </td>
                        <td class="px-4 py-3 text-gray-600" x-text="item.email"></td>
                        <td class="px-4 py-3 text-gray-600 text-center" x-text="item.role"></td>
                        <td class="px-4 py-3 text-gray-600 text-left" x-text="item.status_verifikasi"></td>
                        <td class="px-6 py-4 text-center">
                            <button @click="selectedUser = item; showDetailModal = true"
                                class="text-blue-600 hover:text-blue-800">
                                <svg class="w-[20px] h-[20px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="1"
                                        d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z" />
                                    <path stroke="currentColor" stroke-width="1"
                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            </button>
                            <button @click="selectedUser = {...item}; showEditModal = true"
                                class="text-yellow-600 hover:text-yellow-800"><svg class="w-[20px] h-[20px]"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1"
                                        d="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                                </svg>
                            </button>
                            <button @click="selectedUser = item; showDeleteModal = true"
                                class="text-red-600 hover:text-red-800 hover:bg-gray-200 rounded-full">
                                <svg class="w-[20px] h-[20px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="1"
                                        d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                </template>
            </x-slot>
        </x-table>

        {{-- pagination --}}
        <div class="mt-4">
            {{ $user->links() }}
        </div>


        {{-- modal status --}}
        <div x-data="{ showSuccess: {{ session('success') ? 'true' : 'false' }}, showError: {{ session('error') ? 'true' : 'false' }} }" x-init="setTimeout(() => {
            showSuccess = false;
            showError = false
        }, 3000)" class="fixed top-5 right-5 z-50 space-y-2">

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

        {{-- modal tambah --}}
        <x-modal show="showAddModal" title="Tambah Akun Baru">
            <form action="{{ route('user.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- nik --}}
                    <div class="col-span-2">
                        <label for="nik" class="block text-sm font-medium">
                            NIK
                        </label>
                        <input list="daftarNik" name="nik" id="nik"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Ketik atau pilih NIK" required>
                        <datalist id="daftarNik">
                            @foreach ($daftarNik as $nik)
                                <option value="{{ $nik->nik }}"></option>
                            @endforeach
                        </datalist>
                    </div>

                    {{-- username --}}
                    <div class="">
                        <label for="username" class="block text-sm font-medium">Username</label>
                        <input type="text" placeholder="username" id="username" name="username"
                            x-model="selectedUser?.username"
                            class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                    </div>

                    {{-- email --}}
                    <div class="">
                        <label for="email" class="block text-sm font-medium">Email</label>
                        <div class="relative">
                            <input x-model="email" type="email" placeholder="Email" name="email"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                            <button type="button" @click="email=''" x-show="email.length > 0"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- password --}}
                    <div class="col-span-2">
                        <label for="Password" class="block text-sm font-medium">Password</label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" x-model="selectedUser?.password"
                                placeholder="Password" name="password"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500 pr-10">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600">
                                <template x-if="!showPassword">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="m15 18-.722-3.25" />
                                        <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                                        <path d="m20 15-1.726-2.05" />
                                        <path d="m4 15 1.726-2.05" />
                                        <path d="m9 18 .722-3.25" />
                                    </svg>
                                </template>
                                <template x-if="showPassword">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </template>
                            </button>
                        </div>
                    </div>

                    {{-- konfirmasi password --}}
                    <div class="col-span-2">
                        <label for="Password" class="block text-sm font-medium">Konfirmasi Password</label>
                        <div class="relative">
                            <input :type="showPassword2 ? 'text' : 'password'" x-model="selectedUser?.password"
                                placeholder="Password" name="password_confirmation"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500 pr-10">
                            <button type="button" @click="showPassword2 = !showPassword2"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600">
                                <template x-if="!showPassword2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="m15 18-.722-3.25" />
                                        <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                                        <path d="m20 15-1.726-2.05" />
                                        <path d="m4 15 1.726-2.05" />
                                        <path d="m9 18 .722-3.25" />
                                    </svg>
                                </template>
                                <template x-if="showPassword2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </template>
                            </button>
                        </div>
                    </div>

                    {{-- role --}}
                    <div>
                        <label for="role" class="block text-sm font-medium">Role</label>
                        <select id="role" name="role" x-model="selectedUser?.role"
                            class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                            <option value="">Pilih Role</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            <option value="kepala desa">Kepala Desa</option>
                        </select>
                    </div>

                    {{-- status verifikasi --}}
                    <div>
                        <label for="status_verifikasi" class="block text-sm font-medium">Status Verifikasi</label>
                        <select id="status_verifikasi" name="status_verifikasi"
                            x-model="selectedUser?.status_verifikasi"
                            class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                            <option value="">Pilih Status Akun</option>
                            <option value="Terverifikasi">Terverifikasi</option>
                            <option value="Belum Terverifikasi">Belum Terverifikasi</option>
                        </select>
                    </div>

                </div>

                {{-- button --}}
                <div class="mt-6 flex justify-end gap-2">
                    <x-button type="button" @click="{{ 'showAddModal' }} = false"
                        variant="secondary">Batal</x-button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        {{-- modal detail --}}
        <x-modal show="showDetailModal" title="Detail Akun">
            <!-- Foto Profil -->
            <div class="flex justify-center mb-8">
                <div class="relative">
                    <!-- Foto -->
                    <img :src="selectedUser.foto || 'img/default-avatar.png'" alt="Foto Profil"
                        class="w-24 h-24 rounded-full object-cover border border-gray-300" />

                    <!-- Icon Verifikasi -->
                    <div class="absolute bottom-0 right-0 rounded-full p-1"
                        :class="selectedUser.status_verifikasi === 'Terverifikasi' ? 'text-blue-500' : 'text-gray-400'">
                        <svg class="w-[20px] h-[20px]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Data Akun -->
            <div class="grid mt-4 grid-cols-1 sm:grid-cols-2 gap-2">
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <p class="text-xs text-gray-500">NIK</p>
                    <p class="font-medium text-gray-800 break-words" x-text="selectedUser.nik"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <p class="text-xs text-gray-500">Nama</p>
                    <p class="font-medium text-gray-800 break-words" x-text="selectedUser.nama"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <p class="text-xs text-gray-500">Username</p>
                    <p class="font-medium text-gray-800 break-words" x-text="selectedUser.username"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <p class="text-xs text-gray-500">Password</p>
                    <p class="font-medium text-gray-800 break-words truncate" x-text="selectedUser.password"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <p class="text-xs text-gray-500">Email</p>
                    <p class="font-medium text-gray-800 break-words truncate" x-text="selectedUser.email"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <p class="text-xs text-gray-500">Role</p>
                    <p class="font-medium text-gray-800 capitalize" x-text="selectedUser.role"></p>
                </div>
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm col-span-full">
                    <p class="text-xs text-gray-500">Status Akun</p>
                    <p class="font-medium text-gray-800" x-text="selectedUser.status_verifikasi"></p>
                </div>
            </div>

            <!-- Tombol Tutup -->
            <div class="text-right pt-4">
                <x-button variant="primary" @click="showDetailModal = false">
                    Tutup
                </x-button>
            </div>
        </x-modal>

        {{-- modal edit --}}
        <x-modal show="showEditModal" title="Edit Akun">
            <form :action="`{{ url('/admin/akun-warga/update') }}/${selectedUser.id_user}`" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label for="nik" class="block text-sm font-medium">NIK</label>
                        <input type="text" id="nik" name="nik" x-model="selectedUser.nik"
                            class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                    </div>
                    <div class="">
                        <label for="nik" class="block text-sm font-medium">Username</label>
                        <input type="text" placeholder="username" id="nik" name="username"
                            x-model="selectedUser.username"
                            class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                    </div>
                    <div class="">
                        <label for="email" class="block text-sm font-medium">Email</label>
                        <div class="relative">
                            <input x-model="selectedUser.email" type="email" placeholder="Email" name="email"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                            <button type="button" @click="email=''" x-show="email.length > 0"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- password --}}
                    <div class="col-span-2">
                        <label for="Password" class="block text-sm font-medium">Password</label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" x-model="selectedUser.password"
                                name="password" placeholder="Password"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500 pr-10">
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-gray-600">
                                <template x-if="!showPassword">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="m15 18-.722-3.25" />
                                        <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                                        <path d="m20 15-1.726-2.05" />
                                        <path d="m4 15 1.726-2.05" />
                                        <path d="m9 18 .722-3.25" />
                                    </svg>
                                </template>
                                <template x-if="showPassword">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path
                                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </template>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium">Role</label>
                        <select id="role" name="role" x-model="selectedUser.role"
                            class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                            <option value="">Pilih Role</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            <option value="kepala desa">Kepala Desa</option>
                        </select>
                    </div>
                    <div>
                        <label for="status_verifikasi" class="block text-sm font-medium">Status Verifikasi</label>
                        <select id="status_verifikasi" name="status_verifikasi"
                            x-model="selectedUser.status_verifikasi"
                            class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                            <option value="">Pilih Status Akun</option>
                            <option value="Terverifikasi">Terverifikasi</option>
                            <option value="Belum Terverifikasi">Belum Terverifikasi</option>
                        </select>
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <x-button type="button" @click="{{ 'showEditModal' }} = false"
                        variant="secondary">Batal</x-button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        {{-- modal hapus --}}
        <div x-show="showDeleteModal" @click.away="showDeleteModal = false" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white rounded-xl shadow-2xl w-96 p-6 text-center">
                <h2 class="text-xl font-semibold mb-4 text-red-600">Hapus User?</h2>
                <p class="mb-4">Apakah Anda yakin ingin menghapus data <strong x-text="selectedUser.nama"></strong>?
                </p>

                <form :action="`{{ url('/admin/akun-warga/delete') }}/${selectedUser.id_user}`" method="POST"
                    x-ref="deleteForm">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-center gap-4">
                        <x-button type="button" @click="showDeleteModal = false"
                            variant="secondary">Batal</x-button>
                        <x-button variant="danger" type="submit">Hapus</x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
