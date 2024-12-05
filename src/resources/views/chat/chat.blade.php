<!DOCTYPE html>
<html lang="ja">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat</title>
</head>
<body>
    <h1>Chat</h1>
    <h2>{{ $userId }}</h2>
    <form action="{{ route('chat.store') }}" method="POST">
        @csrf
        <input type="text" name="message" placeholder="テキストを入力">
        <button type="submit">送信</button>
    </form>
    <ul>
        @foreach($messages as $message)
            <li>{{ $message->created_at }} - {{ $message->message }}</li>
        @endforeach
    </ul>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messages = document.querySelectorAll('li[data-message-id]');
            messages.forEach(message => {
                const messageId = message.getAttribute('data-message-id');
                fetch(`/chat/read/${messageId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
            });
        });
    </script>
</body>
</html>
