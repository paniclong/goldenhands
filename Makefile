post-build:
	chmod 777 -R storage/

	composer install
	chown 1000:1000 -R vendor/

	php artisan key:generate
