<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>layout</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <script src="https://cdn.tailwindcss.com"></script>

    </head>
    <body>
        <!--
  This example requires updating your template:

  ```
  <html class="h-full bg-gray-100">
  <body class="h-full">
  ```
-->
<style>
  html {
    overflow-y: scroll;
  }
</style>
<div class="min-h-full">
  <nav class="fixed z-50 top-0 w-full bg-gray-900 bg-opacity-70 shadow-md">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex h-20 items-center justify-between">
        <div class="flex items-center">
          <div class="shrink-0">
            <img class="size-20" src="https://cdn.website.dish.co/media/4b/75/8173481/Ciao-Bella-Pizzeria-1670924146-png.jpg"  href="/" :active="request()->is('/')" alt="home">
          </div>
          <div class="hidden md:block">
            <div class="ml-60 flex items-baseline space-x-4">
              <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
              <x-nav-link href="/" :active="request()->is('menu')">Menu</x-nav-link>
              <x-nav-link href="/jobs" :active="request()->is('location')">Lokalita</x-nav-link>
              <x-nav-link href="/opening" :active="request()->is('opening')">Otváracie hodiny</x-nav-link>
              <x-nav-link href="/paymentopt" :active="request()->is('paymentopt')">Možnosti platby</x-nav-link>
              <x-nav-link href="/gallery" :active="request()->is('gallery')">Galéria</x-nav-link>
              <x-nav-link href="/about" :active="request()->is('about')">O nás</x-nav-link>
              <x-nav-link href="/services" :active="request()->is('services')">Služby</x-nav-link>
              <x-nav-link href="/contact" :active="request()->is('contact')">Kontakt</x-nav-link>
              <x-button href="/order">Objednať</x-button>
              <a href="{{ url('https://www.instagram.com/ciao__bella_pizza/') }}">
                <img src="{{ asset('https://img.icons8.com/win10/512/FFFFFF/instagram-new.png') }}" alt="ig_logo" class="size-8">
              </a>
              <a href="{{ url('https://www.facebook.com/profile.php?id=100085650819146') }}">
                <img src="{{ asset('https://upload.wikimedia.org/wikipedia/commons/thumb/0/05/Facebook_Logo_%282019%29.png/1024px-Facebook_Logo_%282019%29.png') }}" alt="fb_logo" class="size-8">
              </a>
          </div>
        </div>
        <div class="hidden md:block">
          {{-- <div class="ml-4 flex items-center md:ml-6">
            @guest
              <x-nav-link href="/login" :active="request()->is('login')">Log In</x-nav-link>
              <x-nav-link href="/register" :active="request()->is('register')">Register</x-nav-link>
            @endguest
          </div> --}}
        </div>
        <div class="-mr-2 flex md:hidden">
          <!-- Mobile menu button -->
          <button type="button" class="relative inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" aria-controls="mobile-menu" aria-expanded="false">
            <span class="absolute -inset-0.5"></span>
            <span class="sr-only">Open main menu</span>
            <!-- Menu open: "hidden", Menu closed: "block" -->
            <svg class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <!-- Menu open: "block", Menu closed: "hidden" -->
            <svg class="hidden size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </nav>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="md:hidden" id="mobile-menu">
      <div class="space-y-1 px-2 pb-3 pt-2 sm:px-3">
        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
        <x-nav-link href="/" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white" aria-current="page">Home</x-nav-link>
        <x-nav-link href="/jobs" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Jobs</x-nav-link>
        <x-nav-link href="/contact" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Contact</x-nav-link>
      </div>
      <div class="border-t border-gray-700 pb-3 pt-4">
        <div class="flex items-center px-5">
          <div class="shrink-0">
            <img class="size-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
          </div>
          <button type="button" class="relative ml-auto shrink-0 rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
            <span class="absolute -inset-1.5"></span>
            <span class="sr-only">View notifications</span>
            <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
              <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </nav>
  <main>
  </main>
</div>
</html>