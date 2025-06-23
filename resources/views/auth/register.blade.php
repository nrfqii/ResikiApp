<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Register ResikiApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="{{ asset('logo-no-bg.png') }}">

    <style>
        .bg-primary {
            background-color: #0ABAB5;
        }

        .text-primary {
            color: #0ABAB5;
        }

        .border-primary {
            border-color: #0ABAB5;
        }

        .hover\:bg-primary-dark:hover {
            background-color: #089992;
        }

        .focus\:border-primary:focus {
            border-color: #0ABAB5;
            outline: none;
            box-shadow: 0 0 0 3px rgba(10, 186, 181, 0.1);
        }

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

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .cleaning-icon {
            background: linear-gradient(45deg, #0ABAB5, #089992);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>

<body class="gradient-bg min-h-screen flex justify-center items-center p-4">
    <!-- Decorative Elements -->
    <div class="absolute top-10 left-10 w-20 h-20 bg-white bg-opacity-20 rounded-full animate-float"></div>
    <div class="absolute bottom-10 right-10 w-16 h-16 bg-white bg-opacity-15 rounded-full animate-float"
        style="animation-delay: -3s;"></div>
    <div class="absolute top-1/3 right-20 w-12 h-12 bg-white bg-opacity-10 rounded-full animate-float"
        style="animation-delay: -1.5s;"></div>

    <div class="glass-effect p-8 rounded-2xl shadow-2xl w-full max-w-md border border-white border-opacity-20">
        <!-- Logo/Brand Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 mb-4 shadow-lg">
                <img src="{{ asset('logo.jpg') }}" alt="Logo ResikiApp" class="w-16 h-16 rounded-xl object-cover" />
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">ResikiApp</h1>
            <p class="text-gray-600 text-sm">Solusi Bersih Cerdas untuk Pekalongan & Batang</p>
        </div>

        <form action="/register" method="POST" class="space-y-4">
            @csrf
            <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Daftar Akun Baru</h2>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 p-3 rounded-lg text-sm">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="space-y-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="name" placeholder="Nama Lengkap" required
                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200">
                </div>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                    </div>
                    <input type="email" name="email" placeholder="Email" required
                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200">
                </div>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                    </div>
                    <input type="text" name="no_hp" placeholder="Nomor HP" required
                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200">
                </div>

                <div class="relative">
                    <div class="absolute top-3 left-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <textarea name="alamat" placeholder="Alamat Lengkap" required rows="3"
                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200 resize-none"></textarea>
                </div>

                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="password" name="password" placeholder="Password" required
                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary focus:ring-opacity-20 transition duration-200">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-primary text-white py-3 rounded-xl font-semibold hover:bg-primary-dark transform hover:scale-105 transition duration-200 shadow-lg hover:shadow-xl">
                Daftar Sekarang
            </button>

            <div class="text-center pt-4">
                <p class="text-gray-600 text-sm">Sudah punya akun?
                    <a href="/login" class="text-primary font-semibold hover:underline transition duration-200">Masuk
                        di sini</a>
                </p>
            </div>
        </form>
    </div>
</body>

</html>
