# Use a imagem oficial do PHP 8.2 com FPM (FastCGI Process Manager)
FROM php:8.2-fpm

# Instale extensões PHP necessárias (substitua pelas extensões específicas da sua aplicação)
RUN docker-php-ext-install pdo_mysql

# Instale o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copie os arquivos da sua aplicação para o diretório /var/www/html
COPY ./src /var/www/html

# Configure as permissões (opcional, dependendo das necessidades)
RUN chown -R www-data:www-data /var/www/html

# Defina o diretório de trabalho
WORKDIR /var/www/html

# Exponha a porta 9000 (a porta padrão do PHP FPM)
EXPOSE 9000

# O contêiner executará automaticamente o PHP FPM quando for iniciado
CMD ["php-fpm"]