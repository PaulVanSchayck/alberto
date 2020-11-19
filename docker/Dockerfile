FROM php:7.3-apache-buster

# Install some base packages
RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
	    curl \
	    git \
	    nano \
	    telnet \
	    iproute2 \
	    default-mysql-client \
	    libjpeg-dev \
	    libpq-dev \
	    libxslt1-dev \
	    libmagickwand-dev \
	    libicu-dev \
	    libzip-dev \
	    libmcrypt-dev \
	    unzip \
	    ghostscript \
    && rm -rf /var/lib/apt/lists/*

# Install the PHP extensions we need
RUN docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr \
    && docker-php-ext-install gd pdo_mysql intl xsl zip bcmath

# Install imagick
RUN pecl install imagick \
    && docker-php-ext-enable imagick

# See changelog at https://pecl.php.net/package-changelog.php?package=xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_host=docker-host" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Enable mod_rewrite
RUN a2enmod rewrite

# Change apache document root
ENV APACHE_DOCUMENT_ROOT /opt/app/web

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Changes to allow to run as www-data
# Change apache port to non priveliged port
RUN sed -ri -e "s/80/8080/g" /etc/apache2/sites-available/000-default.conf /etc/apache2/ports.conf
# Change www-data to uid 1000 and gid 1000
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data
# Make www-data home dir writable
RUN chown -R www-data:www-data /var/www

# Composer
RUN curl -fSL https://getcomposer.org/download/1.10.5/composer.phar -o /usr/bin/composer \
	&& chmod +x /usr/bin/composer

# DB base
ADD data/ /opt/

# Bootstrap
ADD docker/bootstrap.sh /opt/bootstrap.sh
RUN chmod +x /opt/bootstrap.sh

# Finalise
EXPOSE 8080
USER www-data
WORKDIR /opt/app
VOLUME [ "/opt/app" ]
ENTRYPOINT [ "/opt/bootstrap.sh" ]
