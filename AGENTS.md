# Project instructions

## What this project is

Laravel 13 + PHP 8.5 sandbox/demo integration of the **SSLCommerz** payment
gateway for Softopark. Customers pay for two courses (UI/UX and Python) through
hosted checkout, and orders are stored in the `orders` table.

- Framework: Laravel **13.x** (`laravel/framework: ^13.0`), PHP **`^8.5`**
- Payment controller: `app/Http/Controllers/SslCommerzPaymentController.php`
- Gateway library: `app/Library/SslCommerz/` (`SslCommerzNotification`,
  `AbstractSslCommerz`)
- Config: `config/sslcommerz.php` (sandbox by default; credentials from `.env`)
- Routes: `routes/web.php`
- Views: `resources/views/` (`uiux-course`, `python-course`, `dashboard`)
- Migration: `database/migrations/2021_01_29_110113_create_orders_table.php`
- Bootstrap: `bootstrap/app.php` (routing, middleware, exceptions) and
  `bootstrap/providers.php`. This uses the Laravel 11+ slim skeleton — there is
  no `app/Http/Kernel.php`, `app/Console/Kernel.php`, or
  `app/Exceptions/Handler.php`.
- Dev tooling: PHPUnit 12, Pint, Collision, `fakerphp/faker`, Sentry 4.

Remotes:

- `origin` — GitHub `mfsiat/payment-softopark-sslcommerz` (open PRs here)
- `gitlab-ssl-com` — GitLab `mfsiat/payment-demo-sslcommerz` (CI runs here)

## Issue-fixing workflow (mandatory)

Full guide: `docs/FIXING_ISSUES.md`. PR template: `.github/pull_request_template.md`.

1. **Never commit directly to `master`.** One issue = one branch = one PR.
2. Sync first: `git switch master && git pull origin master`.
3. Create a branch named `<type>/<issue>-<slug>`, e.g.
   `fix/12-validate-course-amount` (types: `fix`, `feat`, `chore`, `docs`,
   `refactor`).
4. Make a focused change; do not mix unrelated refactors or reformatting.
5. Test: `./vendor/bin/phpunit` and `./vendor/bin/pint --test`; for payment
   changes also exercise the SSLCommerz **sandbox** flow end to end.
6. Commit with Conventional Commits, imperative summary ≤ 72 chars, and an issue
   reference, e.g.
   `fix(payments): derive course amount from plan_id server-side` with
   `Fixes #12` in the footer.
7. Push the branch and open a PR against `master`:
   `gh pr create --base master --fill` (or the compare URL GitHub prints).
8. Address review, rebase on `master`, squash-merge, then delete the branch.

## Running PHP 8.5

The project requires PHP 8.5, which may not be installed on the host. Use the
official Docker images for installs/tests when the host PHP is older:

```bash
docker run --rm --user "$(id -u):$(id -g)" -e COMPOSER_HOME=/tmp/composer \
  -v "$PWD":/app -w /app composer:2 composer install
docker run --rm --user "$(id -u):$(id -g)" -e COMPOSER_HOME=/tmp/composer \
  -v "$PWD":/app -w /app composer:2 ./vendor/bin/phpunit
```

The GitLab CI pipeline uses the `php:8.5-cli` image.

## Guardrails

- Never commit `.env`, store credentials (`STORE_ID`, `STORE_PASSWORD`), keys,
  or `vendor/`.
- Never trust client input. Resolve prices from `plan_id` server-side; the hidden
  `amount` form field must not be authoritative.
- Keep TLS verification enabled when `IS_LOCALHOST=false`; never ship
  `CURLOPT_SSL_VERIFYPEER = false` to production.
- CSRF exclusions for `pay-via-ajax`, `success`, `fail`, `cancel`, `ipn` live in
  `bootstrap/app.php` via `$middleware->validateCsrfTokens(except: [...])`.
- Remove debug leftovers (`dd()`, `print_r()`, `var_dump()`, raw `echo`) before
  committing.
- Pass `ipn_url` into the payment payload; do not rely on merchant-panel config.
- Null-check the order lookup in `success`/`fail`/`cancel`/`ipn` before reading
  `status`.
- Do not edit already-applied migrations; add a new one.
- Frontend tooling is still Laravel Mix 5 and no compiled assets are used by the
  views; do not introduce built assets without migrating to Vite first.

## Known issues backlog (as analysed)

Critical: client-controlled payment amount; IPN URL not passed to the gateway;
TLS verification defaults to disabled when `IS_LOCALHOST` is unset.

Functional: null dereference on unknown `tran_id`; `dd()` in `success`/`fail`;
`payViaAjax` prints instead of returning JSON; dead live/sandbox branch in
`formatResponse`; wrong `date('Y-d-m')` format; `physical-goods` profile for
digital courses.

UI/docs: nested `<form>` and inconsistent prices in `uiux-course.blade.php`;
empty `success.blade.php`; frontend dependencies still on Laravel Mix 5.

Resolved: PHP 8.5 / Laravel 13 upgrade, dependency refresh, PR workflow docs and
the PR template.
