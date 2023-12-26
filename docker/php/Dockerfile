FROM php:8.1-fpm

# composerインストール
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# 必要なパッケージのインストールとPHP拡張機能の有効化
RUN apt-get update \
    && apt-get install -y \
                git \
                zip \
                unzip \
                libonig-dev \
                libfreetype6-dev \ 
                libjpeg62-turbo-dev \
                libpng-dev \
                libjpeg-dev \
    && docker-php-ext-install \ 
                pdo_mysql \ 
                bcmath \
                gd \
    && docker-php-ext-configure gd \
                --with-freetype=/usr/include/ \
                --with-jpeg=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

RUN apt-get update
RUN apt-get -y install libzip-dev
RUN docker-php-ext-install zip

# xdebug
RUN pecl install xdebug-3.1.6 && docker-php-ext-enable xdebug

# mailhog
RUN echo 'sendmail_path = "/usr/local/bin/mhsendmail --smtp-addr=mailhog:1025"' > /usr/local/etc/php/conf.d/mhsendmail.ini
RUN curl -sSL https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail \
    && chmod +x mhsendmail \
    && mv mhsendmail /usr/local/bin/mhsendmail