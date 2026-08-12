# Technical Debt Audit

## Current Observations
- **Fat Controllers**: Controllers like `StoreController` (211KB), `PaymentController` (155KB), and `ProductController` (87KB) contain significant business logic.
- **Routing**: `web.php` is heavily congested. Routes could be modularized or split by tenant vs. admin.
- **UI Code Duplication**: Standard Blade templates likely have repeated CSS classes rather than reusable components.
- **Payment Logic**: Hardcoded inside individual controllers rather than utilizing abstract service patterns.

## Impact on Remaster
- We must not refactor controllers right now; UI updates must work with the current inputs and outputs of these controllers.
