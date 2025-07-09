# Use the official PHP image
FROM php:8.4-apache

# Update and upgrade packages
RUN apt-get update && apt-get upgrade

# Install composer necessary
RUN apt-get install -y unzip curl

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache
RUN a2enmod rewrite

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Copy the project code into the container
COPY . /var/www/html

# Create composer autoload
RUN composer dump-autoload

# Expose the Apache port
EXPOSE 80
