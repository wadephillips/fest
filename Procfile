web: vendor/bin/heroku-php-nginx -C nginx.conf public/ & php artisan queue:work redis --tries=3 & wait -n
