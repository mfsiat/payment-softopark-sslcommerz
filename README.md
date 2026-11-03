# SSLCOMERZ Payment Sandbox

> sslcomerz laravel demo sandbox

## Requirements

- PHP **8.5+**
- Composer 2
- MySQL (or SQLite for testing)
- Node.js only if you build frontend assets (`npm install && npm run dev`)

Laravel 13 is the framework version. Dependency versions are pinned in
`composer.lock`.

## Usage

- Clone and check the routes ( `web.php` )

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Set the SSLCommerz sandbox credentials in `.env`:

```dotenv
API_DOMAIN_URL=https://sandbox.sslcommerz.com
STORE_ID=
STORE_PASSWORD=
IS_LOCALHOST=true
```

## Tests

```bash
./vendor/bin/phpunit
```

## Contributing

All fixes go through a branch and a Pull Request — never commit directly to `master`.

-   Workflow: [docs/FIXING_ISSUES.md](docs/FIXING_ISSUES.md)
-   PR template: [.github/pull_request_template.md](.github/pull_request_template.md)
