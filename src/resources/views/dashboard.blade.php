<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                    <div class="mt-4">
                        1　First, access
                        <a href="{{ route('webpush.webpush') }}" class="btn btn-secondary btn-outline-primary">Web Push</a>
                        and verify that a dialog box appears asking for browser permissions.<br><br>
                        <a href="{{ route('webpush.webpush') }}" class="btn btn-secondary btn-outline-primary">Web Push</a><br><br>
                        2　Next, access
                        <a href="{{ route('chat.chat') }}" class="btn btn btn-primary">Chat</a>
                        and start chatting!<br><br>
                        <a href="{{ route('chat.chat') }}" class="btn btn btn-primary">Chat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
