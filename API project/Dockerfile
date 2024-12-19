# Utiliser l'image officielle de PHP 8.2
FROM php:8.2-cli

# Installer les dépendances requises pour Symfony et PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev git unzip

# Activer les extensions PDO et PDO_PGSQL
RUN docker-php-ext-install pdo pdo_pgsql

# Installer Composer (gestionnaire de dépendances PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copier les fichiers de votre application dans le conteneur
COPY code-source/ /var/www/html/

# Configurer le répertoire de travail
WORKDIR /var/www/html

# Installer les dépendances de Symfony
RUN composer install

# Définir les permissions sur le dossier de travail
RUN chown -R www-data:www-data /var/www/html

# Exposer le port 5000 pour le serveur PHP intégré
EXPOSE 5000

# Lancer le serveur PHP intégré à Symfony
CMD ["php", "-S", "0.0.0.0:5000", "-t", "public"]
