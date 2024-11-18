<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app">
        <h1>Chat</h1>
        <form action="{{ route('chat.store') }}" method="POST">
            @csrf
            <input type="text" name="message" placeholder="Enter your message">
            <button type="submit">Send</button>
        </form>
        <ul>
            @foreach($messages as $message)
                <li>{{ $message->created_at }} - {{ $message->message }}</li>
            @endforeach
        </ul>
    </div>
</body>
</html>
