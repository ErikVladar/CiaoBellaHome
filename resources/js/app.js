import './bootstrap';
import Instafeed from "instafeed.js";

const INSTA_TOKEN = import.meta.env.VITE_INSTAGRAM_ACCESS_TOKEN;

window.onload = function () {
    if (!INSTA_TOKEN) {
        console.error('Instagram access token is missing!');
        return;
    }
    new Instafeed({
        accessToken: INSTA_TOKEN,
        template:
            '<a href="{{link}}" target="_blank" class="w-full h-full"><img title="{{caption}}" class="w-full h-full" src="{{image}}"/></a>',
        debug: true,
        target: "instafeed",
        limit: 1,
    }).run();
};
