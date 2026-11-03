# Fixing Issues — Contribution Guideline

This document defines the required workflow for fixing bugs, security issues, and
small improvements in this repository (`payment-softopark-sslcommerz`).

The short version:

> **Never commit directly to `master`.** Create a branch per issue, fix it, commit
> with a clear message, push, and open a Pull Request (PR) for review.

---

## 1. Golden rules

1. **One issue = one branch = one PR.** Do not mix unrelated fixes.
2. **`master` is protected.** All work lands through a PR, even one-line fixes.
3. **Never commit secrets.** `.env`, store credentials (`STORE_ID`,
   `STORE_PASSWORD`), SSH keys, and `vendor/` must stay out of Git.
4. **Keep PRs small and reviewable.** Target < 400 changed lines where possible.
5. **Tests and CI must pass** before requesting review.
6. **Do not reformat unrelated code.** It makes review and rollback harder.
7. **Every PR must state how it was tested.** "It works" is not evidence.

---

## 2. Prerequisites (once per machine)

```bash
git config user.name  "Your Name"
git config user.email "you@example.com"

# GitHub CLI for creating PRs
gh auth status || gh auth login
```

Remotes in this repository:

| Remote | Purpose |
| --- | --- |
| `origin` | GitHub — `mfsiat/payment-softopark-sslcommerz` (PRs are opened here) |
| `gitlab-ssl-com` | GitLab — `mfsiat/payment-demo-sslcommerz` (CI runs here) |

> Note: GitHub Issues are disabled on `origin`. If the issue lives in GitLab,
> reference its URL in the PR description.

---

## 3. Step 1 — Sync `master`

Always start from an up-to-date `master`. Never branch from another feature branch.

```bash
git switch master
git pull origin master
git status   # must be clean before continuing
```

If you have uncommitted work, stash it (`git stash push -m "wip"`) or commit it on
its own branch first.

---

## 4. Step 2 — Create a dedicated branch

Use the naming convention `<type>/<issue-number>-<short-slug>`:

| Type | Use for | Example |
| --- | --- | --- |
| `fix/` | Bug or security fix | `fix/12-validate-course-amount` |
| `feat/` | New functionality | `feat/21-refund-endpoint` |
| `chore/` | Tooling, CI, dependencies | `chore/30-update-phpunit` |
| `docs/` | Documentation only | `docs/31-fixing-issues-guide` |
| `refactor/` | No behaviour change | `refactor/32-extract-payment-service` |

```bash
git switch -c fix/12-validate-course-amount
```

If no issue number exists yet, create one first (GitLab) so the work is traceable.

---

## 5. Step 3 — Implement the fix

- Read the related code before changing it: `routes/web.php`,
  `app/Http/Controllers/SslCommerzPaymentController.php`,
  `app/Library/SslCommerz/*`, `config/sslcommerz.php`.
- Follow existing style (PSR-12, Laravel conventions, 4-space indent). Run
  `./vendor/bin/php-cs-fixer fix --dry-run` if the tool is available.
- **Never trust client input.** Amounts, `plan_id`, customer data, and callback
  parameters must be validated/served from the server side.
- **Never disable TLS verification in production.** `IS_LOCALHOST=false` must
  keep `CURLOPT_SSL_VERIFYPEER` enabled.
- **Do not leave debug code** (`dd()`, `print_r()`, `var_dump()`, raw `echo`) in
  controllers or views.
- For payment callbacks (`/success`, `/fail`, `/cancel`, `/ipn`), keep their CSRF
  exclusions in `app/Http/Middleware/VerifyCsrfToken.php` intact.
- Add or update a migration instead of editing an already-applied one.

While working, keep the branch focused:

```bash
git status
git diff
```

---

## 6. Step 4 — Test before committing

Run the automated suite:

```bash
composer install          # if vendor/ is missing
./vendor/bin/phpunit
```

For payment changes, also test manually against the **sandbox**:

1. Set `API_DOMAIN_URL=https://sandbox.sslcommerz.com` and sandbox credentials.
2. `php artisan serve`
3. Walk the flow: course page → `/pay` → sandbox gateway → `/success`,
   `/fail`, `/cancel`, and simulate `/ipn`.
4. Verify the `orders` row transitions `Pending` → `Processing`/`Failed`
   **and** that the stored amount matches the server-side price, not the form.
5. Confirm no secrets or debug output appear in logs or responses.

Document the commands you ran in the PR description.

---

## 7. Step 5 — Commit with a suitable message

Use [Conventional Commits](https://www.conventionalcommits.org/):

```
<type>(<scope>): <imperative summary>

<optional body: why, what changed, side effects>

<optional footer: Refs #12 / Fixes #12 / BREAKING CHANGE: ...>
```

Examples for this project:

```
fix(payments): derive course amount from plan_id server-side

The amount was taken from a hidden form field, allowing a customer to
pay any value for a course. Resolve the price from an allow-listed plan
map instead and reject unknown plans.

Fixes #12
```

```
fix(ipn): register ipn_url and guard missing orders

- pass ipn_url into makePayment payload
- return 404-style response instead of dereferencing null on unknown tran_id

Refs #14
```

Rules:

- **Summary in imperative mood**, lower-case, ≤ 72 characters, no trailing period.
- One logical change per commit; avoid `update`, `fix`, `wip`, `final`.
- Reference the issue in the footer.
- Do not commit generated files, `.env`, or `vendor/`.

```bash
git add app/Http/Controllers/SslCommerzPaymentController.php
git add tests/Feature/PaymentAmountTest.php
git diff --cached
git commit
```

---

## 8. Step 6 — Push and open a PR

```bash
git push -u origin fix/12-validate-course-amount
```

Create the PR against `master`:

```bash
gh pr create \
  --base master \
  --head fix/12-validate-course-amount \
  --title "fix(payments): derive course amount from plan_id server-side" \
  --body-file .github/pull_request_template.md
```

Or open it in the browser:

```bash
gh pr create --web
```

The PR description must include:

- **What** changed and **why** (link the issue).
- **How** it was tested (commands, sandbox evidence).
- **Risk/rollback** for payment-related changes.
- Screenshots for UI changes.

If the change must also run through GitLab CI:

```bash
git push gitlab-ssl-com fix/12-validate-course-amount
# optionally: glab mr create --source-branch fix/12-validate-course-amount --target-branch master
```

---

## 9. Step 7 — Review, merge, clean up

1. Address review comments with **new commits** (do not force-push during review
   unless asked).
2. Keep the branch up to date:
   ```bash
   git fetch origin
   git rebase origin/master
   git push --force-with-lease
   ```
3. Merge only when CI is green and at least one reviewer approves.
4. Prefer **Squash and merge** so `master` keeps one commit per issue, with the
   PR title as the commit message.
5. Delete the branch and clean up locally:
   ```bash
   git switch master
   git pull origin master
   git branch -d fix/12-validate-course-amount
   ```

---

## 10. Definition of done — PR checklist

Copy this into the PR (also in `.github/pull_request_template.md`):

- [ ] Branch is based on latest `master` and named `<type>/<issue>-<slug>`
- [ ] Change is limited to the issue; no unrelated edits
- [ ] No secrets, `.env`, `vendor/`, or debug statements committed
- [ ] Input validated server-side (amount, plan, callbacks)
- [ ] `./vendor/bin/phpunit` passes
- [ ] Sandbox payment flow re-tested (for payment changes)
- [ ] Commit messages follow Conventional Commits and reference the issue
- [ ] PR description explains what, why, how tested, and rollback
- [ ] CI green and reviewer approved

---

## 11. Worked example — client-controlled amount (issue #12)

```bash
git switch master && git pull origin master
git switch -c fix/12-validate-course-amount

# 1. Add an allow-listed price map / plan lookup used by index()
# 2. Ignore $request->input('amount'); use the server-side price
# 3. Reject unknown plan_id with a 422/redirect
# 4. Add tests: known plan -> correct amount; tampered amount -> server price
./vendor/bin/phpunit

git add app/Http/Controllers/SslCommerzPaymentController.php \
        tests/Feature/PaymentAmountTest.php
git commit -m "fix(payments): derive course amount from plan_id server-side" \
           -m "Prevents clients from paying an arbitrary amount via the hidden form field. Refs #12"
git push -u origin fix/12-validate-course-amount

gh pr create --base master --fill
```

---

## 12. Hotfixes

If a live payment path is broken:

1. Still create a branch: `fix/<issue>-hotfix-<slug>`.
2. Keep the diff minimal and add a regression test.
3. Request an expedited review; do not self-merge.
4. After merge, verify the sandbox/production callback logs and the `orders`
   table before closing the issue.

---

## 13. Branch protection (repository maintainers)

Configure on GitHub (`Settings → Branches → master`):

- Require a pull request before merging (≥ 1 approval).
- Require status checks to pass (GitLab pipeline / tests).
- Require branches to be up to date before merging.
- Disallow force pushes and deletions.
- Restrict direct pushes to `master`.
