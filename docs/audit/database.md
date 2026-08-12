# Database Audit

## Core Tables
- `users`: Stores all system users (Super Admin, Store Owners, Staff, Customers).
- `stores`: Stores the tenant details, including domains, themes, and settings.
- `products`, `product_categories`, `product_variants`: Product catalog.
- `orders`, `purchased_products`: Order management.
- `plans`, `subscriptions`, `plan_orders`: SaaS billing and plans.

## Relationships
- A `User` can own multiple `Stores` (managed via `created_by` or `user_stores`).
- `Products`, `Orders`, `Customers` belong to a specific store context.
