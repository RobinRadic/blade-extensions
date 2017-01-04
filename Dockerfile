FROM ubuntu:latest

RUN apt-get update -y && apt-get upgrade -y
RUN apt-get install -y \
php \
php-json \
php-mcrypt \
php-mbstring \
php-curl \
php-gd \
php-cli  \
php-sqlite3  \
php-xml

ADD ./ ./www
WORKDIR /www
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === '61069fe8c6436a4468d0371454cf38a812e451a14ab1691543f25a9627b97ff96d8753d92a00654c21e2212a5ae1ff36') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
#RUN chmod +x composer.phar
#RUN cp composer.phar /usr/local/bin/composer
RUN php composer.phar install

RUN /usr/bin/php -S 127.0.0.1:8080 -t /www