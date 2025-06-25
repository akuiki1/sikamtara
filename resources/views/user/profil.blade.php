<x-layout>
    <div class="max-w-2xl mx-auto py-8 px-4">
        <h2 class="text-2xl font-semibold mb-6">Edit Profil</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profil.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div x-data="{ preview: '{{ $user->foto ? asset('storage/' . $user->foto) : '' }}' }" class="flex flex-col items-center space-y-2">
                <label class="block font-medium text-center">Foto Profil</label>
                <div class="relative w-24 h-24">
                    <label class="relative w-24 h-24 cursor-pointer block">
                        <template x-if="preview">
                            <img :src="preview" alt="Foto Profil"
                                class="w-24 h-24 rounded-full object-cover border border-gray-300" />
                        </template>

                        <input type="file" name="foto" accept="image/*"
                            @change="preview = URL.createObjectURL($event.target.files[0])"
                            class="absolute inset-0 w-full h-full opacity-0 rounded-full" />

                        <div
                            class="absolute inset-0 flex items-center justify-center rounded-full bg-black bg-opacity-40 text-white opacity-0 hover:opacity-100 transition-opacity">
                            <span class="select-none">Ganti Foto</span>
                        </div>
                    </label>

                </div>

                @error('foto')
                    <p class="text-red-500 text-sm text-center">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium">nama <span class="text-red-500">*</span> </label>
                <input type="text" name="nama" value="{{ old('nama', $user->nama) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:ring focus:ring-blue-200">
                @error('nama')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium">Email<span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 mt-1 focus:ring focus:ring-blue-200">
                @error('email')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block font-medium">NIK</label>
                <input type="text" value="{{ $user->nik }}" disabled
                    class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block font-medium">Role</label>
                <input type="text" value="{{ ucfirst($user->role) }}" disabled
                    class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2 mt-1">
            </div>

            <div>
                <label class="block font-medium">Status Verifikasi</label>
                <input type="text" value="{{ $user->status_verifikasi }}" disabled
                    class="w-full bg-gray-100 border border-gray-300 rounded px-3 py-2 mt-1">
            </div>

            <div>
                <button type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">Simpan</button>
            </div>
        </form>
    </div>
</x-layout>
