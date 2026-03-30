<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    <title>Ciao Bella</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script src="https://cdn.tailwindcss.com"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Lightbox2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet" />
    <!-- Lightbox2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

</head>

<body class="font-[Quicksand]">
    {{-- <body class="font-[Tagesschrift]"> --}}
    <style>
        @font-face {
            font-family: 'Tagesschrift';
            src: url('/fonts/Tagesschrift/Tagesschrift-Regular.ttf') format('truetype');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }

        @font-face {
            font-family: 'Quicksand';
            src: url('/fonts/Quicksand/Quicksand-VariableFont_wght.ttf') format('truetype');
            font-weight: 400;
            font-style: normal;
            font-display: swap;
        }

        html {
            overflow-y: scroll;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-down {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .animate-fade-in {
            animation: fade-in 1s ease-out forwards;
        }

        .animate-fade-down {
            animation: fade-down 1s ease-out forwards;
        }

        .animate-fade-up {
            animation: fade-up 1s ease-out forwards;
        }

        .animate-bounce-slow {
            animation: bounce-slow 2s infinite;
        }

        /* From Uiverse.io by gharsh11032000 */
        .cta-button {
            margin-top: 2rem;
            cursor: pointer;
            position: relative;
            padding: 10px 24px;
            font-size: 18px;
            color: rgb(250, 250, 250);
            border: 2px solid rgb(255, 255, 255);
            border-radius: 10px;
            background-color: transparent;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
            overflow: hidden;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            inset: 0;
            margin: auto;
            width: 50px;
            height: 50px;
            border-radius: inherit;
            scale: 0;
            z-index: -1;
            background-color: rgb(250, 250, 250);
            transition: all 0.6s cubic-bezier(0.23, 1, 0.320, 1);
        }

        .cta-button:hover::before {
            scale: 5;
        }

        .cta-button:hover {
            color: #212121;
            scale: 1.1;
            box-shadow: 0 0px 20px rgba(193, 163, 98, 0.4);
        }

        .cta-button:active {
            scale: 1;
        }

        .cta-button-black {
            margin-top: 2rem;
            cursor: pointer;
            position: relative;
            padding: 10px 24px;
            font-size: 18px;
            color: rgb(0, 0, 0);
            border: 2px solid rgb(0, 0, 0);
            border-radius: 10px;
            background-color: transparent;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.23, 1, 0.320, 1);
            overflow: hidden;
        }

        .cta-button-black::before {
            content: '';
            position: absolute;
            inset: 0;
            margin: auto;
            width: 50px;
            height: 50px;
            border-radius: inherit;
            scale: 0;
            z-index: -1;
            background-color: rgb(0, 0, 0);
            transition: all 0.6s cubic-bezier(255, 255, 255, 1);
        }

        .cta-button-black:hover::before {
            scale: 5;
        }

        .cta-button-black:hover {
            color: #FFFFF;
            scale: 1.1;
            box-shadow: 0 0px 20px rgba(255, 255, 255, 0.4);
        }

        .cta-button-black:active {
            scale: 1;
        }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-box {
            background: white;
            color: black;
            padding: 2rem;
            border-radius: 12px;
            max-width: 900px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.4);
        }

        .modal-box p {
            text-align: left;
        }

        .modal-close {
            position: absolute;
            top: 12px;
            right: 16px;
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #999;
        }

        .modal-close:hover {
            color: #000;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    <button id="scrollToTopBtn"
        class="fixed bottom-6 right-6 z-50 w-12 h-12 bg-gray-800 text-white text-xl rounded-full shadow-lg 
         opacity-0 pointer-events-none hover:opacity-100 transition-opacity duration-300 
         flex items-center justify-center"
        aria-label="Scroll to top">
        ↑
    </button>
    <div class="min-h-full">
        <nav id="navbar" class="fixed top-0 z-50 w-full transition-all duration-300">
            <div class="mx-auto max-w-7xl px-1 sm:px-2 lg:px-3">
                <div class="flex items-center justify-between h-20">
                    <a>
                    </a>
                    <div class="hidden md:flex items-center space-x-4">
                        <x-nav-link href="#gallery" :active="request()->is('gallery')">Galéria</x-nav-link>
                        <x-nav-link href="#contact" :active="request()->is('contact')">Kontakt</x-nav-link>
                        <x-nav-link href="#location" :active="request()->is('location')">Lokalita</x-nav-link>
                        <x-nav-link href="/menu">Objednať</x-nav-link>
                    </div>
                    <div class="md:hidden z-50">
                        <button type="button"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                            aria-controls="mobile-menu" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="block h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu, show/hide based on menu state. -->
            <div class="md:hidden hidden absolute left-0 w-full top-0 bg-black bg-opacity-80 shadow-lg z-40"
                id="mobile-menu">
                <div class="px-4 py-3 divide-y divide-gray-700 space-y-0">
                    <a href="#gallery"
                        class="block py-4 px-3 text-base font-medium text-white hover:bg-gray-700">Galéria</a>
                    <a href="#contact"
                        class="block py-4 px-3 text-base font-medium text-white hover:bg-gray-700">Kontakt</a>
                    <a href="#location"
                        class="block py-4 px-3 text-base font-medium text-white hover:bg-gray-700">Lokalita</a>
                    <a href="/menu"
                        class="block py-4 px-3 text-base font-medium text-white hover:bg-gray-700">Objednať</a>
                </div>
            </div>


        </nav>
    </div>
    <div class="h-screen w-full relative bg-cover bg-center"
        style="background-image: url('imgs/main-bg.jpg');">
        <div class="absolute inset-0 bg-black/80"></div>

        <div class="relative flex flex-col items-center justify-center h-full text-white text-center px-6">
            <h1 class="text-5xl md:text-6xl font-extrabold font-poppins animate-fade-down">
                <img src="{{ asset('imgs/loggo.png') }}" alt="..." class="h-14">
                {{-- <i class="text-red-500">Ciao</i> <i>Bella</i> <i class="text-green-500">Pizzeria</i> --}}
            </h1>
            <p id="opening-hours" class="text-xl mt-4 animate-fade-up">Loading...</p>
            <div class="flex gap-4 mt-8">
                <a href="https://www.bistro.sk/restauracia/ciao-bella" class="cta-button">Objednať</a>
                <div x-data="{ showModal: false }"
                    x-effect="document.documentElement.classList.toggle('overflow-hidden', showModal)">
                    @php
                        $weeklyMenuEmbedUrl = null;
                        if (
                            !empty($weekly_menu_post_url) &&
                            preg_match(
                                '~instagram\\.com/(p|reel|tv)/([A-Za-z0-9_-]{5,})/?~i',
                                $weekly_menu_post_url,
                                $instagramMatch,
                            )
                        ) {
                            $weeklyMenuEmbedUrl = "https://www.instagram.com/{$instagramMatch[1]}/{$instagramMatch[2]}/embed";
                        }
                    @endphp
                    <button @click="showModal = true"
                        class="cta-button bg-blue-500 text-white px-4 py-2 rounded">Týždenné menu</button>
                    <!-- Modal Overlay -->
                    <div x-show="showModal" x-cloak
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999] p-4 overflow-hidden"
                        @keydown.escape.window="showModal = false">
                        <button @click="showModal = false"
                            class="absolute top-3 right-4 md:top-5 md:right-6 text-5xl leading-none text-white/80 hover:text-white"
                            aria-label="Zatvoriť modal">&times;</button>
                        <!-- Modal Box -->
                        <div class="w-full max-w-2xl h-[85vh] bg-white rounded-lg shadow-xl overflow-hidden flex flex-col"
                            @click.away="showModal = false">
                            <div class="flex-1 overflow-hidden">

                                @if ($weeklyMenuEmbedUrl)
                                    <iframe src="{{ $weeklyMenuEmbedUrl }}"
                                        class="w-full h-full border border-gray-200 rounded" allowtransparency="true"
                                        allowfullscreen loading="lazy" title="Instagram týždenné menu"></iframe>
                                @else
                                    <div
                                        class="h-full border border-dashed border-gray-300 rounded p-4 text-gray-700 bg-gray-50 flex items-center justify-center text-center">
                                        Príspevok s týždenným menu momentálne nie je dostupný.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <img src="imgs/bottom_to_top.png" alt="transition"
            class="absolute bottom-0 left-0 h-16 w-full z-20 pointer-events-none" />
    </div>


    <div class="block md:hidden w-full bg-white text-gray-800 overflow-hidden py-16">
        <!-- MOBILE ONLY: Carousel version -->
        <div class="">
            <div class="text-center font-poppins space-y-6 px-6">
                <h3 class="text-4xl font-bold text-gray-600">Naša ponuka</h3>
                <hr class="border-t border-gray-300 w-1/2 mx-auto my-6" />
            </div>

            <div id="default-carousel" class="relative w-full" data-carousel="slide">
                <div class="relative h-96 overflow-hidden md:h-96">
                    <!-- Item 1 (active) -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item="active">
                        <img src="imgs/1.jpg" class="block w-full h-full object-cover" alt="...">
                    </div>
                    <!-- Item 2 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="imgs/2.jpg" class="block w-full h-full object-cover" alt="...">
                    </div>
                    <!-- Item 3 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="imgs/3.jpg" class="block w-full h-full object-cover" alt="...">
                    </div>
                    <!-- Item 4 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="imgs/4.jpg" class="block w-full h-full object-cover" alt="...">
                    </div>
                    <!-- Item 5 -->
                    {{-- <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="imgs/kitchen.png" class="block w-full h-full object-cover" alt="...">
                    </div> --}}
                </div>
                <!-- Slider indicators -->
                <div class="absolute z-30 flex w-full justify-center bottom-5 space-x-3 rtl:space-x-reverse">
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1"
                        data-carousel-slide-to="0"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2"
                        data-carousel-slide-to="1"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3"
                        data-carousel-slide-to="2"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4"
                        data-carousel-slide-to="3"></button>
                    {{-- <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5"
                        data-carousel-slide-to="4"></button> --}}
                </div>

                <!-- Slider controls -->
                <button type="button"
                    class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-prev>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M5 1 1 5l4 4" />
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button"
                    class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
                    data-carousel-next>
                    <span
                        class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <div class="hidden mt-12 mb-12 md:flex max-w-7xl mx-auto px-6 md:space-x-12 items-center">
        <!-- Left: Headline & Text -->
        <div class="w-1/2 space-y-6">
            <h3 class="text-4xl font-bold text-gray-600 font-poppins">Naša ponuka</h3>
            <p class="text-lg leading-relaxed">
                Talianska kuchyňa je oslavou jednoduchosti a kvality surovín. Naša ponuka zahŕňa čerstvé cestoviny,
                autentické pizze pečené v peci, delikátne rizotá a bohaté talianske predjedlá. Nechýbajú ani klasické
                dezerty ako tiramisu a panna cotta. Každé jedlo je pripravené s dôrazom na chuť a tradičné talianske
                recepty, aby sme vám priniesli skutočný zážitok zo Stredomoria.
            </p>
            {{-- <a href="/ponuka.pdf" class="cta-button-black">Týždenné menu</a> --}}
        </div>
        <!-- Right: Static image preview (e.g., 1–2 representative images) -->
        <div class="w-1/2 grid grid-cols-2 gap-4">
            <a data-lightbox="gallery" data-title="Dish 1">
                <img src="imgs/1.jpg"
                    class="rounded-lg shadow object-cover h-48 w-full transform rotate-1 translate-x-2 translate-y-3"
                    alt="Italian dish">
            </a>
            <a data-lightbox="gallery" data-title="Dish 2">
                <img src="imgs/2.jpg"
                    class="rounded-lg shadow object-cover h-52 w-full transform -rotate-1 translate-x-4 translate-y-2"
                    alt="Italian dish">
            </a>
            <a data-lightbox="gallery" data-title="Dish 3">
                <img src="imgs/3.jpg"
                    class="rounded-lg shadow object-cover h-44 w-full transform rotate-1 translate-x-3 translate-y-1"
                    alt="Italian dish">
            </a>
            <a data-lightbox="gallery" data-title="Dish 4">
                <img src="imgs/4.jpg"
                    class="rounded-lg shadow object-cover h-50 w-full transform -rotate-1 translate-x-3 translate-y-1"
                    alt="Italian dish">
            </a>
        </div>


    </div>

    <section class="relative w-full overflow-hidden">

        <!-- Background Image -->
        <div class="absolute inset-0 bg-cover bg-center z-0"
            style="background-image: url('{{ asset('imgs/main-bg.jpg') }}');">
        </div>


        <!-- Dark Overlay -->

        <div class="absolute inset-0 bg-black bg-opacity-80 z-10"></div>
        <img src="imgs/top_to_bottom.png" alt="transition"
            class="absolute top-0 left-0 h-16 w-full z-20 pointer-events-none" />
        <img src="imgs/bottom_to_top.png" alt="transition"
            class="absolute bottom-0 left-0 h-16 w-full z-20 pointer-events-none" />
        <div
            class="font-poppins text-xl relative flex flex-col items-center mt-20 justify-center h-full text-white text-3xl font-bold space-y-4 z-40">
            <div class="max-w-6xl mx-auto px-6 text-center font-poppins">
                <h2 class="text-4xl font-extrabold mb-8">Služby</h2>
                <hr class="border-t border-gray-300 w-24 mx-auto mb-12" />
                <div class="grid grid-cols-1 md:grid-cols-3 gap-16 mb-20">
                    <!-- Kuchyňa -->
                    <div class="flex flex-col items-center">
                        <div
                            class="bg-neutral-primary-soft bg-gray-900 rounded-2xl block max-w-sm rounded-base shadow-xs">
                            <img src="imgs/kuchyna_.jpg" alt="Kuchyňa" class="h-64 w-full object-cover rounded-t-2xl" />
                            <div class="p-6">
                                <h3 class="mb-6 text-2xl font-semibold tracking-tight text-heading">Kuchyňa</h3>
                                <p class="text-base text-gray-400 mb-6 text-justify">Naša kuchyňa dotvára dokonalý
                                    zážitok.
                                    Moderná gastronómia s nádychom talianských chutí, inšpirovaná tajomstvom nášho
                                    šéfkuchára.
                                    Kvalitné suroviny, chrumkavé jedlá a precízna príprava sú pre nás samozrejmosťou.
                                    Každé
                                    jedlo je malým gurmánskym potešením.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Bar -->
                    <div class="flex flex-col items-center">
                        <div
                            class="bg-neutral-primary-soft bg-gray-900 rounded-2xl block max-w-sm rounded-base shadow-xs">
                            <img src="imgs/bar_.png" alt="Kuchyňa" class="h-64 w-full rounded-t-2xl" />
                            <div class="p-6">
                                <h3 class="mb-6 text-2xl font-semibold tracking-tight text-heading">Bar</h3>
                                <p class="text-base text-gray-400 mb-6 text-justify">Bar je miestom, kde sa chute
                                    stretávajú s
                                    atmosférou. Ponúkame výber kvalitných vín, originálnych miešaných drinkov aj
                                    obľúbených
                                    klasík. Či už si prídete vychutnať drink po práci alebo osláviť výnimočný večer, náš
                                    bar vás
                                    nesklame.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Rozvoz -->
                    <div class="flex flex-col items-center">
                        <div
                            class="bg-neutral-primary-soft bg-gray-900 rounded-2xl block max-w-sm rounded-base shadow-xs">
                            <img src="imgs/rozvoz.png" alt="Kuchyňa" class="h-64 w-full rounded-t-2xl" />
                            <div class="p-6">
                                <h3 class="mb-6 text-2xl font-semibold tracking-tight text-heading">Rozvoz</h3>
                                <p class="text-base text-gray-400 mb-6 text-justify">Nemáte čas prísť osobne? Nevadí.
                                    Naše
                                    jedlá
                                    vám privezieme až ku dverám – čerstvé, horúce a chutné, akoby ste sedeli priamo v
                                    reštaurácii. Rýchly a spoľahlivý rozvoz je súčasťou nášho záväzku voči vašej
                                    spokojnosti.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </div>
    <section id="gallery">
        <div class="flex flex-col items-center justify-center min-h-screen bg-white px-20">
            {{-- <script src="https://elfsightcdn.com/platform.js" async></script>
            <div class="elfsight-app-a12848b1-2d59-4099-9694-cdd694ccecfc" data-elfsight-app-lazy></div> --}}
            <div class="sk-instagram-feed" data-embed-id="25668083"></div>
            <script src="https://widgets.sociablekit.com/instagram-feed/widget.js" defer></script>
        </div>
    </section>

    <x-contact />

    <section id="location">
        <div class="h-screen w-full flex items-center justify-center bg-gray-700 text-gray-800 text-3xl font-bold">
            <div class="h-screen w-full">
                <iframe class="w-full h-full"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2611.2894938723816!2d18.31893067615508!3d49.11913687136872!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f50.0!3m3!1m2!1s0x47148f57a7f8911f%3A0x56b8edd0984ab40b!2sUl.%201.%20m%C3%A1ja%20899%2F23%2C%20020%2001%20P%C3%BAchov!5e0!3m2!1sen!2ssk!4v1742150244525!5m2!1sen!2ssk"
                    style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
        </div>
    </section>

    <footer class="bg-black text-gray-200 py-8">
        <div class="mt-2 text-center text-xs text-gray-500">
            &copy; 2025 Ciao Bella. Všetky práva vyhradené.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.3.0/dist/flowbite.min.js"></script>
</body>

<script>
    window.addEventListener("scroll", function() {
        const navbar = document.getElementById("navbar");
        if (window.scrollY > 500) {
            navbar.classList.add("bg-black", "bg-opacity-80", "backdrop-blur", "shadow-lg");
        } else {
            navbar.classList.remove("bg-black", "bg-opacity-80", "backdrop-blur", "shadow-lg");
        }
    });

    function updateOpeningHours() {

        const currentDate = new Date();
        const hours = currentDate.getHours();

        const paragraph = document.getElementById("opening-hours");

        if (hours >= 10 && hours < 22) {
            paragraph.textContent = "Dnes máme otvorené do 22:00";
        } else {
            paragraph.textContent = "Prepáčte, máme zatvorené. Máme otvorené zajtra od 10:00 do 22:00";
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const toggleButton = document.querySelector('[aria-controls="mobile-menu"]');
        const mobileMenu = document.getElementById("mobile-menu");

        toggleButton.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });
    });

    const scrollBtn = document.getElementById("scrollToTopBtn");

    window.addEventListener("scroll", () => {
        if (window.scrollY > 300) {
            scrollBtn.classList.add("opacity-60");
            scrollBtn.classList.remove("opacity-0", "pointer-events-none");
        } else {
            scrollBtn.classList.add("opacity-0", "pointer-events-none");
            scrollBtn.classList.remove("opacity-60");
        }
    });

    scrollBtn.addEventListener("click", () => {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    });

    updateOpeningHours();
</script>
