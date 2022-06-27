FROM php:7.4-fpm

#Install common soft
RUN apt-get update \
    && apt-get install -y \
        curl \
        libonig-dev \
# Clear cache
    && rm -rf /var/lib/apt/lists/* /var/cache/apt/archives/*

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql

# Install xDebug extension
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer --version

# Create and set working directory
WORKDIR /var/www/reviews

# Copy project to working directory
#COPY ./ /var/www/reviews/

CMD php-fpm
