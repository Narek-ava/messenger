import axios from 'axios';
import Echo from 'laravel-echo';
import io from 'socket.io-client'; // вот это нужно для socket.io

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.io = io;

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001',
    logToConsole: true,
    transports: ['websocket', 'polling', 'flashsocket'],
});
window.Echo.channel('some-channel')
    .listen('SomeTestEvent', (e) => {
        console.log('📡📡📡📡📡📡📡📡 Received event:', e);
    });
window.Echo.connector.socket.on('connect', () => {
    console.log('Socket connected 🚀🚀🚀🚀🚀🚀🚀🚀🚀🚀🚀');
});

window.Echo.connector.socket.on('connect_error', (err) => {
    console.log('Socket connection error:', err);
});

window.Echo.connector.socket.on('disconnect', () => {
    console.log('Socket disconnected');
});
