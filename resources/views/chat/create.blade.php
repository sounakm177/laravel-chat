<x-app-layout>
    <div class="flex h-screen bg-gray-100">
        <!-- Include the sidebar partial -->
        @include('chat.partials.sidebar')

        <!-- Chat Area -->
        <div class="flex-1 flex flex-col">
            <!-- Chat Header -->
            <div class="p-4 bg-white border-b flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center">
                            {{ substr($chat->is_group ? $chat->name : $chat->users->where('id', '!=', auth()->id())->first()->name, 0, 1) }}
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-semibold">
                            {{ $chat->is_group ? $chat->name : $chat->users->where('id', '!=', auth()->id())->first()->name }}
                        </h2>
                        <span class="text-sm text-gray-500" id="typing-indicator"></span>
                    </div>
                </div>
            </div>

            <!-- Messages Area -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messages-container">
                @foreach($chat->messages as $message)
                    <div class="flex {{ $message->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[70%] {{ $message->user_id === auth()->id() ? 'order-2' : 'order-1' }}">
                            <div class="{{ $message->user_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-white' }} rounded-lg p-3 shadow-sm">
                                {{ $message->content }}
                            </div>
                            <div class="mt-1 text-xs text-gray-500 flex items-center {{ $message->user_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                {{ $message->created_at->format('g:i A') }}
                                @if($message->is_read && $message->user_id === auth()->id())
                                    <svg class="w-4 h-4 ml-1 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path>
                    </svg>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Message Input -->
            <div class="p-4 bg-white border-t">
                <form id="message-form" class="flex items-center space-x-2">
                    @csrf
                    <input type="text" 
                           id="message-input"
                           class="flex-1 rounded-lg border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200"
                           placeholder="Type your message..."
                           autocomplete="off">
                    <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                        Send
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        const chatId = {{ $chat->id }};
        const authUserId = {{ auth()->id() }};
        
        // Initialize Reverb
        window.Reverb.init();
        
        // Listen for new messages
        window.Reverb.listen(`chat.${chatId}`)
            .on('MessageSent', (e) => {
                appendMessage(e.message);
                scrollToBottom();
            })
            .on('UserTyping', (e) => {
                showTypingIndicator(e.user);
            });

        // Message form handling
        const messageForm = document.getElementById('message-form');
        const messageInput = document.getElementById('message-input');
        let typingTimeout;

        messageForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const content = messageInput.value.trim();
            if (!content) return;

            try {
                const response = await fetch(`/chat/${chatId}/messages`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ content })
                });

                if (response.ok) {
                    messageInput.value = '';
                }
            } catch (error) {
                console.error('Error sending message:', error);
            }
        });

        function appendMessage(message) {
            const container = document.getElementById('messages-container');
            // Implementation details...
        }

        function scrollToBottom() {
            const container = document.getElementById('messages-container');
            container.scrollTop = container.scrollHeight;
        }

        function showTypingIndicator(user) {
            if (user.id !== authUserId) {
                const indicator = document.getElementById('typing-indicator');
                indicator.textContent = `${user.name} is typing...`;
                setTimeout(() => {
                    indicator.textContent = '';
                }, 2000);
            }
        }

        // Auto scroll to bottom on page load
        scrollToBottom();
    </script>
    @endpush
</x-app-layout>