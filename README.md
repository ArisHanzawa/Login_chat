# チャットアプリ

チャットのWebアプリです。
PHP、Laravelを使用しユーザー管理を
MongoDBを使用してチャット機能を作成しています。
他Beezeなどのツールも使用しています。

##実行環境
* DockerVersion:           27.3.1
* Laravel Framework 9.52.16
* PHP                       8.2.25 (cli)
* Guzzlehttp                     7.9.2
* Using MongoDB:		8.0.1
* laravel/breeze           v1.19.2
* laravel/tinker             v2.10.0
* minishlink/web-push  v9.0.1
* nginx version: nginx/  1.20.2

## 使用ブラウザ
Safari、GoogleChrome、Microsoft Edge

~~firefox~~ ※WebPushとの相性が悪いため、firefoxはできませんでした。

## ドキュメント

ユーザー管理はLaravel公式ドキュメントをそのまま使っています。
https://qiita.com/keitaro-code/items/a22e782ed2b01a22a528
https://laravel.com/docs/10.x/authentication

チャットや通知部分は以下ドキュメントを参考にしました。
https://laravel.com/docs/10.x/routing
https://www.mongodb.com/ja-jp/docs/drivers/php-drivers/
https://shinke1987.net/?p=1264
https://qiita.com/kozamurai/items/f01cfd8fc5857524ddc2

一部viewや一部処理はcopilotに頼ったりしました。
dockerを噛ませたりしたことで出現したエラーも随時調べて解決していました。


## Github
* https://github.com/ArisHanzawa/Login_chat

## 環境構築方法

このアプリはDockerを使用しています。
以下、環境を構築する手順を説明します。

1. DockerDesktopアプリを開き、Dockerにログインする
    ※ターミナルなどのコマンドライン系アプリで　Docker login  でもok

2. docker-compose.ymlファイルがあるディレクトリの移動する

```
cd login_chat
```

3. コンテナのbuild、upをする

```
docker compose build
docker compose up -d
```

4. webコンテナのportに書いてあるurlにlocaolhostで表示させる

```
Docker ps
0.0.0.0:8080->80/tcp
```

ブラウザで *localhost:8080* にアクセスする。

5. laravel公式のデフォルト画面が映ったら環境構築は成功です。

## 使用方法
###ユーザー管理（登録）
1. 登録画面を表示する。
laravel画面右上の Register をクリックする。

2. ユーザー情報を入力する。
Name、Email Address、Password、Confirm Passwordを入力する

3. 登録完了
登録が完了し、Dashbordに「You are logged in!」と表示される


###ユーザー管理(ログアウト)
1. Home画面を表示する。
ログインしている状態で、laravelの画面から右上の Home をクリックする。

2. ログアウト
Home画面右上の登録した Name をクリックし、logout をクリックする。

###ユーザー管理(ログイン)
1. ログイン画面を表示する
laravel画面右上の Log in をクリックする。

2. 登録済ユーザー情報の入力。
登録したEmail Address、Passwordを入力する。

3. ログイン
Home画面に遷移し、Dashbordに「You are logged in!」と表示される

###チャット機能
1. ログイン後、Webpushの登録をする
ブラウザで localhost:8080/webpush にアクセスする
通知の許可を取得ボタンをクリックし、ブラウザにサービスワーカーを登録
開発者ツールを開き、アプリケーションタブを開く。
Service workersをクリックし、サービスワーカーが登録されていることを確認する。

2. チャットを送る
ブラウザで localhost:8080/chat にアクセスする
ユーザー名が表示されていることを確認する。（現在は確認のためuser_idが表示されています。）
テキストエリアに入力し、送信する。
別のブラウザでサービスワーカーが登録されていたら通知が表示される。

## 通知が表示されない場合
キャッシュクリアやブラウザに登録されたサービスワーカーに紐づけられたユーザーになっていることを確認する。
ブラウザのキャッシュクリア、ルートキャッシュクリアを試す。

```
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

## できる機能とできない機能

機能|可不可
------------- | ------------- |
ユーザー管理 |   ☑️
文字チャット |   ☑️
WebPush通知 |   ☑️
チャットルームの自動更新(アクティブウィンドウ) |   ☑️
チャットルームの自動更新（非アクティブウィンドウ）|  □
通知をクリックでチャットルームに移動 |  □


###追加したい機能
以下Githubのissueで管理しています。
https://github.com/ArisHanzawa/Login_chat/issues
