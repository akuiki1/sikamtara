<x-admin-layout>
    <x-slot:title>Edit Profil</x-slot:title>

    <div x-data="profileForm()" class="p-6 max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Your personal profile info</h1>

        <!-- FOTO PROFIL -->
        <div class="flex items-center gap-6 mb-8">
            <div class="relative">
                <img :src="previewUrl || '{{ asset('images/default-avatar.jpg') }}'" alt="Foto Profil"
                    class="w-28 h-28 rounded-full object-cover ring-2 ring-indigo-500 shadow">
            </div>
            <div>
                <label class="block font-medium text-sm text-gray-700 mb-2">Edit Foto Profil</label>
                <input type="file" @change="previewImage" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <div class="mt-2">
                    <button @click="showCrop = true"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Crop Foto
                    </button>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-8 bg-white p-6 rounded-xl shadow-lg">
            <!-- Form Profil -->
            <div class="space-y-4">
                <h2 class="font-semibold text-lg text-indigo-600">1. PROFILE</h2>
                <div class="grid grid-cols-2 gap-4">
                    <x-input label="First name" placeholder="Name"/>
                    <x-input label="Last name" placeholder="Surname"/>
                    <x-input label="Username (not email)" placeholder="Username"/>
                    <x-input label="Country, City" placeholder="Indonesia, Hulu Sungai Tengah"/>
                    <x-input label="Your e-mail" placeholder="mail@example.com"/>
                    <x-input label="Organization" placeholder="Nama Organisasi"/>
                    <div class="col-span-1">
                        <label class="block text-sm text-gray-700 mb-1">Personal phone</label>
                        <div class="flex gap-2">
                            <select class="w-1/3 rounded-lg border-gray-300">
                                <option>+62</option>
                                <option>+60</option>
                            </select>
                            <input type="text" class="w-full rounded-lg border-gray-300" placeholder="0812xxx"/>
                        </div>
                    </div>
                    <div class="col-span-1">
                        <label class="block text-sm text-gray-700 mb-1">Work phone</label>
                        <div class="flex gap-2">
                            <select class="w-1/3 rounded-lg border-gray-300">
                                <option>+62</option>
                                <option>+60</option>
                            </select>
                            <input type="text" class="w-full rounded-lg border-gray-300" placeholder="0812xxx"/>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Password -->
            <div class="space-y-4">
                <h2 class="font-semibold text-lg text-indigo-600">2. PASSWORD</h2>
                <x-input label="Old password" type="password" required/>
                <x-input label="New password" type="password" required/>
                <x-input label="Confirm new password" type="password" required/>
                <div class="pt-4">
                    <button
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-semibold">
                        Correct. Save info
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Crop Foto -->
        <div x-show="showCrop" class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
            <div @click.away="showCrop = false"
                class="bg-white p-6 rounded-xl w-full max-w-lg shadow-xl space-y-4">
                <h3 class="text-xl font-bold text-gray-800">Crop Foto Profil</h3>
                <img :src="previewUrl" class="rounded-xl w-full h-auto object-cover" alt="Preview">
                <div class="flex justify-end gap-3">
                    <button @click="showCrop = false"
                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                        Batal
                    </button>
                    <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                        Simpan & Terapkan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alpine.js logic -->
    <script>
        function profileForm() {
            return {
                previewUrl: null,
                showCrop: false,
                previewImage(event) {
                    const input = event.target;
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.previewUrl = e.target.result;
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            }
        }
    </script>
</x-admin-layout>
