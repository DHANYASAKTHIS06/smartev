FROM php:8.2-apache

# Install required system dependencies and curl
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    unzip \
    git \
    && docker-php-ext-install curl \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite for REST routing
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Apache directory configuration
RUN echo '<Directory /var/www/html>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' >> /etc/apache2/apache2.conf

# Setup startup script to bind Apache to Render dynamic $PORT
RUN echo '#!/bin/bash\n\
PORT="${PORT:-8080}"\n\
sed -i "s/Listen 80/Listen ${PORT}/" /etc/apache2/ports.conf\n\
sed -i "s/:80/:${PORT}/" /etc/apache2/sites-available/000-default.conf\n\
exec apache2-foreground' > /usr/local/bin/start-app.sh && chmod +x /usr/local/bin/start-app.sh

EXPOSE 8080

CMD ["/usr/local/bin/start-app.sh"]
