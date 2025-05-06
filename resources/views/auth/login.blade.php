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
    }" class="hidden md:flex w-full max-w-4xl bg-white rounded-2xl shadow-2xl overflow-hidden relative">
    
        <!-- Forms Container -->
        <div class="flex w-full md:w-1/2 p-8 relative z-10 flex-col justify-center">
            <!-- Login Form -->
            <div x-show="isLogin" class="transition duration-700 ease-in-out">
                <h2 class="text-3xl font-bold text-purple-700 mb-6">Login</h2>
                <div class="flex flex-col space-y-6">
    
                    <!-- Email Input -->
                    <div class="relative">
                        <input x-model="email" type="email" placeholder="Email"
                            class="w-full p-3 pr-10 border rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <button type="button" @click="email=''" x-show="email.length > 0"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
    
                    <!-- Password Input -->
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" x-model="password" placeholder="Password"
                            class="w-full p-3 pr-10 border rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <template x-if="!showPassword">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </template>
                            <template x-if="showPassword">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-4.477-10-10a9.956 9.956 0 011.175-4.875m2.25 2.25A9.956 9.956 0 014.5 12c0 5.523 4.477 10 10 10a9.956 9.956 0 004.875-1.175m2.25-2.25A9.956 9.956 0 0119.5 12c0-5.523-4.477-10-10-10a9.956 9.956 0 00-4.875 1.175" />
                                </svg>
                            </template>
                        </button>
                    </div>
    
                    <!-- Checkbox Agree -->
                    <div class="flex items-center space-x-2">
                        <input x-model="agree" type="checkbox"
                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <label class="text-gray-600 text-sm">
                            I agree to the <a href="#" class="text-purple-600 hover:underline">Terms &
                                Conditions</a>
                        </label>
                    </div>
    
                    <!-- Login Button -->
                    <button type="submit"
                        class="w-full bg-purple-700 text-white py-3 rounded hover:bg-purple-800 transition font-bold">
                        Login
                    </button>
    
                    <!-- Divider -->
                    <div class="flex items-center my-4">
                        <div class="flex-grow border-t border-gray-300"></div>
                        <span class="mx-2 text-gray-400 text-sm">OR</span>
                        <div class="flex-grow border-t border-gray-300"></div>
                    </div>
    
                    <!-- Login with Google -->
                    <button type="button"
                        class="w-full border border-gray-300 py-3 rounded flex items-center justify-center hover:bg-gray-100 transition">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google"
                            class="w-5 h-5 mr-2">
                        <span class="text-gray-700 font-semibold">Login with Google</span>
                    </button>
                </div>
            </div>
        </div>
    
        <div class="flex w-full md:w-1/2 p-8 relative z-10 flex-col justify-center">
            <!-- Register Form -->
            <div x-show="!isLogin" class="transition duration-700 ease-in-out">
                <h2 class="text-3xl font-bold text-purple-700 mb-6">Register
                </h2>
                <div class="flex flex-col space-y-6">
                    <div>
                        <input type="text" placeholder="Name"
                            class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div>
                        <input x-model="registerEmail" type="email" placeholder="Email"
                            class="w-full p-3 border rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
                    </div>
                    <div class="relative">
                        <input :type="showRegisterPassword ? 'text' : 'password'" x-model="registerPassword"
                            placeholder="Password"
                            class="w-full p-3 pr-10 border rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <button type="button" @click="showRegisterPassword = !showRegisterPassword"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <template x-if="!showRegisterPassword">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </template>
                            <template x-if="showRegisterPassword">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-4.477-10-10a9.956 9.956 0 011.175-4.875m2.25 2.25A9.956 9.956 0 014.5 12c0 5.523 4.477 10 10 10a9.956 9.956 0 004.875-1.175m2.25-2.25A9.956 9.956 0 0119.5 12c0-5.523-4.477-10-10-10a9.956 9.956 0 00-4.875 1.175" />
                                </svg>
                            </template>
                        </button>
                    </div>
                    <div class="flex items-center space-x-2">
                        <input type="checkbox"
                            class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                        <label class="text-gray-600 text-sm">
                            I agree to the <a href="#" class="text-purple-600 hover:underline">Terms &
                                Conditions</a>
                        </label>
                    </div>
                    <button type="submit"
                        class="w-full bg-purple-700 text-white py-3 rounded hover:bg-purple-800 transition font-bold">
                        Register
                    </button>
                    <div class="flex items-center my-4">
                        <div class="flex-grow border-t border-gray-300"></div>
                        <span class="mx-2 text-gray-400 text-sm">OR</span>
                        <div class="flex-grow border-t border-gray-300"></div>
                    </div>
                    <button type="button"
                        class="w-full border border-gray-300 py-3 rounded flex items-center justify-center hover:bg-gray-100 transition">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google"
                            class="w-5 h-5 mr-2">
                        <span class="text-gray-700 font-semibold">Login with Google</span>
                    </button>
                </div>
            </div>
        </div>
    
        <!-- Sliding Panel -->
        <div class="hidden md:flex w-1/2 bg-gradient-to-r from-purple-700 to-purple-500 text-white items-center justify-center p-8 absolute top-0 left-0 h-full transition-transform duration-700 ease-in-out z-20"
            :class="isLogin ? 'translate-x-full' : 'translate-x-0'">
            <div class="text-center">
                <h2 class="text-4xl font-bold mb-4" x-text="isLogin ? 'Hello, Friend!' : 'Welcome Back!'"></h2>
                <p class="mb-8"
                    x-text="isLogin ? 'Don’t have an account? Register now!' : 'Already have an account? Login here!'">
                </p>
                <button @click="isLogin = !isLogin"
                    class="bg-white text-purple-700 py-2 px-6 rounded-full font-bold transition hover:bg-gray-100">
                    <span x-text="isLogin ? 'Register' : 'Login'"></span>
                </button>
            </div>
        </div>
    </div>
    

    {{-- tampilan mobile --}}
    <div class="flex md:hidden w-full min-h-screen items-center justify-center p-4">
        <div class="h-full flex items-center justify-center bg-gray-100">
            <div x-data="{ tab: 'login', showLoginPassword: false, showRegisterPassword: false }" class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-6">
                <div>
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('/img/LogoHST.png') }}" alt="Logo Barrabai" class=" w-12 mb-4">
                    </div>

                    <!-- Tabs -->
                    <div class="flex justify-around mb-6">
                        <button @click="tab = 'login'"
                            :class="tab === 'login' ? 'border-b-2 border-purple-600 text-purple-600' : 'text-gray-500'"
                            class="pb-2 font-semibold text-lg">Login</button>
                        <button @click="tab = 'register'"
                            :class="tab === 'register' ? 'border-b-2 border-purple-600 text-purple-600' : 'text-gray-500'"
                            class="pb-2 font-semibold text-lg">Register</button>
                    </div>
                </div>

                <!-- Form Login -->
                <div x-show="tab === 'login'" class="flex flex-col space-y-4">
                    <div class="relative">
                        <input type="email" placeholder="Email" x-model="emailLogin"
                            class="w-full p-3 pr-10 border rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <button type="button" @click="emailLogin=''" x-show="emailLogin?.length > 0"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <!-- X Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="relative">
                        <input :type="showLoginPassword ? 'text' : 'password'" placeholder="Password"
                            x-model="passwordLogin"
                            class="w-full p-3 pr-10 border rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <button type="button" @click="showLoginPassword = !showLoginPassword"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <template x-if="!showLoginPassword">
                                <!-- Eye Closed -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                                </svg>
                            </template>
                            <template x-if="showLoginPassword">
                                <!-- Eye Open -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-4.477-10-10A9.956 9.956 0 013.175 4.125m2.25 2.25A9.956 9.956 0 014.5 12c0 5.523 4.477 10 10 10a9.956 9.956 0 004.875-1.175m2.25-2.25A9.956 9.956 0 0119.5 12c0-5.523-4.477-10-10-10a9.956 9.956 0 00-4.875 1.175" />
                                </svg>
                            </template>
                        </button>
                    </div>

                    <button type="submit"
                        class="w-full bg-purple-700 text-white py-3 rounded hover:bg-purple-800 transition font-bold">Login</button>
                </div>

                <!-- Form Register -->
                <div x-show="tab === 'register'" class="flex flex-col space-y-4" x-cloak>
                    <div class="relative">
                        <input type="text" placeholder="Name" x-model="nameRegister"
                            class="w-full p-3 pr-10 border rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <button type="button" @click="nameRegister=''" x-show="nameRegister?.length > 0"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <!-- X Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="relative">
                        <input type="email" placeholder="Email" x-model="emailRegister"
                            class="w-full p-3 pr-10 border rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <button type="button" @click="emailRegister=''" x-show="emailRegister?.length > 0"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <!-- X Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="relative">
                        <input :type="showRegisterPassword ? 'text' : 'password'" placeholder="Password"
                            x-model="passwordRegister"
                            class="w-full p-3 pr-10 border rounded focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <button type="button" @click="showRegisterPassword = !showRegisterPassword"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <template x-if="!showRegisterPassword">
                                <!-- Eye Closed -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                                </svg>
                            </template>
                            <template x-if="showRegisterPassword">
                                <!-- Eye Open -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-5.523 0-10-4.477-10-10A9.956 9.956 0 013.175 4.125m2.25 2.25A9.956 9.956 0 014.5 12c0 5.523 4.477 10 10 10a9.956 9.956 0 004.875-1.175m2.25-2.25A9.956 9.956 0 0119.5 12c0-5.523-4.477-10-10-10a9.956 9.956 0 00-4.875 1.175" />
                                </svg>
                            </template>
                        </button>
                    </div>

                    <button type="submit"
                        class="w-full bg-purple-700 text-white py-3 rounded hover:bg-purple-800 transition font-bold">Register</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
