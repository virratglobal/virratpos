# Roles and Permissions Audit

## Roles
Based on the `User` model, the primary roles are:
- `Super Admin`: Manages the SaaS, plans, and global settings.
- `Owner`: The store owner, who manages their specific store(s).
- `Staff/Employees`: Users assigned to a store with specific permissions.
- `Customer`: Purchasers on the storefront.

## Authorization
- Uses `spatie/laravel-permission`.
- The `User` model uses the `HasRoles` trait.
- Store owners have `type = 'Owner'` and use `creatorId()` to manage isolation.
- `is_active` controls global access.
