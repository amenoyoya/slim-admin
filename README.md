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
