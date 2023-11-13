// import Echo from "../../laravel-echo";
// import Echo from '../../node_modules/laravel-echo/dist/echo.js';
// import Pusher from '../../node_modules/pusher-js';
// import Pusher from "pusher-js";
// import Echo from 'laravel-echo';
import Echo from 'laravel-echo/dist/echo';
import Pusher from "pusher-js";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: "myKey",
    cluster: "mt1",
    // Additional configuration options if required
});
