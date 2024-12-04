FROM php:8.1-fpm

USER root

WORKDIR /var/www

# Install dependencies
RUN apt-get update \
	# gd
	&& apt-get install -y --no-install-recommends build-essential  openssl nginx libfreetype6-dev libjpeg-dev libpng-dev libwebp-dev zlib1g-dev libzip-dev gcc g++ make vim unzip curl git jpegoptim optipng pngquant gifsicle locales libonig-dev supervisor cron  \
	&& docker-php-ext-configure gd  \
	&& docker-php-ext-install gd \
	# gmp
	&& apt-get install -y --no-install-recommends libgmp-dev \
	&& docker-php-ext-install gmp \
	# pdo_mysql
	&& docker-php-ext-install pdo_mysql mbstring \
	# pdo
	&& docker-php-ext-install pdo \
	# opcache
	&& docker-php-ext-enable opcache \
	# zip
	&& docker-php-ext-install zip \
	&& apt-get autoclean -y \
	&& rm -rf /var/lib/apt/lists/* \
	&& rm -rf /tmp/pear/ \

# Install extensions
RUN docker-php-ext-install pcntl
RUN pecl install redis && docker-php-ext-enable redis

# Copy files
COPY . /var/www

# Setup PHP
COPY ./docker/php/local.ini /usr/local/etc/php/local.ini

# Setup Nginx
COPY ./docker/nginx/conf.d/nginx.conf /etc/nginx/nginx.conf

## Setup supervisor
#COPY ./docker/supervisor/worker/worker-hight-priority-queue.conf /etc/supervisor/conf.d/
#COPY ./docker/supervisor/worker/worker-low-priority-queue.conf /etc/supervisor/conf.d/

RUN chmod +rwx /var/www

RUN chmod -R 777 /var/www

# setup composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer install --working-dir="/var/www"

RUN composer dump-autoload --working-dir="/var/www"

RUN bash /var/www/docker/provision/after-build.sh

EXPOSE 80

RUN ["chmod", "+x", "post_deploy.sh"]

CMD [ "sh", "./post_deploy.sh" ]
