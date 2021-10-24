local/setup:
	./bin/check_dependencies
	composer install
	./vendor/bin/sail up -d

local/install:
	./vendor/bin/sail php artisan key:generate
	./vendor/bin/sail php artisan migrate
	./vendor/bin/sail php artisan db:seed

local/test:
	./vendor/bin/sail test
