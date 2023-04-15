FROM php:8.1-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    mariadb-client \
    libzip-dev \
    cron \
    vim \
    supervisor \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN pecl install mongodb \
    &&  echo "extension=mongodb.so" > $PHP_INI_DIR/conf.d/mongo.ini
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Setup cron
COPY ./crontab.txt /crontab.txt
RUN crontab -u root /crontab.txt

# Setup Supervisor to run cron
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf
RUN chown -R root:root /var/log/supervisor/
CMD ["/usr/bin/supervisord"]

# Set working directoryuser
COPY . /var/www/
WORKDIR /var/www
RUN chown -R $user:$user /var/www
RUN chown -R www-data:www-data /var/www/storage
# find a way around this. it's gross
RUN chmod -R 777 /var/www/storage

# Login as root for access (temp)
USER root