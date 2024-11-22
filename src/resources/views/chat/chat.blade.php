<!DOCTYPE html>
<html lang="ja">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</body>
</html>
