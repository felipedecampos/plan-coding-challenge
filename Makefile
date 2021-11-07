local/setup:
	./bin/check_dependencies
	./vendor/bin/sail composer install
	./vendor/bin/sail up -d
	./vendor/bin/sail npm run dev

local/install:
	./vendor/bin/sail php artisan key:generate
	./vendor/bin/sail php artisan migrate

local/coding-style:
	./vendor/bin/phpcs --standard=PSR1 --extensions=php --ignore=*/database/*,*/resources/*,*/storage/*,*/vendor/*,*/public/index.php,*/tests/bootstrap.php,*/bootstrap/cache/* .
	./vendor/bin/phpcs --standard=PSR12 --extensions=php --ignore=*/database/*,*/resources/*,*/storage/*,*/vendor/*,*/public/index.php,*/tests/bootstrap.php,*/bootstrap/cache/* .

local/coding-style-fix:
	./vendor/bin/phpcbf --standard=PSR1 --extensions=php --ignore=*/database/*,*/resources/*,*/storage/*,*/vendor/*,*/public/index.php,*/tests/bootstrap.php,*/bootstrap/cache/* .
	./vendor/bin/phpcbf --standard=PSR12 --extensions=php --ignore=*/database/*,*/resources/*,*/storage/*,*/vendor/*,*/public/index.php,*/tests/bootstrap.php,*/bootstrap/cache/* .

local/test:
	./vendor/bin/sail test
