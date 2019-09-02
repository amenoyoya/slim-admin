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

# -- slim-framework のスケルトン・プロジェクトを作成する場合、以下を実行 --

# projectディレクトリを空にする
% rm -Rf ./*

# slim-framework スケルトン構築
% composer create-project slim/slim-skeleton .

# -- すでに存在するプロジェクトを引き継ぐ場合、以下を実行 --

# Composer依存パッケージインストール
% composer install
```
