<div>

    <x-contact.main-block src="https://ciaobellabowling.sk/build/assets/logo_hd-I-n2U32M.png">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-10">
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
                            Dvory 1913/16<br>02001 Púchov<br>Slovensko
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="flex">
                        <div class="w-8 flex justify-center">
                            <i class="material-icons text-2xl">email</i>
                        </div>
                        <a href="mailto:info@ciaobellabowling.sk"
                            class="ml-4 text-gray-400 text-lg font-light hover:text-gray-700">
                            info@ciaobellabowling.sk
                        </a>
                    </div>

                    <!-- Row 3 -->
                    <div class="flex">
                        <div class="w-8 flex justify-center">
                            <i class="material-icons text-2xl">call</i>
                        </div>
                        <a href="tel:+421949464033" class="ml-4 text-gray-400 text-lg font-light hover:text-gray-700">
                            +421 949 464 033
                        </a>
                    </div>
                </div>
            </div>
            <!-- Sociálne siete -->
            <div class="flex flex-col items-center">
                <h1 class="text-4xl font-extrabold">Sociálne siete</h1>
                <hr class="border-t border-gray-300 w-full max-w-[250px] my-4" />
                <div class="flex gap-8">
                    <a href="https://www.instagram.com/ciao_bella_bowling__/" target="_blank">
                        <img src="{{ asset('imgs/instagram_icon_white.png') }}" alt="Instagram" class="w-14 h-14">
                    </a>
                    <a href="https://www.facebook.com/profile.php?id=61567787397547" target="_blank">
                        <img src="{{ asset('imgs/facebook_icon_white.png') }}" alt="Facebook" class="w-14 h-14">
                    </a>
                </div>
                <div class="text-md mt-12 text-center w-full max-w-[250px] mx-auto">
                    <p>V Ciao Bella Bowling máte možnosť si rezervovať súkromné akcie!</p>
                </div>
            </div>
        </div>
    </x-contact.main-block>
</div>
