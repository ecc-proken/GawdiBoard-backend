FROM nginx:1.20.1

ENV TZ='Asia/Tokyo'

RUN apt update

# nginx config file
COPY ./infra/docker/nginx/*.conf /etc/nginx/conf.d/

WORKDIR /work/backend
