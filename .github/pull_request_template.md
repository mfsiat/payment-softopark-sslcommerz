## Summary

<!-- What changed and why? Keep it short. -->

## Related issue

<!-- e.g. Fixes #12, or a GitLab issue URL (GitHub Issues are disabled on this repo) -->

## Changes

<!-- Bullet the important changes, not every file. -->

-
-

## How tested

<!-- Commands run, sandbox flow exercised, evidence/screenshots. -->

- [ ] `./vendor/bin/phpunit`
- [ ] Manual SSLCommerz sandbox flow (if payment-related)
- [ ] Verified `orders` status/amount after callback

## Risk and rollback

<!-- What could break? How do we revert safely? -->

## Checklist

- [ ] Branch is based on latest `master`, named `<type>/<issue>-<slug>`
- [ ] No secrets, `.env`, `vendor/`, or debug statements committed
- [ ] Client input validated server-side (amounts, plan, callbacks)
- [ ] No unrelated refactors or formatting changes
- [ ] Commit messages follow Conventional Commits and reference the issue
- [ ] CI is green and at least one reviewer approved
