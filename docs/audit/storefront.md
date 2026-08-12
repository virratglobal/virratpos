# Storefront Audit

## Architecture
- Custom storefront themes are stored (likely in `resources/views/storefront` or similar).
- `themeController.php` handles theme selection.
- Multi-store routing isolates stores using `DomainCheck` and `SetLocale` middleware.
- Settings are loaded dynamically via `StoreThemeSettings`.

## Customization
- Pages, Sections, and Blocks seem to be managed partially via `PageOption` and settings array.
- Requires further exploration before building the Store Builder in Phase 20.
