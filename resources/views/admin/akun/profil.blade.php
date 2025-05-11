<x-admin-layout>
    <x-slot:title>Edit Profil</x-slot>

    @push('styles')
    <link href="https://unpkg.com/cropperjs/dist/cropper.min.css" rel="stylesheet" />
    @endpush

    <div x-data="profileEditor()" class="p-6 bg-white rounded-xl shadow-xl">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Your personal profile info</h2>

        <!-- Foto Profil -->
        <div class="flex items-center space-x-4 mb-8">
            <div class="relative">
                <img :src="photoPreview || '/img/default-avatar.png'" alt="Preview" class="w-24 h-24 rounded-full object-cover border border-gray-300" />
                <input type="file" accept="image/jpeg,image/png,image/jpg"
                       @change="handleImageUpload" class="absolute inset-0 opacity-0 cursor-pointer" />
            </div>
            <div>
                <p class="text-sm text-gray-500">Click photo to change</p>
            </div>
        </div>

        <!-- Form -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- PROFILE -->
            <div>
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2"><span class="text-blue-500">1</span> PROFILE</h3>
                <div class="grid grid-cols-2 gap-4">
                    <x-form.input label="First name" />
                    <x-form.input label="Last name" />
                    <x-form.input label="Username (not your e-mail)" />
                    <x-form.input label="Country, City" />
                    <x-form.input label="Your e-mail" type="email" />
                    <x-form.input label="Organization" />
                    <div class="col-span-2 flex gap-4">
                        <x-form.select label="Personal phone number" :options="['+62', '+1', '+44']" />
                        <x-form.input label="" placeholder="812 345 678" />
                    </div>
                    <div class="col-span-2 flex gap-4">
                        <x-form.select label="Work phone number" :options="['+62', '+1', '+44']" />
                        <x-form.input label="" placeholder="812 345 678" />
                    </div>
                </div>
            </div>

            <!-- PASSWORD -->
            <div>
                <h3 class="text-lg font-bold mb-4 flex items-center gap-2"><span class="text-blue-500">2</span> PASSWORD</h3>
                <div class="grid grid-cols-1 gap-4">
                    <x-form.input label="Old password" type="password" />
                    <x-form.input label="New password" type="password" />
                    <x-form.input label="Confirm new password" type="password" />
                </div>
                <button class="mt-6 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                    Correct. Save info
                </button>
            </div>
        </div>

        <!-- Modal Cropper -->
        <div x-show="showCrop" class="fixed inset-0 z-50 bg-black bg-opacity-70 flex items-center justify-center">
            <div class="bg-white p-6 rounded-xl w-full max-w-md">
                <h2 class="text-xl font-semibold mb-4">Crop your photo</h2>
                <div>
                    <img id="cropper-image" class="max-w-full rounded-md" />
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button @click="cancelCrop" class="px-4 py-2 text-gray-600 border rounded">Cancel</button>
                    <button @click="applyCrop" class="px-4 py-2 bg-blue-600 text-white rounded">Apply</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/cropperjs/dist/cropper.min.js"></script>
    <script>
        function profileEditor() {
            return {
                photoPreview: null,
                showCrop: false,
                imageFile: null,
                cropper: null,

                handleImageUpload(e) {
                    const file = e.target.files[0];
                    if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
                        alert("File harus JPG, JPEG, atau PNG.");
                        return;
                    }
                    this.imageFile = file;
                    const reader = new FileReader();
                    reader.onload = (event) => {
                        document.getElementById('cropper-image').src = event.target.result;
                        this.showCrop = true;
                        this.$nextTick(() => {
                            this.cropper = new Cropper(document.getElementById('cropper-image'), {
                                aspectRatio: 1,
                                viewMode: 1
                            });
                        });
                    };
                    reader.readAsDataURL(file);
                },

                cancelCrop() {
                    this.cropper.destroy();
                    this.cropper = null;
                    this.showCrop = false;
                },

                applyCrop() {
                    const canvas = this.cropper.getCroppedCanvas({ width: 300, height: 300 });
                    this.photoPreview = canvas.toDataURL();
                    this.cropper.destroy();
                    this.cropper = null;
                    this.showCrop = false;
                }
            }
        }
    </script>
    @endpush

</x-admin-layout>
