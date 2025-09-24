require('./bootstrap');

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true
});

// Function to listen for new messages
Echo.private('chat.{chatId}')
    .listen('MessageSent', (e) => {
        // Handle the new message
        console.log('New message:', e.message);
        // Update the chat UI accordingly
    });

// Function to show typing indicator
let typingTimer;
const typingDelay = 300; // milliseconds

const messageInput = document.getElementById('message-input');
messageInput.addEventListener('keyup', () => {
    clearTimeout(typingTimer);
    window.Echo.private('chat.{chatId}').whisper('typing', {
        user: userId
    });
    typingTimer = setTimeout(() => {
        // Stop typing indicator
    }, typingDelay);
});

// Listen for typing events
Echo.private('chat.{chatId}')
    .whisper('typing', (e) => {
        console.log(`${e.user} is typing...`);
        // Show typing indicator in the UI
    });