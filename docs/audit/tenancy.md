# Tenancy Audit

## Tenant Resolution
Tenancy in StoreGo is primarily resolved via URL (subdomain or custom domain) or via session/URL slugs.
- Routes often include `{slug?}` to identify the store context.
- `CustomDomainRequest` and `Store` models store the domain/subdomain information.
- Middleware like `DomainCheck` and code in `routes/web.php` resolve the incoming host to a specific store.
- The `Store` model has `enable_domain`, `enable_subdomain`, and `domains` fields.

## Data Isolation
- Queries are typically scoped manually in controllers using `where('store_id', ...)` or `where('created_by', ...)`.
- Users are linked to stores via the `user_stores` pivot table or by `created_by`.
