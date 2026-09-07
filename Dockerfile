FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        intl \
        mysqli \
        pdo \
        pdo_mysql \
        gd \
        zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chmod -R 777 writable

EXPOSE 8080

# # CMD php spark serve --host=0.0.0.0 --port=${PORT:-8080}
CMD php -S 0.0.0.0:${PORT:-8080} -t public

# EXPOSE 8080

# CMD ["sh", "-c", "echo PORT=$PORT && php spark serve --host=0.0.0.0 --port=${PORT:-8080}"]

