# Project instructions

## What this project is

Laravel 8 + PHP 7.3 sandbox/demo integration of the **SSLCommerz** payment gateway
for Softopark. Customers pay for two courses (UI/UX and Python) through hosted
checkout, and orders are stored in the `orders` table.

- Payment controller: `app/Http/Controllers/SslCommerzPaymentController.php`
- Gateway library: `app/Library/SslCommerz/` (`SslCommerzNotification`,
  `AbstractSslCommerz`)
- Config: `config/sslcommerz.php` (sandbox by default; credentials from `.env`)
- Routes: `routes/web.php`
- Views: `resources/views/` (`uiux-course`, `python-course`, `dashboard`)
- Migration: `database/migrations/2021_01_29_110113_create_orders_table.php`

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
5. Test: `./vendor/bin/phpunit`; for payment changes also exercise the
   SSLCommerz **sandbox** flow end to end.
6. Commit with Conventional Commits, imperative summary ≤ 72 chars, and an issue
   reference, e.g.
   `fix(payments): derive course amount from plan_id server-side` with
   `Fixes #12` in the footer.
7. Push the branch and open a PR against `master`:
   `gh pr create --base master --fill` (or the compare URL GitHub prints).
8. Address review, rebase on `master`, squash-merge, then delete the branch.

## Guardrails

- Never commit `.env`, store credentials (`STORE_ID`, `STORE_PASSWORD`), keys,
  or `vendor/`.
- Never trust client input. Resolve prices from `plan_id` server-side; the hidden
  `amount` form field must not be authoritative.
- Keep TLS verification enabled when `IS_LOCALHOST=false`; never ship
  `CURLOPT_SSL_VERIFYPEER = false` to production.
- Keep the CSRF exclusions for `/pay-via-ajax`, `/success`, `/fail`, `/cancel`,
  `/ipn` in `app/Http/Middleware/VerifyCsrfToken.php`.
- Remove debug leftovers (`dd()`, `print_r()`, `var_dump()`, raw `echo`) before
  committing.
- Pass `ipn_url` into the payment payload; do not rely on merchant-panel config.
- Null-check the order lookup in `success`/`fail`/`cancel`/`ipn` before reading
  `status`.
- Do not edit already-applied migrations; add a new one.

## Known issues backlog (as analysed)

Critical: client-controlled payment amount; IPN URL not passed to the gateway;
TLS verification defaults to disabled when `IS_LOCALHOST` is unset.

Functional: null dereference on unknown `tran_id`; `dd()` in `success`/`fail`;
`payViaAjax` prints instead of returning JSON; dead live/sandbox branch in
`formatResponse`; wrong `date('Y-d-m')` format; `physical-goods` profile for
digital courses.

UI/docs: nested `<form>` and inconsistent prices in `uiux-course.blade.php`;
empty `success.blade.php`; stale README/composer description; old dependencies
(Laravel 8, PHP 7.3, axios 0.19).
