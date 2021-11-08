local/install:
	./bin/check_dependencies
	cp .env.example .env
	export WWWGROUP=$${WWWGROUP:-$$(id -g)}; docker-compose up -d
	docker-compose exec laravel.test composer install
	./vendor/bin/sail php artisan key:generate --ansi
	./vendor/bin/sail php artisan migrate
	./vendor/bin/sail npm install
	./vendor/bin/sail npm run dev
	docker-compose restart
	echo "\nServing the application Tic-Tac-Toe on: http://localhost:8086"

local/setup-down:
	docker-compose down --rmi all -v

local/coding-style:
	./vendor/bin/phpcs --standard=PSR1 --extensions=php --ignore=*/database/*,*/resources/*,*/storage/*,*/vendor/*,*/public/index.php,*/tests/bootstrap.php,*/bootstrap/cache/* .
	./vendor/bin/phpcs --standard=PSR12 --extensions=php --ignore=*/database/*,*/resources/*,*/storage/*,*/vendor/*,*/public/index.php,*/tests/bootstrap.php,*/bootstrap/cache/* .

local/coding-style-fix:
	./vendor/bin/phpcbf --standard=PSR1 --extensions=php --ignore=*/database/*,*/resources/*,*/storage/*,*/vendor/*,*/public/index.php,*/tests/bootstrap.php,*/bootstrap/cache/* .
	./vendor/bin/phpcbf --standard=PSR12 --extensions=php --ignore=*/database/*,*/resources/*,*/storage/*,*/vendor/*,*/public/index.php,*/tests/bootstrap.php,*/bootstrap/cache/* .

local/test:
	./vendor/bin/sail test
