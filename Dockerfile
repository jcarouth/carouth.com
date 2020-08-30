# FROM composer:1.10 as vendor
# COPY composer.json composer.json
# COPY composer.lock composer.lock
# RUN composer install \
#     --ignore-platform-reqs \
#     --no-interaction \
#     --no-plugins \
#     --no-scripts \
#     --prefer-dist

# FROM node:14.2.0-stretch as frontend-build
# RUN mkdir -p /app/public
# COPY package.json package-lock.json tailwind.config.js webpack.mix.js /app/
# COPY tasks/ /app/tasks/
# WORKDIR /app
# RUN npm install

# FROM php:7.3-alpine
# RUN mkdir -p /app
# COPY . /app/
# COPY --from=vendor /app/vendor/ /app/vendor/
# COPY --from=frontend-build /app/node_modules/ /app/node_modules/
# WORKDIR /app
# RUN ./vendor/bin/jigsaw build
# CMD ["./vendor/bin/jigsaw", "serve", "--host=0.0.0.0", "--port=8000"]

FROM phusion/baseimage:bionic-1.0.0-amd64

RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
  && add-apt-repository -y ppa:ondrej/php \
  && install_clean \
    git \
    nodejs \
    php7.4-bcmath \
    php7.4-cli \
    php7.4-common \
    php7.4-curl \
    php7.4-gd \
    php7.4-imagick \
    php7.4-intl \
    php7.4-mbstring \
    php7.4-xml \
    php7.4-zip \
    zip \
    unzip

COPY --from=composer:1.10 /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

CMD [ "/sbin/my_init" ]

EXPOSE 8000
