FROM php:8.0-apache

# Install Composer
RUN apt-get update && apt-get install -y \
    unzip \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');" \
    && ln -s /usr/local/bin/composer /usr/bin/composer

# Install required PHP extensions and configure
RUN apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd zip pdo pdo_mysql

# Set the working directory
WORKDIR /var/www/html

CMD ["apache2-foreground"]