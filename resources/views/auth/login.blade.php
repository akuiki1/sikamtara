<!DOCTYPE html>
<html lang="en" x-data="{ isLogin: true }" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register Page</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="/img/LogoHST.png">
</head>

<body class="h-full flex items-center justify-center">
    {{-- tampilan dekstop --}}
    <div x-data="{
        email: '',
        password: '',
        showPassword: false,
        agree: false,
        registerEmail: '',
        registerPassword: '',
        showRegisterPassword: false,
        isLogin: true
    }"
        class="hidden md:flex w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden relative">

        <!-- Forms Container -->
        <div class="flex w-full md:w-1/2 p-8 relative z-10 flex-col justify-center">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dimissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="bg-white p-8 rounded shadow-md w-full max-w-md" x-show="true" x-transition.duration.700ms>

                <h2 class="text-3xl font-bold text-blue-700 mb-6 text-center">Login</h2>

                {{-- code login error --}}
                @if (session()->has('loginError'))
                    <div x-data="{ showError: true }" x-show="showError" x-transition.duration.300ms
                        class="flex items-start p-4 mb-4 text-xs text-red-800 bg-red-100 rounded-full dark:bg-red-200 dark:text-red-900"
                        role="alert">

                        <svg class="flex-shrink-0 inline w-5 h-5 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.366-.756 1.37-.756 1.736 0l6.518 13.473A1 1 0 0 1 15.518 18H4.482a1 1 0 0 1-.893-1.428L10.107 3.1zM11 14a1 1 0 1 0-2 0 1 1 0 0 0 2 0zm-1-2a1 1 0 0 0 1-1V9a1 1 0 1 0-2 0v2a1 1 0 0 0 1 1z"
                                clip-rule="evenodd" />
                        </svg>

                        <div>
                            <span class="font-semibold">Login gagal!</span> {{ session('loginError') }}
                        </div>

                        <button type="button" @click="showError = false"
                            class="ml-auto -mx-1.5 -my-1.5 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8"
                            aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 0 1 1.414 0L10 8.586l4.293-4.293a1 1 0 0 1 1.414 1.414L11.414 10l4.293 4.293a1 1 0 0 1-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 0 1-1.414-1.414L8.586 10 4.293 5.707a1 1 0 0 1 0-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                @endif


                <form x-ref="loginForm"
                    @submit.prevent="if (!agree) { alert('Kamu harus setuju Terms & Conditions dulu!'); return; } $refs.loginForm.submit();"
                    method="POST" action="{{ route('login.post') }}">

                    @csrf
                    {{-- Error Message --}}
                    @error('email')
                        <div class="invalid-feedback text-xs text-red-500">
                            *{{ $message }}
                        </div>
                    @enderror
                    <!-- Email Input -->
                    <div class="relative mb-6 flex flex-col" x-data="{
                        email: '{{ old('email') }}',
                    }">
                        <input x-model ="email" name="email" type="email" placeholder="Email" required
                            autocomplete="username"
                            class="w-full p-3 pr-10 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') is-invalid @enderror" />
                        <button type="button" @click="email=''" x-show="email.length > 0"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                    </div>

                    {{-- Error Message --}}
                    @error('password')
                        <div class="invalid-feedback text-xs text-red-500">
                            *{{ $message }}
                        </div>
                    @enderror
                    <!-- Password Input -->
                    <div class="relative mb-6">
                        <input :type="showPassword ? 'text' : 'password'" x-model="password" name="password"
                            placeholder="Password" required autocomplete="current-password"
                            class="w-full p-3 pr-10 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') is-invalid @enderror" />

                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute right-3 inset-y-0 my-auto flex items-center text-gray-400 hover:text-gray-600">
                            <template x-if="!showPassword">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-eye-closed-icon lucide-eye-closed">
                                    <path d="m15 18-.722-3.25" />
                                    <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                                    <path d="m20 15-1.726-2.05" />
                                    <path d="m4 15 1.726-2.05" />
                                    <path d="m9 18 .722-3.25" />
                                </svg>
                            </template>
                            <template x-if="showPassword">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-eye-icon lucide-eye">
                                    <path
                                        d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                            </template>
                        </button>
                    </div>


                    <!-- Checkbox Agree -->
                    <div class="flex items-center space-x-2 mb-6">
                        <input x-model="agree" type="checkbox" required
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" id="agree" />
                        <label for="agree" class="text-gray-600 text-sm select-none">
                            I agree to the <a href="#" class="text-blue-600 hover:underline">Terms &
                                Conditions</a>
                        </label>
                    </div>

                    <!-- Login Button -->
                    <button type="submit"
                        class="w-full bg-blue-700 text-white py-3 rounded hover:bg-blue-800 transition font-bold">
                        Login
                    </button>

                </form>

                <!-- Divider -->
                <div class="flex items-center my-6">
                    <div class="flex-grow border-t border-gray-300"></div>
                    <span class="mx-2 text-gray-400 text-sm">OR</span>
                    <div class="flex-grow border-t border-gray-300"></div>
                </div>

                <!-- Login with Google -->
                <a href="{{ url('/auth/google') }}"
                    class="w-full border border-gray-300 py-3 rounded flex items-center justify-center hover:bg-gray-100 transition">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google"
                        class="w-5 h-5 mr-2" />
                    <span class="text-gray-700 font-semibold">Login with Google</span>
                </a>

            </div>
        </div>

        {{-- register --}}
        <div class="flex w-full md:w-1/2 p-8 relative z-10 flex-col justify-center">
            <!-- Register Form -->
            <div x-show="!isLogin" class="transition duration-700 ease-in-out">
                <h2 class="text-3xl font-bold text-blue-700 mb-6">Register</h2>

                {{-- Error validation --}}
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="flex flex-col space-y-6">
                        <div>
                            <input type="text" name="nik" placeholder="NIK" value="{{ old('nik') }}"
                                maxlength="16"
                                class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                                class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div class="relative">
                            <input :type="showRegisterPassword ? 'text' : 'password'" name="password"
                                placeholder="Password"
                                class="w-full p-3 pr-10 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <button type="button" @click="showRegisterPassword = !showRegisterPassword"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <template x-if="!showRegisterPassword">
                                    <!-- eye closed -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-eye-closed-icon lucide-eye-closed">
                                        <path d="m15 18-.722-3.25" />
                                        <path d="M2 8a10.645 10.645 0 0 0 20 0" />
                                        <path d="m20 15-1.726-2.05" />
                                        <path d="m4 15 1.726-2.05" />
                                        <path d="m9 18 .722-3.25" />
                                    </svg>
                                </template>
                                <template x-if="showRegisterPassword">
                                    <!-- eye open -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="lucide lucide-eye-icon lucide-eye">
                                        <path
                                            d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </template>
                            </button>
                        </div>

                        <div>
                            <input type="password" name="password_confirmation" placeholder="Confirm Password"
                                class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="flex items-center space-x-2">
                            <input type="checkbox" name="terms" required
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <label class="text-gray-600 text-sm">
                                I agree to the <a href="#" class="text-blue-600 hover:underline">Terms &
                                    Conditions</a>
                            </label>
                        </div>
                        <button type="submit"
                            class="w-full bg-blue-700 text-white py-3 rounded hover:bg-blue-800 transition font-bold">
                            Register
                        </button>
                        <div class="flex items-center my-4">
                            <div class="flex-grow border-t border-gray-300"></div>
                            <span class="mx-2 text-gray-400 text-sm">OR</span>
                            <div class="flex-grow border-t border-gray-300"></div>
                        </div>
                        <a href="{{ url('/auth/google') }}"
                            class="w-full border border-gray-300 py-3 rounded flex items-center justify-center hover:bg-gray-100 transition">
                            <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google"
                                class="w-5 h-5 mr-2">
                            <span class="text-gray-700 font-semibold">Login with Google</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>


        <!-- Sliding Panel -->
        <div class="hidden md:flex w-1/2 bg-gradient-to-r from-blue-700 to-blue-900 text-white items-center justify-center p-8 absolute top-0 left-0 h-full transition-transform duration-700 ease-in-out z-20"
            :class="isLogin ? 'translate-x-full' : 'translate-x-0'">
            <div class="text-center">

                <!-- Logo Instansi -->
                <div class="flex justify-center items-center space-x-4 mb-6 border-b-1">
                    <img src="{{ asset('img/LogoHST.png') }}" alt="Logo Desa" class="h-10">
                    <img src="{{ asset('img/LogoProv.png') }}" alt="Logo Kabupaten" class="h-10">
                    <img src="{{ asset('img/LogoKemdagri.png') }}" alt="Logo Lain" class="h-12">
                </div>

                <h2 class="text-4xl font-bold mb-4"
                    x-text="isLogin ? 'Halo, Warga Desa!' : 'Akses Layanan Digital Desa'"></h2>
                <p class="mb-8"
                    x-text="isLogin ? 'Belum punya akun? Daftar sekarang untuk menikmati kemudahan layanan online.' : 'Sudah punya akun? silahkan login ya...'">
                </p>
                <button @click="isLogin = !isLogin"
                    class="bg-white text-blue-700 py-2 px-6 rounded-full font-bold transition hover:bg-gray-100">
                    <span x-text="isLogin ? 'Buat Akun' : 'Login'"></span>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile-Only Auth Component -->
    <div x-data="{
        email: '',
        password: '',
        showPassword: false,
        agree: false,
        registerEmail: '',
        registerPassword: '',
        showRegisterPassword: false,
        isLogin: true
    }" class="md:hidden w-full min-h-screen flex flex-col bg-white">

        <div class="flex-1 flex items-center justify-center px-6 py-10">
            <div class="w-full max-w-md">

                <div class="flex justify-center items-center space-x-4 mb-6 border-b-1">
                    <img src="{{ asset('img/LogoHST.png') }}" alt="Logo Desa" class="h-10">
                    <img src="{{ asset('img/LogoProv.png') }}" alt="Logo Kabupaten" class="h-10">
                    <img src="{{ asset('img/LogoKemdagri.png') }}" alt="Logo Lain" class="h-12">
                </div>

                <!-- Dynamic Title -->
                <h2 class="text-3xl font-bold text-center text-blue-700 mb-6" x-text="isLogin ? 'Login' : 'Register'">
                </h2>

                <!-- Form Login -->
                <form x-show="isLogin" x-transition method="POST" action="{{ route('login.post') }}">
                    @csrf
                    <input x-model="email" name="email" type="email" placeholder="Email" required
                        class="w-full p-3 mb-4 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <div class="relative mb-4">
                        <input :type="showPassword ? 'text' : 'password'" x-model="password" name="password"
                            placeholder="Password" required
                            class="w-full p-3 pr-10 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <template x-if="!showPassword">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </template>
                            <template x-if="showPassword">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="3" />
                                    <path
                                        d="M2.05 12C3.4 7.1 7.5 4 12 4s8.6 3.1 9.95 8c-1.35 4.9-5.45 8-9.95 8s-8.6-3.1-9.95-8z" />
                                </svg>
                            </template>
                        </button>
                    </div>

                    <div class="flex items-center space-x-2 mb-4">
                        <input x-model="agree" type="checkbox" required class="text-blue-600">
                        <label class="text-sm text-gray-600">Saya setuju dengan <a href="#"
                                class="text-blue-600 underline">Terms & Conditions</a></label>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-700 text-white py-3 rounded font-bold hover:bg-blue-800 transition">Login</button>

                    <div class="flex items-center my-4">
                        <div class="flex-grow border-t border-gray-300"></div>
                        <span class="mx-2 text-gray-400 text-sm">atau</span>
                        <div class="flex-grow border-t border-gray-300"></div>
                    </div>

                    <a href="{{ url('/auth/google') }}"
                        class="w-full border border-gray-300 py-3 rounded flex items-center justify-center hover:bg-gray-100 transition">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google"
                            class="w-5 h-5 mr-2">
                        <span class="text-gray-700 font-semibold">Login dengan Google</span>
                    </a>
                </form>

                <!-- Form Register -->
                <form x-show="!isLogin" x-transition method="POST" action="{{ route('register') }}">
                    @csrf

                    <input type="text" name="nik" placeholder="NIK" value="{{ old('nik') }}"
                        maxlength="16" class="w-full p-3 mb-4 border rounded focus:ring-blue-500">

                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"
                        class="w-full p-3 mb-4 border rounded focus:ring-blue-500">

                    <div class="relative mb-4">
                        <input :type="showRegisterPassword ? 'text' : 'password'" name="password"
                            placeholder="Password" class="w-full p-3 pr-10 border rounded focus:ring-blue-500">
                        <button type="button" @click="showRegisterPassword = !showRegisterPassword"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <template x-if="!showRegisterPassword">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </template>
                            <template x-if="showRegisterPassword">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="3" />
                                    <path
                                        d="M2.05 12C3.4 7.1 7.5 4 12 4s8.6 3.1 9.95 8c-1.35 4.9-5.45 8-9.95 8s-8.6-3.1-9.95-8z" />
                                </svg>
                            </template>
                        </button>
                    </div>

                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"
                        class="w-full p-3 mb-4 border rounded focus:ring-blue-500">

                    <div class="flex items-center space-x-2 mb-4">
                        <input type="checkbox" name="terms" required class="text-blue-600">
                        <label class="text-sm text-gray-600">Saya setuju dengan <a href="#"
                                class="text-blue-600 underline">Terms & Conditions</a></label>
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-700 text-white py-3 rounded font-bold hover:bg-blue-800 transition">Daftar</button>

                    <div class="flex items-center my-4">
                        <div class="flex-grow border-t border-gray-300"></div>
                        <span class="mx-2 text-gray-400 text-sm">atau</span>
                        <div class="flex-grow border-t border-gray-300"></div>
                    </div>

                    <a href="{{ url('/auth/google') }}"
                        class="w-full border border-gray-300 py-3 rounded flex items-center justify-center hover:bg-gray-100 transition">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google"
                            class="w-5 h-5 mr-2">
                        <span class="text-gray-700 font-semibold">Daftar dengan Google</span>
                    </a>
                </form>

                <!-- Switch Between Login/Register -->
                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        <span x-show="isLogin">Belum punya akun? <button @click="isLogin = false"
                                class="text-blue-600 underline">Daftar</button></span>
                        <span x-show="!isLogin">Sudah punya akun? <button @click="isLogin = true"
                                class="text-blue-600 underline">Login</button></span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div x-data="{ showSuccess: {{ session('success') ? 'true' : 'false' }}, showError: {{ session('error') ? 'true' : 'false' }} }" x-init="setTimeout(() => {
        showSuccess = false;
        showError = false
    }, 10000)" class="fixed top-5 right-5 z-50 space-y-2 w-96">

        <!-- Notifikasi sukses -->
        @if (@session('success'))
            <div x-show="showSuccess" x-transition
                class="flex justify-between items-center px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-sm">{{ session('success') }}</span>
                </div>
                <button @click="showSuccess = false"
                    class="hover:scale-125 transition text-green-800 hover:text-green-900 text-xl leading-none">
                    &times;
                </button>
            </div>
        @endif


        <!-- Notifikasi gagal -->
        @if (session('error'))
            <div x-show="showError" x-transition
                class="flex justify-between items-center px-4 py-3 bg-red-100 border border-red-300 text-red-800 rounded-lg shadow">
                <div class="flex items-center gap-2">
                    <!-- Ganti ikon dari × ke ikon alert seperti exclamation -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01M12 5a7 7 0 1 1 0 14a7 7 0 0 1 0-14z" />
                    </svg>
                    <span class="text-sm">{{ session('error') }}</span>
                </div>
                <!-- Tombol tutup tetap pakai × -->
                <button @click="showError = false"
                    class="hover:scale-125 transition ml-2 text-red-800 hover:text-red-900 text-xl leading-none">
                    &times;
                </button>
            </div>
        @endif
    </div>
</body>

</html>
