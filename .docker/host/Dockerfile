FROM php:8.3.4-apache

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    IPE_GD_WITHOUTAVIF=1 install-php-extensions mysqli bcmath bz2 calendar dba enchant exif gettext gmp imap intl ldap odbc opcache pdo_mysql pdo_odbc pdo_pgsql pgsql pspell soap sockets sysvmsg sysvsem sysvshm tidy xsl zip gd

RUN apt-get update && apt-get upgrade -y
RUN a2enmod rewrite

RUN echo 'SetEnv MYSQL_HOST ${MYSQL_HOST}' > /etc/apache2/conf-enabled/environment.conf
RUN echo 'SetEnv MYSQL_DATABASE ${MYSQL_DATABASE}' > /etc/apache2/conf-enabled/environment.conf
RUN echo 'SetEnv MYSQL_USER ${MYSQL_USER}' > /etc/apache2/conf-enabled/environment.conf
RUN echo 'SetEnv MYSQL_PASSWORD ${MYSQL_PASSWORD}' > /etc/apache2/conf-enabled/environment.conf
RUN echo 'SetEnv NETWORK_PRIMARY_ENCRYPTION_KEY ${NETWORK_PRIMARY_ENCRYPTION_KEY}' > /etc/apache2/conf-enabled/environment.conf
RUN echo 'SetEnv NETWORK_MINOR_ENCRYPTION_KEY ${NETWORK_MINOR_ENCRYPTION_KEY}' > /etc/apache2/conf-enabled/environment.conf
RUN echo 'SetEnv EMAILER_KEY ${EMAILER_KEY}' > /etc/apache2/conf-enabled/environment.conf
RUN echo 'SetEnv NETWORK_SUPER_USER_PASSPHRASE ${NETWORK_SUPER_USER_PASSPHRASE}' > /etc/apache2/conf-enabled/environment.conf
RUN echo 'SetEnv ENVIRONMENT ${ENVIRONMENT}' > /etc/apache2/conf-enabled/environment.conf
RUN echo 'SetEnv DOCKER_DEBUG ${DOCKER_DEBUG}' > /etc/apache2/conf-enabled/environment.conf


RUN service apache2 restart