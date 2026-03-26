<?php

return [
    'token' => env('INSTAGRAM_ACCESS_TOKEN') ?: env('VITE_INSTAGRAM_ACCESS_TOKEN'),
    'weekly_menu_post_url' => env('INSTAGRAM_WEEKLY_MENU_POST_URL'),
    'profile_url' => env('INSTAGRAM_PROFILE_URL', 'https://www.instagram.com/ciao__bella_pizza/'),
    'debug' => env('INSTAGRAM_DEBUG', false),
];