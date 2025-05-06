<x-layout>
    <section class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-16 flex justify-center items-center px-6">
        <div x-data="applyForm()" class="bg-white/90 backdrop-blur-md rounded-3xl shadow-2xl p-10 w-full max-w-3xl relative overflow-hidden">
    
            <!-- Tombol Kembali -->
            <a href="{{ route('administrasi') }}" class="absolute top-6 left-6 inline-flex items-center gap-2 text-gray-500 hover:text-blue-600 transition text-sm font-semibold">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg> 
                Kembali
            </a>
    
            <!-- Header -->
            <div class="text-center mb-10">
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-2">{{ $service['title'] }}</h1>
                <p class="text-gray-500 text-base">{{ $service['description'] }}</p>
            </div>
    
            <!-- Form -->
            <form @submit.prevent="submitForm" class="space-y-6" enctype="multipart/form-data">
                @csrf
    
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Nama Lengkap</label>
                        <input type="text" x-model="form.name" required class="mt-2 w-full px-4 py-3 rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm shadow-sm" />
                    </div>
    
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Email</label>
                        <input type="email" x-model="form.email" required class="mt-2 w-full px-4 py-3 rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm shadow-sm" />
                    </div>
    
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Nomor Telepon</label>
                        <input type="text" x-model="form.phone" required class="mt-2 w-full px-4 py-3 rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm shadow-sm" />
                    </div>
    
                    <div>
                        <label class="text-sm font-semibold text-gray-600">Upload Dokumen</label>
                        <input type="file" @change="previewFile" accept="image/*,.pdf" required class="mt-2 w-full px-4 py-3 rounded-lg border-gray-300 bg-gray-50 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm" />
                        
                        <template x-if="filePreview">
                            <div class="mt-4">
                                <template x-if="isImage">
                                    <img :src="filePreview" alt="Preview" class="w-24 h-24 object-cover rounded-xl mx-auto">
                                </template>
                                <template x-if="!isImage">
                                    <div class="text-center text-gray-400 text-sm">
                                        📄 PDF Siap Diupload
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>
    
                <div>
                    <label class="text-sm font-semibold text-gray-600">Keterangan Tambahan</label>
                    <textarea x-model="form.details" required rows="4" class="mt-2 w-full px-4 py-3 rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-400 focus:border-blue-400 text-sm shadow-sm resize-none"></textarea>
                </div>
    
                <!-- Progress Bar -->
                <div x-show="uploading" class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-500 h-2 rounded-full" :style="`width: ${progress}%`"></div>
                </div>
    
                <div class="flex justify-end pt-4">
                    <button type="submit" 
                        class="inline-flex items-center gap-2 px-8 py-3 rounded-full bg-gradient-to-r from-indigo-600 to-blue-700 hover:from-indigo-700 hover:to-blue-800 text-white font-extrabold text-lg shadow-xl hover:scale-105 transition transform tracking-wide">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg> 
                        Ajukan Sekarang
                    </button>
                </div>
            </form>
        </div>
    </section>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
    function applyForm() {
        return {
            form: {
                name: '',
                email: '',
                phone: '',
                details: '',
                document: null
            },
            filePreview: null,
            isImage: false,
            uploading: false,
            progress: 0,
    
            previewFile(event) {
                const file = event.target.files[0];
                if (file) {
                    this.form.document = file;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        if (file.type.startsWith('image/')) {
                            this.filePreview = e.target.result;
                            this.isImage = true;
                        } else {
                            this.filePreview = true;
                            this.isImage = false;
                        }
                    };
                    reader.readAsDataURL(file);
                }
            },
    
            async submitForm() {
                if (!this.form.name || !this.form.email || !this.form.phone || !this.form.details || !this.form.document) {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Semua field wajib diisi.',
                        confirmButtonColor: '#2563eb'
                    });
                    return;
                }
    
                this.uploading = true;
                this.progress = 0;
    
                const formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('email', this.form.email);
                formData.append('phone', this.form.phone);
                formData.append('details', this.form.details);
                formData.append('document', this.form.document);
    
                try {
                    const response = await fetch('#', { // ganti dengan endpointmu
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });
    
                    if (response.ok) {
                        this.progress = 100;
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Pengajuan berhasil dikirim.',
                            confirmButtonColor: '#2563eb'
                        }).then(() => {
                            window.location.href = '{{ route('administrasi') }}';
                        });
                    } else {
                        throw new Error('Gagal mengirim data');
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: error.message,
                        confirmButtonColor: '#2563eb'
                    });
                } finally {
                    this.uploading = false;
                }
            }
        }
    }
    </script>
    </x-layout>
    