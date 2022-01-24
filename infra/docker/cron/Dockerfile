FROM php:8.0.12-fpm-bullseye

# timezone environment
ENV TZ='Asia/Tokyo' \
    # locale
    LANG=ja_JP.UTF-8 \
    LANGUAGE=ja_JP:ja \
    LC_ALL=ja_JP.UTF-8 \
    # composer environment
    COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/composer

COPY --from=composer:2.1 /usr/bin/composer /usr/bin/composer

# cronインストール
RUN apt-get update && apt-get install -y cron

# cron設定を配置する
COPY ./infra/docker/cron/cron.root /etc/cron.d/cron

# ログを標準出力へ出力できるようにシンボリックリンクを作成する
RUN chmod 0644 /etc/cron.d/cron && ln -sf /proc/1/fd/1 /var/log/cron.log

# フォアグラウンドでcronを起動する
CMD cron -f
