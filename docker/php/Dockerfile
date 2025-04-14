# ./docker/php/Dockerfile

# Adaptez la version de PHP selon les besoins de votre projet Symfony
ARG PHP_VERSION=8.2
FROM php:${PHP_VERSION}-fpm-alpine

# Arguments (peuvent être utiles)
ARG USER_ID=1000
ARG GROUP_ID=1000

# Définir le répertoire de travail
WORKDIR /var/www/html

# Installation des dépendances système et extensions PHP courantes pour Symfony
# Vous pouvez ajouter/supprimer des extensions selon vos besoins
RUN apk update && apk add --no-cache \
    bash \
    git \
    icu-dev \
    libzip-dev \
    libpng-dev \
    jpeg-dev \
    freetype-dev \
    # Pour pdo_mysql
    mysql-client \
    # Pour gd
    libjpeg-turbo-dev \
    libpng-dev \
    freetype-dev \
    # Dépendances de build (seront supprimées plus tard si nécessaire)
    $PHPIZE_DEPS

# Installation des extensions PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    gd \
    intl \
    pdo pdo_mysql \
    zip \
    opcache

# Installation de Composer (gestionnaire de dépendances PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Optionnel: Installation de Symfony CLI (utile pour les commandes console)
RUN wget https://get.symfony.com/cli/installer -O - | bash && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Optionnel: Installation de Xdebug pour le débogage (très utile en dev !)
# RUN pecl install xdebug && docker-php-ext-enable xdebug
# Vous devrez configurer Xdebug via un fichier .ini (ex: /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini)
# Exemple de configuration xdebug.ini :
# [xdebug]
# xdebug.mode=debug
# xdebug.start_with_request=yes
# xdebug.discover_client_host=1 # Ou xdebug.client_host=host.docker.internal

# Nettoyage (optionnel)
# RUN apk del $PHPIZE_DEPS

# Créer l'utilisateur www-data si nécessaire (si vous voulez éviter de tourner en root)
# RUN addgroup -g ${GROUP_ID} www-data && \
#     adduser -D -u ${USER_ID} -G www-data -s /bin/sh www-data
# USER www-data

# Par défaut, tourne en root pour simplifier la gestion des permissions en dev
# Assurez-vous que les permissions des dossiers cache/logs sont correctes si besoin

CMD ["php-fpm"]

EXPOSE 9000