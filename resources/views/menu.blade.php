<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ciao Bella Pizzeria</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Fonts & Icons -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<body class="bg-gray-100 text-gray-900">
    <style>
        .scrollbar-thin::-webkit-scrollbar {
            display: none;
            height: 6px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 3px;
        }
        .scrollbar-thin {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  
            scrollbar-width: thin;
            scrollbar-color: #e5e7eb #f3f4f6;
        }
    </style>

    <!-- Navbar -->
    <nav class="fixed z-50 top-0 w-full bg-black bg-opacity-100 shadow-md">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex h-20 items-center justify-between">
                <a href="/">
                    <img class="h-10 p-2" src="imgs/loggo.png" alt="home">
                </a>
                <div class="flex items-center space-x-4">
                    <a
                    href="/"
                    class="bg-white text-gray-900 font-semibold px-5 py-2 rounded-full shadow transition duration-200 ease-in-out hover:bg-gray-400 hover:shadow-lg"
                    >
                    Späť
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-24 max-w-7xl mx-auto px-4">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold">Ciao Bella Pizzeria</h1>
            <p class="text-gray-600 mt-2 text-lg">Menu</p>
        </div>
    
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left: Menu with Tabs -->
            <div class="lg:col-span-2 space-y-8">
                <div x-data="{ tab: '{{ $types->first() }}' }">
                    <!-- Scrollable Tabs -->
                    <div class="relative mb-8">
                        <!-- Left fade -->
                        <div class="pointer-events-none absolute left-0 top-0 h-full w-8 z-10 bg-gradient-to-r from-gray-100 to-transparent"></div>
                        <!-- Right fade -->
                        <div class="pointer-events-none absolute right-0 top-0 h-full w-8 z-10 bg-gradient-to-l from-gray-100 to-transparent"></div>
                        <!-- Scrollable tabs -->
                        <div
                          class="flex overflow-x-auto whitespace-nowrap gap-1 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100"
                        >
                          @foreach($types as $type)
                            <button
                              @click="tab = '{{ $type }}'"
                              :class="tab === '{{ $type }}'
                                ? 'bg-red-500 text-white border-b-2 border-red-700'
                                : 'text-gray-700 border-b-2 border-transparent hover:bg-gray-200'"
                              class="px-4 py-2 font-semibold transition focus:outline-none"
                              style="min-width: 180px;"
                              title="{{ ucfirst($type) }}"
                            >
                              {{ ucfirst($type) }}
                            </button>
                          @endforeach
                        </div>
                      </div>
                      
                    <!-- Menu Items by Type -->
                    @foreach($types as $type)
                    <div x-show="tab === '{{ $type }}'" x-cloak>
                        <h2 class="text-2xl font-bold mb-4">{{ ucfirst($type) }}</h2>
                        <div class="space-y-1">
                            @foreach($menuItems->where('type', $type) as $item)
                                <div class="bg-white shadow p-4 flex justify-between items-start">
                                    <div>
                                        <h3 class="text-lg font-bold">
                                            <span class="align-baseline">
                                                {{ $item->name }}
                                            </span>
                                            <span class="align-baseline">
                                                <div x-data="{ open: false }" class="relative inline-block">
                                                    <button
                                                        @click="open = !open"
                                                        class="ml-2 text-xs text-blue-600 hover:text-blue-800"
                                                        type="button"
                                                    >
                                                        Alergény
                                                    </button>
                                                    <div
                                                        x-show="open"
                                                        @click.away="open = false"
                                                        x-transition
                                                        class="absolute z-10 left-0 mt-2 w-56 bg-white border border-gray-200 rounded shadow-lg p-3 text-sm text-gray-700"
                                                    >
                                                        {{ $item->alergens ?: 'Žiadne alergény' }}
                                                    </div>
                                                </div>
                                            </span>
                                        </h3>
                                        
                                        <p class="text-sm text-gray-500">{{ $item->description }}</p>
                                        <p class="text-base font-semibold mt-1">€{{ number_format($item->price, 2) }}</p>
                                    </div>
                                    <form action="{{ url('/add-to-cart/' . $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1 rounded-lg">Pridať</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                
                </div>
            </div>

            <!-- Right: Cart -->
            <div class="bg-gray-100 rounded-2xl p-6 sticky top-28 h-fit">
                <h2 class="text-xl font-bold mb-4">Vaša objednávka</h2>
                @php
                $cart = session('cart', []);
                $total = 0;
                @endphp

                <div id="cart-items" class="space-y-2 text-sm">
                    @if(count($cart) > 0)
                    @foreach($cart as $id => $item)
                        @php
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        @endphp
                        <div class="flex justify-between items-center bg-white p-2 rounded shadow">
                            <div>
                                <p class="font-semibold">{{ $item['name'] }}</p>
                                <div class="flex items-center gap-2">
                                    <form method="POST" action="{{ url('/decrement-cart/' . $id) }}">
                                        @csrf
                                        <button
                                            class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-200 hover:bg-red-500 hover:text-white text-lg font-bold transition"
                                            type="submit"
                                            aria-label="Znížiť množstvo"
                                        >−</button>
                                    </form>
                                    <!-- Quantity input -->
                                    <form method="POST" action="{{ url('/update-cart-quantity/' . $id) }}">
                                        @csrf
                                        <input
                                            type="number"
                                            name="quantity"
                                            min="1"
                                            value="{{ $item['quantity'] }}"
                                            class="w-12 text-center border border-gray-300 rounded focus:ring-2 focus:ring-red-400 focus:border-red-400"
                                            onchange="this.form.submit()"
                                            aria-label="Zmeniť množstvo"
                                        >
                                    </form>
                                    <form method="POST" action="{{ url('/increment-cart/' . $id) }}">
                                        @csrf
                                        <button
                                            class="w-7 h-7 flex items-center justify-center rounded-full bg-gray-200 hover:bg-green-500 hover:text-white text-lg font-bold transition"
                                            type="submit"
                                            aria-label="Pridať množstvo"
                                        >+</button>
                                    </form>
                                </div>
                                <p class="text-gray-500 text-sm">€{{ number_format($item['price'], 2) }} x {{ $item['quantity'] }}</p>
                            </div>
                            <form method="POST" action="{{ url('/remove-from-cart/' . $id) }}">
                                @csrf
                                <button class="text-red-500 hover:text-red-700 text-xs">x</button>
                            </form>
                        </div>
                    @endforeach
               
                    @else
                        <p class="text-gray-400">Vaša objednávka je prázdna.</p>
                    @endif
                </div>

                <div class="border-t mt-4 pt-4">
                    <p class="font-semibold text-lg">Total: €{{ number_format($total, 2) }}</p>
                    @if(count($cart) > 0)
                        <button class="mt-3 w-full bg-green-500 hover:bg-green-600 text-white py-2 rounded-lg font-semibold">Zaplatiť</button>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-gray-200 py-8 mt-16">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
            <div>
                <h3 class="text-xl font-bold mb-2">Ciao Bella</h3>
                <p class="text-sm text-gray-400">Talianska reštaurácia v srdci Púchova.</p>
            </div>
            <div>
                <h4 class="font-semibold mb-2">Kontakt</h4>
                <p class="text-sm">Ul. 1. mája 899/23<br>02001 Púchov</p>
                <p class="text-sm mt-2">
                    <a href="mailto:veron.micietova@gmail.com" class="hover:text-white">veron.micietova@gmail.com</a><br>
                    <a href="tel:0949464033" class="hover:text-white">0949 464033</a>
                </p>
            </div>
        </div>
        <div class="mt-8 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} Ciao Bella. Všetky práva vyhradené.
        </div>
    </footer>

</body>
</html>

<script>
</script>