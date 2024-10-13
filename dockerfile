# Usando a imagem base do PHP com Apache
FROM php:7.4.9-apache

# Copiar os arquivos PHP para o diretório do servidor web
COPY ./app /var/www/html

# Instalar as extensões PDO e PDO_MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Atualizar pacotes e instalar o Nano
RUN apt-get update && apt-get install -y nano

# Instalar as dependências para a extensão GD
RUN apt-get update && \
    apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

# Copiar php.ini-development para o php.ini padrão (sem criar link simbólico)
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

# Ativar a extensão pdo_mysql no php.ini
RUN sed -i 's/;extension=pdo_mysql/extension=pdo_mysql/' /usr/local/etc/php/php.ini

# Expor a porta 80 para acesso ao Apache
EXPOSE 80
