このアプリは、チャットができるアプリです。

ユーザー管理はLaravel公式ドキュメントをそのまま使っています。
https://laravel.com/docs/10.x/authentication


このアプリはDockerを使用してコンテナの中でlaravelを動かしています。
以下、環境を構築する手順を説明します。

1、DockerDesktopアプリを開き、Dockerにログインする
    ※ターミナルなどのコマンドライン系アプリで　Docker loginしてもいい

2、docker-compose.ymlファイルがあるディレクトリの移動する
    cd LOGIN_CHAT

3、コンテナのbuild、upをする
    docker compose build
    docker compose up -d

4、web-1コンテナのportに書いてあるurlにlocaolhostで表示させる

5、laravel公式のデフォルトの画面が映ったら環境構築は成功です。

使用方法
ユーザー管理（登録）
１、登録画面を表示する。
laravel画面右上の　Register　をクリックする。
２、ユーザー情報を入力する。
Name、Email Address、Password、Confirm Passwordを入力する
３、登録完了
登録が完了し、Dashbordに「You are logged in!」と表示される

ユーザー管理(ログアウト)
１、Home画面を表示する。
ログインしている状態で、laravelの画面から右上のHomeをクリックする。
２、ログアウト
Home画面右上の登録したNameをクリックし、logoutをクリックする。

ユーザー管理(ログイン)
１、ログイン画面を表示する
laravel画面右上の　Log in をクリックする。

２、登録済ユーザー情報の入力。
登録したEmail Address、Passwordを入力する。

３、ログイン
Home画面に遷移し、Dashbordに「You are logged in!」と表示される
