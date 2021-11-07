# plan-coding-challenge
**Tic-Tac-Toe game**

## Test specification
[Tic-Tac-Toe game specification](/docs/test-specification.md)

**Technologies, libraries and patterns used for this project:**
- [Docker v20.10.8](https://docs.docker.com/get-docker/)
- [Composer v2.1.6](https://getcomposer.org/download/)
- [PHP v8.0](https://www.php.net/releases/8.0/en.php)
- [Laravel 8x](https://laravel.com/docs/8.x)
- [MySQL v8.0](https://dev.mysql.com/doc/relnotes/mysql/8.0/en/)
- [TDD (Unit and Feature test)](https://phpunit.readthedocs.io/en/9.5/)

## Environment

First you will need to set up the environment

Go to the **project folder** and run:

```shell
make local/setup
```

Then, you need to install the application dependencies:

**Warning: Make sure you have PHP 8 installed on your machine**

```shell
make local/install
```

## Testing

To test the application go to the **project folder** and run:

```shell
make local/test
```

When the tests end, the coverage folder will be created into [/tests/Reports/coverage](/tests/Reports/coverage)

## PHP Standards Recommendations

To validate the code for consistency with a coding standard (PSR-1 && PSR-12), go to the **project folder** and run:

```shell
make local/coding-style
```

## Localhost

To see the project running access the link bellow:

[http://localhost:8086/](http://localhost:8086/)
