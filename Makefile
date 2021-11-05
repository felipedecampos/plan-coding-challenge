local/setup:
	./bin/check_dependencies
	./vendor/bin/sail composer install
	./vendor/bin/sail up -d
	./vendor/bin/sail npm run dev

local/install:
	./vendor/bin/sail php artisan key:generate
	./vendor/bin/sail php artisan migrate

local/test:
	./vendor/bin/sail test
