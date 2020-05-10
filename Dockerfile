FROM composer:1.10 as vendor
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

FROM node:14.2.0-stretch as frontend-build
RUN mkdir -p /app/public
COPY package.json package-lock.json tailwind.config.js webpack.mix.js /app/
COPY tasks/ /app/tasks/
WORKDIR /app
RUN npm install

FROM php:7.3-alpine
RUN mkdir -p /app
COPY . /app/
COPY --from=vendor /app/vendor/ /app/vendor/
COPY --from=frontend-build /app/node_modules/ /app/node_modules/
WORKDIR /app
RUN ./vendor/bin/jigsaw build
CMD ["./vendor/bin/jigsaw", "serve", "--host=0.0.0.0", "--port=8000"]
