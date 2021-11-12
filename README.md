# GawdiBoard バックエンド編

## GawdiBoard(ガウディーボード)とは

ECC コンピュータ専門学校専用の掲示板サイトです。

## 始め方

```bash
$ git clone https://github.com/ecc-proken/GawdiBoard-backend.git
$ cd GawdiBoard-backend
$ make init
```

## コンテナ構成

```bash
├── app
├── web
└── db
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
