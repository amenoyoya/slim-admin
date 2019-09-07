# slim-admin

Administrator page by PHP slim-framework

## Environment

- Docker: `19.03.2`
- DockerCompose: `1.24.0`
- CLI:
    - Node.js: `10.15.3`
    - yarn: `1.15.2`

### Structure
```conf
./
 |_ db/  # dbコンテナ
 |   |_ initdb.d/  # 初期データベース流し込み用
 |   |_ Dockerfile # ビルド設定
 |   |_ my.cnf     # MySQL設定
 |
 |_ html/ # Webアプリケーション本体
 |   |_ ...
 |
 |_ web/  # webコンテナ
 |   |_ 000-default.conf # VirtualHost設定
 |   |_ Dockerfile       # ビルド設定
 |   |_ php.ini          # PHP設定
 |
 |_ docker-compose.yml  # DockerComposeビルド設定
                        # - web:     PHP 7.2 (+ composer) + Apache 2.4 | http://slim-admin.localhost
                        # - db:      MySQL 5.7
                        # - pma:     phpMyadmin latest | http://pma.slim-admin.localhost
                        # - mailhog: SMTP server | http://mail.slim-admin.localhost
```

### Setup
```bash
# Dockerコンテナをビルド＆起動
$ docker-compose build
$ docker-compose up -d

# webコンテナにアタッチ
$ docker-compose exec web bash

# composer.json に記述されたパッケージをインストール
% composer install

# webコンテナからデタッチ
% exit

# wwwディレクトリに移動
$ cd www

# nodejs開発開始
$ yarn install # 依存パッケージインストール
$ yarn watch # js, vue ファイル変更検知＆バンドル
```

#### Memo: Install Slim Framework
- Environment:
    - slim: `3.12`
        - PHP: 5.5 or newer
        - Web server with URL rewriting

※ slim:4.x は PHP 7.1 以上必須のため、今回は見送り

```bash
# Install Slim Framework
% composer require slim/slim "^3.12"
```

***

## Description

### Backend: PHP Slim Framework
バックエンドではAPIの提供のみ行うことを想定している

- `www/html/index.php` ※ 基本的にいじらない
    - フレームワークのエントリーポイント
    - htaccessにより、存在しないパスへのアクセスは全てこのファイルにリダイレクトされる
    - CSRFトークンと最低限のHTMLの生成を行う
        - CSRFトークン: $_SESSION['csrf_token'] に保存
        - 最低限のHTML: `www/html/app/config.php` で設定
- `www/html/app/app.php` ※ 基本的にいじらない
    - Slimフレームワークの薄いラッパークラス `Slim\Framework\Application` を定義
        - `get`, `post`, `put`, `delete` staticメソッド:
            - `(route::string, (::Request, ::Response, args::array) -> ::Response) -> ::void`
            - それぞれのHTTPメソッドのリクエストをルーティングする処理を定義
        - `api` staticメソッド:
            - `(method::string, route::string, (::Request, ::Response, args::array, json::array) -> ::Response) -> ::void`
            - 同一サーバー内からの実行のみを許可するAPIを定義
            - CSRFトークンとホスト名をチェックする
- `www/html/app/config.php`
    - 各種設定を行うためのファイル
        - **HOST_NAME**:
            - `Slim\Framework\Application::api`メソッドで定義されるAPIの実行を許可するホスト名を設定
        - **HOME_HTML**:
            - ドキュメントルートで生成されるHTMLを定義
            - アプリケーションは Vue で動かすことを前提としているため、基本的にいじることはない
- `www/html/app/api.php`
    - このファイルにAPIを定義していく
    - ユーザー認証関係の組み込みAPI:
        - `/api/login/`: POST
            - ログインするためのAPI
            - リクエスト:
                - `csrf_token`: 設定を変えていなければ `document.getElementById('#csrf').value` で取得できる値
                - `username`: ユーザー名
                - `password`: ログインパスワード
            - レスポンス:
                - `auth`: 認証されたら true, それ以外なら false
                - `token`: 認証されたら認証トークンが入る
                - `username`: 認証されたらログインユーザー名が入る
                - `message`: エラーメッセージやデバッグメッセージが入る
        - `/api/auth/`: POST
            - ログインしているか（認証トークンが有効か）確認するAPI
            - リクエスト:
                - `csrf_token`: 設定を変えていなければ `document.getElementById('#csrf').value` で取得できる値
                - `auth_token`: ログイン時に返ってきた認証トークン
            - レスポンス:
                - `auth`: 認証トークンが有効なら true, それ以外なら false
                - `message`: エラーメッセージやデバッグメッセージが入る
        - `/api/auth/session/`: POST
            - セッションから認証トークンを再取得するAPI
                - ブラウザリロードにより vuex store で保存していた認証トークンが消えてしまった場合などに使う
            - リクエスト:
                - `csrf_token`: 設定を変えていなければ `document.getElementById('#csrf').value` で取得できる値
            - レスポンス:
                - `token`: セッションに認証トークンがあればそれが入り, なければ 'null' が入る
                - `username`: セッションに認証トークンがあればユーザー名が入り, なければ '' が入る
        - `/api/logout/`: POST
            - ログアウト（セッションから認証トークンを削除）するAPI
            - リクエスト:
                - `csrf_token`: 設定を変えていなければ `document.getElementById('#csrf').value` で取得できる値
            - レスポンス:
                - `token`: 常に 'null' が入る
                - `username`: 常に '' が入る

### Database: Phinx + php-activerecord
- マイグレーション: Phinx
    - 設定ファイル: `www/html/phinx.yml`
    - コマンド:
        ```bash
        # webコンテナにアタッチ
        $ docker-compose exec web bash

        ---

        # マイグレーションファイル作成
        % vendor/bin/phinx create <MigrationName>
        ## -> db/migrations/xxxxxxxx_migration_name.php 生成

        # マイグレーション実行
        % vendor/bin/phinx migrate

        # マイグレーションrollback
        % vendor/bin/phinx rollback
        ```

### Frontend: Vue + Vuex + Vue-Router
- Vue: 認証関連の情報を保存
    - state:
        - `auth`:
            - `token`: 認証トークン
            - `username`: ログインユーザー名
    - mutations:
        - `authenticate`:
            - `auth {token, username}` state を更新する
- Vue-Router:
    - ルーティングのメタ情報として `auth: true` を指定すると認証が必要なページになる
