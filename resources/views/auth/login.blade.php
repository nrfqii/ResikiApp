<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login ResikiApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-primary { background-color: #0ABAB5; }
        .text-primary { color: #0ABAB5; }
        .border-primary { border-color: #0ABAB5; }
        .hover\:bg-primary-dark:hover { background-color: #089992; }
        .focus\:border-primary:focus { border-color: #0ABAB5; outline: none; box-shadow: 0 0 0 3px rgba(10, 186, 181, 0.1); }
        .gradient-bg {
            background: linear-gradient(135deg, #0ABAB5 0%, #089992 100%);
        }
        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .cleaning-icon {
            background: linear-gradient(45deg, #0ABAB5, #089992);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .welcome-text {
            background: linear-gradient(135deg, #0ABAB5, #089992);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex justify-center items-center p-4">
    <!-- Decorative Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-white bg-opacity-20 rounded-full animate-float"></div>
    <div class="absolute bottom-10 right-10 w-16 h-16 bg-white bg-opacity-15 rounded-full animate-float" style="animation-delay: -3s;"></div>
    <div class="absolute top-1/3 right-20 w-12 h-12 bg-white bg-opacity-10 rounded-full animate-float" style="animation-delay: -1.5s;"></div>

    <div class="glass-effect p-8 rounded-2xl shadow-2xl w-full max-w-md border border-white border-opacity-20">
        <!-- Logo/Brand Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-4 shadow-lg">
                <img src="{{ asset('LogoResiki.jpeg') }}" alt="Logo ResikiApp" class="w-16 h-16 rounded-xl object-cover" />
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">ResikiApp</h1>
            <p class="text-gray-600 text-sm">Layanan kebersihan terpercaya</p>
        </div>
        <form action="/login" method="POST" class="space-y-4">
            @csrf
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang!</h2>
                <p class="text-gray-600 text-sm">Masuk ke akun ResikiApp Anda</p>
            </div>

            @error('email')
                <div class="bg-red-50 border border-red-200 text-red-600 p-3 rounded-lg text-sm flex items-center">
                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    {{ $message }}
                </div>
            @enderror

            <div class="space-y-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                        </svg>
                    </div>
                    <input type="email" name="email" placeholder="Email" required 
                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200">
                </div>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <input type="password" name="password" placeholder="Password" required 
                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200">
                </div>
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center">
                    <input type="checkbox" class="w-4 h-4 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary focus:ring-2">
                    <span class="ml-2 text-gray-600">Ingat saya</span>
                </label>
                <a href="#" class="text-primary hover:underline transition duration-200">Lupa password?</a>
            </div>

            <button type="submit" class="w-full bg-primary text-white py-3 rounded-xl font-semibold hover:bg-primary-dark transform hover:scale-105 transition duration-200 shadow-lg hover:shadow-xl">
                Masuk
            </button>

            <div class="text-center pt-4">
                <p class="text-gray-600 text-sm">Belum punya akun?
                    <a href="/register" class="text-primary font-semibold hover:underline transition duration-200">Daftar sekarang</a>
                </p>
            </div>

            <!-- Social Login Options (Optional) -->
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Atau masuk dengan</span>
                    </div>
                </div>

                <div class="mt-4 grid grid-cols-2 gap-3">
                    <button type="button" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition duration-200">
                        <svg class="w-5 h-5" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        <span class="ml-2">Google</span>
                    </button>

                    <button type="button" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 transition duration-200">
                        <svg class="w-5 h-5" fill="#1877F2" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="ml-2">Facebook</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>