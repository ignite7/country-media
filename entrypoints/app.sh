#!/bin/bash

set -o errexit
set -o nounset

# Install packages
composer install --quiet --no-progress --no-interaction

# Migrate
php artisan migrate:refresh

# Flush
sh entrypoints/flush.sh

# Link storage
php artisan storage:link

# Run
php-fpm
