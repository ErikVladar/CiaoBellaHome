<div>
    <x-contact.main-block src="{{ asset('imgs/loggo.png') }}">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-10">
            <!-- Otváracie hodiny -->
            <div class="flex flex-col justify-start items-center">
                <h1 class="text-4xl font-extrabold">Otváracie hodiny</h1>
                <hr class="border-t border-gray-300 w-full max-w-[300px] my-4" />
                <div class="grid w-full max-w-xs gap-y-4 text-left text-lg font-light">
                    <div class="flex justify-between w-full leading-tight">
                        <p>Pondelok</p>
                        <p>10:00 – 22:00</p>
                    </div>
                    <div class="flex justify-between w-full leading-tight">
                        <p>Utorok</p>
                        <p>10:00 – 22:00</p>
                    </div>
                    <div class="flex justify-between w-full leading-tight">
                        <p>Streda</p>
                        <p>10:00 – 22:00</p>
                    </div>
                    <div class="flex justify-between w-full leading-tight">
                        <p>Štvrtok</p>
                        <p>10:00 – 22:00</p>
                    </div>
                    <div class="flex justify-between w-full leading-tight">
                        <p>Piatok</p>
                        <p>10:00 – 22:00</p>
                    </div>
                    <div class="flex justify-between w-full leading-tight">
                        <p>Sobota</p>
                        <p>10:00 – 22:00</p>
                    </div>
                    <div class="flex justify-between w-full leading-tight">
                        <p>Nedeľa</p>
                        <p>10:00 – 22:00</p>
                    </div>
                </div>
            </div>

            <!-- Kontakt -->
            <div class="flex flex-col items-center">
                <h1 class="text-4xl font-extrabold">Kontakt</h1>
                <hr class="border-t border-gray-300 w-full max-w-[280px] my-4" />
                <div class="pl-10 flex flex-col space-y-6 mt-4">
                    <!-- Row 1 -->
                    <div class="flex">
                        <div class="w-8 flex justify-center">
                            <i class="material-icons text-2xl">location_on</i>
                        </div>
                        <div class="ml-4 text-left text-gray-400 text-lg font-light leading-snug">
                            Ul. 1. mája 899/23<br>02001 Púchov<br>Slovensko
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="flex">
                        <div class="w-8 flex justify-center">
                            <i class="material-icons text-2xl">email</i>
                        </div>
                        <a href="mailto:veron.micietova@gmail.com"
                            class="ml-4 text-gray-400 text-lg font-light hover:text-gray-700">
                            veron.micietova@gmail.com
                        </a>
                    </div>

                    <!-- Row 3 -->
                    <div class="flex">
                        <div class="w-8 flex justify-center">
                            <i class="material-icons text-2xl">call</i>
                        </div>
                        <a href="tel:0949464033" class="ml-4 text-gray-400 text-lg font-light hover:text-gray-700">
                            0949 464 033
                        </a>
                    </div>
                </div>
            </div>
            <!-- Sociálne siete -->
            <div class="flex flex-col items-center">
                <h1 class="text-4xl font-extrabold">Sociálne siete</h1>
                <hr class="border-t border-gray-300 w-full max-w-[250px] my-4" />
                <div class="flex gap-8">
                    <a href="https://www.instagram.com/ciao__bella_pizza/" target="_blank">
                        <img src="{{ asset('imgs/instagram_icon_white.png') }}" alt="Instagram" class="w-14 h-14">
                    </a>
                    <a href="https://www.facebook.com/profile.php?id=100085650819146" target="_blank">
                        <img src="{{ asset('imgs/facebook_icon_white.png') }}" alt="Facebook" class="w-14 h-14">
                    </a>
                </div>
            </div>
        </div>
    </x-contact.main-block>
</div>
