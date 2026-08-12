# Routes Audit

## Overview
- `routes/web.php` is very large (700+ lines).
- Contains SaaS administrative routes (Plans, Settings).
- Contains Store Owner routes (Products, Orders, Dashboard).
- Contains Storefront routes (resolution by `{slug}`).
- Extensive payment gateway callback routes.

## Groups
- `auth`: Basic login/registration.
- `verified`: Dashboard, resource management.
- `SetLocale`, `DomainCheck`: Middleware for storefront resolution.
