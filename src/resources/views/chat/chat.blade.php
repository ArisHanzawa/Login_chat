<!DOCTYPE html>
<html lang="ja">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat</title>
</head>
<body>
    <h1>Chat</h1>
    <h2>開発中はuserIdを表示します。<br>{{ $userId }}</h2>
    <form action="{{ route('chat.store') }}" method="POST">
        @csrf
        <input type="text" name="message" placeholder="テキストを入力">
        <button type="submit">送信</button>
    </form>
    <ul id="chat-messages">
        @foreach($messages as $message)
            <li data-message-id="{{ $message->id }}">
                {{ $message->created_at }} - {{ $message->message }}
                @if(is_array($message->read_by) && count($message->read_by) > 1)
                    <span>既読{{ count($message->read_by) - 1 }}</span>
                @endif
            </li>
        @endforeach
    </ul>

    <script src="{{ asset('js/chat.js')}}"></script>
</body>
</html>
