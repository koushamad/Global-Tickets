#!/bin/bash

composer clearcache
composer selfupdate
composer install
npm install
npm run build
php artisan key:generate

