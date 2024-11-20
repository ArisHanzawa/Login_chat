<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>webpush.blade.php</title>
    <script src="app.js"></script>
</head>
<body>

webpush.blade.php<br>
<br>
<button
    type="button"
    onclick="getPermission()"
>
    通知の許可を取得
</button>
<br><br>
<button
    type="button"
    onclick="updateSw()"
>
    サービスワーカーを更新
</button>

</body>
</html>
