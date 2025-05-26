<x-admin-layout>
    <x-slot:title>Kelola Akun Warga</x-slot>

    {{-- logika table --}}
    <div class="p-6" x-data="{
        search: '',
        filter: '',
        showAddModal: false,
        showEditModal: false,
        showDeleteModal: false,
        showDetailModal: false,
        selectedUser: null,
        user: @js($userJs),
        get filteredUser() {
            return this.user.filter(item => {
                const matchesSearch = `${item.id_user}`.toLowerCase().includes(this.search.toLowerCase());
                const matchesFilter = this.filter === '' || item.status_verifikasi === this.filter;
                return matchesSearch && matchesFilter;
            });
        }
    }">

        {{-- Search bar + filter + tambah keluarga --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4">
            <div class="flex items-center gap-2">
                <form method="GET" class="flex flex-col md:flex-row items-center gap-4">
                    <div class="relative w-full md:w-80">
                        <!-- Ikon kaca pembesar -->
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <svg class="w-6 h-6 text-gray-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="m21 21-3.5-3.5M17 10a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                            </svg>
                        </span>

                        <!-- Input pencarian -->
                        <input type="text" name="search" placeholder="Cari keluarga..."
                            value="{{ request('search') }}"
                            class="w-full pl-10 pr-20 border border-gray-300 rounded-full px-3 py-2 focus:outline-none focus:ring focus:border-blue-500">

                        <!-- Tombol Cari di dalam input -->
                        <button type="submit"
                            class="absolute right-1 top-1 bottom-1 bg-indigo-400 hover:bg-indigo-600 text-white px-4 py-1 rounded-full text-sm">
                            Cari
                        </button>
                    </div>
                </form>

                <a href="{{ url()->current() }}"
                    class="bg-gray-200 hover:bg-gray-300 text-indigo-500 w-auto p-2 rounded-full text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-x-icon lucide-x">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </a>
            </div>
            {{-- Button tambah User --}}
            <button @click="selectedUser = null; showAddModal = true"
                class="flex items-center gap-2 bg-indigo-400 hover:bg-indigo-600 text-white px-4 py-2 rounded-full transition duration-200 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-plus-icon lucide-plus">
                    <path d="M5 12h14" />
                    <path d="M12 5v14" />
                </svg>
                <span>Tambah User</span>
            </button>
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
                <x-slot name="body" x-show="filteredUser.length > 0">
                    <template x-for="item in filteredUser" :key="item.id_user">
                        <tr class="even:bg-gray-50 hover:bg-gray-100">
                            <td class="px-4 py-3 text-gray-800 font-medium" x-text="item.nama"></td>
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
                                    <svg class="w-[20px] h-[20px]" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="1"
                                            d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    </template>
                </x-slot>
                <div x-show="filteredUser.length === 0" class="text-center text-gray-500 py-6">
                    Data user tidak ditemukan.
                </div>
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
            <form action="#" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <div class="">
                            <label for="nik" class="block text-sm font-medium">NIK</label>
                            <input type="text" id="nik" name="nik" x-model="selectedUser?.nik"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <button type="button" @click="{{ 'showAddModal' }} = false"
                        class="inline-flex items-center rounded-full text-base px-5 py-3 focus:outline-none transition duration-150 ease-in-out bg-gray-200 hover:bg-gray-300 text-gray-700">Batal</button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        {{-- modal detail --}}
        <x-modal show="showDetailModal" title="Detail Akun">
            <form action="#" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <div class="">
                            <label for="nik" class="block text-sm font-medium">NIK</label>
                            <input type="text" id="nik" name="nik" x-model="selectedUser?.nik"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
                    </div>

                </div>

                <div class="mt-6 flex justify-end gap-2">
                    <x-button type="button" @click="{{ 'showDetailModal' }} = false"
                        variant="secondary">Batal</x-button>
                    <x-button type="submit">Simpan</x-button>
                </div>
            </form>
        </x-modal>

        {{-- modal edit --}}
        <x-modal show="showEditModal" title="Edit Akun">
            <form action="#" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <div class="">
                            <label for="nik" class="block text-sm font-medium">NIK</label>
                            <input type="text" id="nik" name="nik" x-model="selectedUser?.nik"
                                class="w-full px-3 py-2 text-sm border rounded-md focus:ring focus:border-blue-500">
                        </div>
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

                <form :action="`/admin/akun/${selectedUser.id_user}`" method="POST" x-ref="deleteForm">
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
