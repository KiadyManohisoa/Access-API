
# Utilisation de l'image officielle PHP CLI
FROM php:8.2-cli

# Installer uniquement les dépendances nécessaires pour PostgreSQL et Composer
RUN apt-get update && apt-get install -y git libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN docker-php-ext-install pdo_pgsql 

# Définir le dossier de travail
WORKDIR /var/www/access

# Copier le code du projet dans le conteneur
COPY ./access/code /var/www/access

RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader


# Installer Composer (gestionnaire de dépendances PHP)

# Exposer le port 8000 pour HTTP (serveur PHP intégré)
EXPOSE 8000
