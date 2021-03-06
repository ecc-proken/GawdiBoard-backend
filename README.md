# GawdiBoard バックエンド編

## GawdiBoard(ガウディーボード)とは

ECC コンピュータ専門学校専用の掲示板サイトです。

## 始め方

```bash
$ git clone https://github.com/ecc-proken/GawdiBoard-backend.git
$ cd GawdiBoard-backend
$ git config core.hooksPath .githooks
$ make init
```

## コンテナ構成

```bash
├── app
├── web
├── db
├── cron
└── worker
```

### app

-   ベースイメージ
    -   [php](https://hub.docker.com/_/php):8.0.12-fpm-bullseye
    -   [composer](https://hub.docker.com/_/composer):2.1

### web

-   ベースイメージ
    -   [nginx](https://hub.docker.com/_/nginx):nginx:1.20.1

### db

-   ベースイメージ
    -   [mysql](https://hub.docker.com/_/mysql):8.0

### cron

-   ベースイメージ
    -   [php](https://hub.docker.com/_/php):8.0.12-fpm-bullseye

### worker

-   ベースイメージ
    -   [php](https://hub.docker.com/_/php):8.0.12-fpm-bullseye

## APIドキュメント
```bash
$ make swagger
```
` http://localhost/api/documentation `
