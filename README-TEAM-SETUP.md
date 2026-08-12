# VirratPOS — Team Setup Guide

> **VirratPOS** is a Laravel 11 / MySQL / Blade SaaS point-of-sale application.
> This guide gets a new teammate running locally on XAMPP in under 15 minutes.

---

## Prerequisites

Install these before cloning:

| Tool | Version | Where to get it |
|------|---------|-----------------|
| XAMPP | ≥ 8.2.x | [apachefriends.org](https://www.apachefriends.org/) |
| PHP | ≥ 8.2 | Bundled with XAMPP |
| MySQL | ≥ 8.0 | Bundled with XAMPP |
| Composer | ≥ 2.x | [getcomposer.org](https://getcomposer.org/) |
| Node.js | ≥ 18 LTS | [nodejs.org](https://nodejs.org/) |
| Git | ≥ 2.40 | [git-scm.com](https://git-scm.com/) |

---

## Step 1 — Clone the Repository

```bash
# Clone into your XAMPP htdocs folder
cd C:/xampp/htdocs
git clone https://github.com/virratglobal/virratpos.git virratpos
cd virratpos
```

---

## Step 2 — Install PHP Dependencies

```bash
composer install
```

> ⚠️ If you see a PHP extension error (e.g. `ext-gd`), enable it in `C:/xampp/php/php.ini` by uncommenting the relevant `extension=gd` line, then restart XAMPP.

---

## Step 3 — Set Up Your Environment File

```bash
# Copy the example env (never commit the real .env)
copy .env.example .env
```

Open `.env` in your editor and fill in **at minimum**:

```env
APP_URL=http://localhost/virratpos
DB_DATABASE=virrat_pos
DB_USERNAME=root
DB_PASSWORD=          # leave blank for default XAMPP
```

All other keys (payment gateways, social login) can stay blank for local UI development — they're only needed when testing payment or auth flows.

---

## Step 4 — Generate Application Key

```bash
php artisan key:generate
```

This fills `APP_KEY` in your `.env`. Every teammate gets their own unique key locally.

---

## Step 5 — Create the Database

Open **phpMyAdmin** at `http://localhost/phpmyadmin` and create a new database:

```sql
CREATE DATABASE virrat_pos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Or run it via the MySQL CLI:

```bash
# In XAMPP Shell / Windows Terminal (MySQL must be running)
"C:/xampp/mysql/bin/mysql.exe" -u root -e "CREATE DATABASE virrat_pos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

---

## Step 6 — Run Migrations

```bash
php artisan migrate
```

This creates all 53 tables from scratch. If you see errors, double-check your `DB_*` values in `.env`.

> **Fresh start at any time**: `php artisan migrate:fresh` drops and rebuilds everything (local only — never run on a shared/production DB).

---

## Step 7 — Seed the Database

```bash
# Seeds admin user, plans, AI templates, and LandingPage module data
php artisan db:seed
```

**With demo product/order data** (recommended for UI development):

```bash
# PowerShell
$env:SEED_DEMO_DATA="true"; php artisan db:seed --class=DemoDataSeeder

# Git Bash / WSL
SEED_DEMO_DATA=true php artisan db:seed --class=DemoDataSeeder
```

This creates:
- Demo admin login: **`demo@virratpos.test`** / **`password`**
- 1 demo store with 3 categories, 5 products, 5 orders

---

## Step 8 — Install Frontend Dependencies & Build Assets

```bash
npm install
npm run dev
```

`npm run dev` starts the Vite dev server (hot module replacement). Keep this terminal open while you work.

For a one-time build (no live reload):

```bash
npm run build
```

---

## Step 9 — Configure XAMPP Apache

The application's `public/` folder must be the web root. The easiest option is a virtual host.

### Option A — Virtual Host (Recommended)

1. Open `C:/xampp/apache/conf/extra/httpd-vhosts.conf`
2. Add at the bottom:

```apache
<VirtualHost *:80>
    ServerName virratpos.test
    DocumentRoot "C:/xampp/htdocs/virratpos/public"
    <Directory "C:/xampp/htdocs/virratpos/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

3. Edit `C:/Windows/System32/drivers/etc/hosts` (run Notepad as Admin):

```
127.0.0.1    virratpos.test
```

4. Restart Apache in XAMPP Control Panel.
5. Update `.env`: `APP_URL=http://virratpos.test`
6. Visit: **http://virratpos.test**

### Option B — Subfolder (Quick & Dirty)

The project's root `index.php` and `.htaccess` handle subfolder routing automatically.

1. Update `.env`: `APP_URL=http://localhost/virratpos`
2. Visit: **http://localhost/virratpos**

---

## Step 10 — Verify the Setup

Open your browser and check:

- **Home / Dashboard**: `http://virratpos.test` or `http://localhost/virratpos`
- **Admin Login**: navigate to `/login` and sign in with the seeded admin credentials (see `UsersTableSeeder` for the default admin email/password, or use the demo credentials above)
- **No red error pages** — if you see a 500 error, run `php artisan config:clear && php artisan cache:clear`

---

## Daily Development Workflow

### Starting a new feature branch

Always branch off `dev` (not `main`):

```bash
# Make sure you're on dev and up to date
git checkout dev
git pull origin dev

# Create your feature branch — use the naming convention:
# feature/<page-name>-ui      for UI redesigns
# feature/<feature-name>      for new features
# fix/<description>           for bug fixes
git checkout -b feature/dashboard-ui

# Work, commit often
git add .
git commit -m "feat(dashboard): redesign stat cards using <x-ui::stat-card>"

# Push and open a PR into dev
git push -u origin feature/dashboard-ui
```

### Branch convention summary

| Branch | Purpose | Merges into |
|--------|---------|-------------|
| `main` | Stable, production-ready | — |
| `dev` | Integration branch, all features merge here | `main` |
| `feature/<page>-ui` | UI redesign for a specific page | `dev` |
| `feature/<name>` | New feature | `dev` |
| `fix/<description>` | Bug fix | `dev` |
| `hotfix/<description>` | Urgent production fix | `main` + `dev` |

### Useful artisan commands

```bash
php artisan config:clear      # Clear config cache (run after editing .env)
php artisan cache:clear       # Clear application cache
php artisan view:clear        # Clear compiled Blade templates
php artisan route:list        # List all registered routes
php artisan migrate:status    # Check which migrations have run
php artisan tinker            # Interactive REPL for testing models/queries
```

---

## Using Blade UI Components

The project uses shared Blade components under `resources/views/components/ui/`. Always use these instead of writing raw HTML — it keeps the design consistent and reduces merge conflicts.

```blade
{{-- Page header with title, breadcrumb, and action button --}}
<x-ui.page-header title="Products">
    <x-slot name="breadcrumbs">
        <a href="{{ route('home') }}">Home</a> / Products
    </x-slot>
    <x-slot name="actions">
        <x-ui.button variant="primary" href="{{ route('product.create') }}">
            + Add Product
        </x-ui.button>
    </x-slot>
</x-ui.page-header>

{{-- Data table with head/body/pagination slots --}}
<x-ui.table>
    <x-slot name="head">
        <th>Name</th><th>Price</th><th>Status</th>
    </x-slot>
    <x-slot name="body">
        @foreach($products as $product)
            <tr>...</tr>
        @endforeach
    </x-slot>
    <x-slot name="pagination">{{ $products->links() }}</x-slot>
</x-ui.table>

{{-- Badge --}}
<x-ui.badge variant="success">Active</x-ui.badge>

{{-- Empty state --}}
<x-ui.empty-state message="No products yet." />
```

---

## Troubleshooting

| Problem | Fix |
|---------|-----|
| `Class not found` errors | `composer dump-autoload` |
| Blank page / 500 error | Check `storage/logs/laravel.log` |
| Assets not loading | Run `npm run dev` or `npm run build` |
| Session / cache errors | `php artisan cache:clear && php artisan view:clear` |
| DB connection refused | Ensure MySQL is running in XAMPP Control Panel |
| Permission errors on Linux/Mac | `chmod -R 775 storage bootstrap/cache` |
| `.env` not loading | Delete `bootstrap/cache/config.php`, then `php artisan config:clear` |

---

## Team Contacts

> Update this section with real contact info / Slack channels.

| Role | Contact |
|------|---------|
| Project Lead | — |
| Backend | — |
| Frontend / UI | — |
| DevOps | — |

---

*Last updated: 2026-08-12 by Antigravity (initial setup)*
