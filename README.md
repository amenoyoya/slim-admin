# slim-admin

Administrator page by PHP slim-framework

## Environment

- Docker: `19.03.2`
- DockerCompose: `1.24.0`

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
$ docker-compose start

# webコンテナにアタッチ
$ docker-compose exec web bash

# composer.json に記述されたパッケージをインストール
% composer install
```

#### Memo: Install Slim Framework
[公式リファレンス](https://www.slimframework.com/docs/v4/start/installation.html) を参考にインストール

```bash
# Install Slim Framework
% composer require slim/slim:4.0.0

# Install Slim PSR-7
% composer require slim/psr7

# Install Nyholm PSR-7 and Nyholm PSR-7 Server
% composer require nyholm/psr7 nyholm/psr7-server

# Install Guzzle PSR-7 and Guzzle HTTP Factory
% composer require guzzlehttp/psr7 http-interop/http-factory-guzzle

# Install Zend Diactoros
% composer require zendframework/zend-diactoros
```
