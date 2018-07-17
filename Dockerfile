FROM php:7.1-apache

RUN apt-get update -y
#RUN apt-get install vim git wget zip unzip -y
#RUN apt-get install git -y
RUN apt-get install vim -y
RUN apt-get install wget -y
RUN apt-get install zip -y
RUN apt-get install unzip -y
RUN apt-get install zlib1g-dev -y
RUN apt-get install iputils-ping -y
RUN apt-get install mysql-client -y

#Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
	php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" && \
	php composer-setup.php --install-dir=/bin --filename=composer && \
	php -r "unlink('composer-setup.php');"

#PHP Unit
RUN wget https://phar.phpunit.de/phpunit-6.4.phar && \
	chmod +x phpunit-6.4.phar && \
	mv phpunit-6.4.phar /usr/local/bin/phpunit

#pdo_mysql
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip

#XDebug
RUN wget http://xdebug.org/files/xdebug-2.5.4.tgz && \
	tar -xvzf xdebug-2.5.4.tgz && \
	cd xdebug-2.5.4 && \
	phpize && \
	./configure && \
	make && \
	cp modules/xdebug.so /usr/local/lib/php/extensions/no-debug-non-zts-20160303

#Enabling module rewrite.
RUN a2enmod rewrite

#Copy config files
COPY server_config/000-default.conf /etc/apache2/sites-enabled
COPY server_config/xdebug.ini /usr/local/etc/php/conf.d

WORKDIR /var/www

EXPOSE 80