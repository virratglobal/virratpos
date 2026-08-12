# VirratPOS — Team Setup & Git Workflow

This project is a UI/UX remaster of the StoreGo SaaS (Laravel/PHP/MySQL). We are
staying on this stack — no framework changes. This doc covers how to get the
project running locally and how we collaborate on GitHub without overwriting
each other's work.

Repo: `github.com/virratglobal/virratpos` (private)

---

## 1. First-Time Local Setup

Requirements: XAMPP (PHP + MySQL), Composer, Node.js/npm, Git.

```bash
git clone https://github.com/virratglobal/virratpos.git
cd virratpos

composer install
cp .env.example .env
php artisan key:generate
```

Open `.env` and fill in your **own local** database credentials (DB name, user,
password) matching your XAMPP MySQL setup. Do not copy another teammate's `.env`.

```bash
php artisan migrate
php artisan db:seed   # if seeders are set up, for demo/test data
npm install
npm run dev
```

Start Apache + MySQL in XAMPP, then confirm the app loads at your local URL
(e.g. `http://localhost/virratpos/public`).

---

## 2. GitHub Access

You'll be added as a Collaborator on the repo. GitHub no longer accepts
passwords for Git operations, so:

1. Go to GitHub → Settings → Developer Settings → Personal Access Tokens
2. Generate a token (fine-grained, scoped to this repo if possible)
3. Use this token in place of a password when Git asks for authentication

Keep your token private — don't share it or commit it anywhere.

---

## 3. Branching Rules

- `main` — always stable. Never push directly here.
- `dev` — integration branch. Never push directly here either.
- `feature/<page-name>-ui` — your working branch for a specific page/module.

Before starting any new task:

```bash
git checkout dev
git pull
git checkout -b feature/<page-name>-ui
```

Example branch names: `feature/pos-screen-ui`, `feature/staff-management-ui`,
`feature/customer-dashboard-ui`

**One branch = one page/module.** Don't mix multiple unrelated pages into a
single branch — it makes review and conflict resolution much harder.

---

## 4. Committing & Pushing

Commit in small, logical chunks — not one giant commit at the end of the day.

```bash
git add .
git commit -m "Short, clear description of the change"
git push origin feature/<page-name>-ui
```

---

## 5. Pull Requests

1. Go to the repo on GitHub — you'll see a prompt to open a Pull Request for
   your recently pushed branch.
2. Open the PR **against `dev`** (not `main`).
3. Tag a reviewer. Don't merge your own PR without a review.
4. Once approved, merge into `dev` and delete the feature branch.
5. Periodically, once a batch of pages is stable and tested, `dev` gets
   merged into `main`.

---

## 6. Shared UI Components

Before redesigning individual pages, shared Blade components (buttons, cards,
tables, modals, form inputs) should be built and merged into `dev` first, so
everyone works from the same design system. If you think something you're
building should be a shared component, check before duplicating it in your
own page.

---

## 7. Daily Habit

Always pull the latest `dev` before starting new work:

```bash
git checkout dev
git pull
```

This avoids working on outdated code and reduces merge conflicts later.

---

## Quick Reference

| Action                        | Command                                         |
|--------------------------------|--------------------------------------------------|
| Start new task                | `git checkout dev && git pull && git checkout -b feature/xyz` |
| Save progress                 | `git add . && git commit -m "message"`          |
| Push branch                   | `git push origin feature/xyz`                   |
| Update local DB schema        | `php artisan migrate`                           |
| Rebuild frontend assets       | `npm run dev`                                   |

Questions or unsure about something before pushing — ask first. Better to
check than to break `dev` for everyone else.
