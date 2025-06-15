<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') - ResikiApp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900">
    <header class="bg-blue-600 text-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between">
            <h1 class="text-xl font-semibold">ResikiApp</h1>
            <nav>
                <a href="{{ route('logout') }}" class="hover:underline">Logout</a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto px-4 py-6">
        @yield('content')
    </main>

    <footer class="text-center text-sm py-4 text-gray-600">
        &copy; {{ date('Y') }} ResikiApp. All rights reserved.
    </footer>
</body>
</html>
