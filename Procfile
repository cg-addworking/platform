web: vendor/bin/heroku-php-apache2 -i php.ini public/
worker: php artisan queue:work --tries=3
worker_sqs: php artisan queue:work sqs_for_contracts --tries=3
scheduler: php artisan schedule:laravel
