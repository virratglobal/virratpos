# Architecture Audit

## Overview
StoreGo SaaS is built on Laravel 11.x, PHP 8.2+, with a frontend utilizing Laravel Mix, Tailwind CSS (v3.0.18), and Alpine.js. It features a multi-tenant architecture where each `Store` acts as a tenant.

## Components
- **Controllers**: Large, monolithic controllers (e.g., `StoreController`, `ProductController`, `PaymentController`) handling complex business logic.
- **Models**: Standard Eloquent models like `User`, `Store`, `Product`, `Order`.
- **Tenancy**: Handled via custom middleware (`DomainCheck`, etc.) and database relations linking `User` -> `Store` and querying based on subdomain/custom domain.
- **Modules**: Includes a `LandingPage` module utilizing `nwidart/laravel-modules`.
