<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ciao Bella Pizzeria</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Tailwind CSS via CDN (for quick setup) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Optional: Include your own styles/scripts here --}}
</head>
<body class="bg-gray-50 text-gray-900">

    {{-- Navbar (optional) --}}
    <header class="bg-white shadow mb-6">
        <div class="container mx-auto p-4">
            <h1 class="text-2xl font-bold">Ciao Bella</h1>
        </div>
    </header>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer (optional) --}}
    <footer class="text-center text-gray-500 text-sm py-6">
        &copy; {{ date('Y') }} Ciao Bella Pizzeria. All rights reserved.
    </footer>

</body>
</html>
