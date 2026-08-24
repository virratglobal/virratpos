@php
// get theme color
$setting = App\Models\Utility::colorset();

$settings = Utility::settings();
$color = !empty($setting['color']) ? $setting['color'] : 'theme-3';

if(isset($setting['color_flag']) && $setting['color_flag'] == 'true')
{
    $themeColor = 'custom-color';
    $primaryColor = $color;
}
else {
    $themeColor = $color;
    $themePrimaryColors = [
        'theme-1' => '#0CAF60',
        'theme-2' => '#584ED2',
        'theme-3' => '#6FD943',
        'theme-4' => '#145388',
        'theme-5' => '#B9406B',
        'theme-6' => '#008ECC',
        'theme-7' => '#922C88',
        'theme-8' => '#C0A145',
        'theme-9' => '#48494B',
        'theme-10' => '#0C7785',
    ];
    $primaryColor = isset($themePrimaryColors[$themeColor]) ? $themePrimaryColors[$themeColor] : '#4648d4';
}
$users = \Auth::user();
$currantLang = $users->currentLanguages();
$languages = \App\Models\Utility::languages();
$footer_text = isset($settings['footer_text']) ? $settings['footer_text'] : '';

$profile = \App\Models\Utility::get_file('uploads/profile');
$logo = \App\Models\Utility::get_file('uploads/logo');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{isset($settings['SITE_RTL']) && $settings['SITE_RTL'] == 'on' ? 'rtl' : '' }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @include('partials.admin.head')

    <!-- Google Fonts: Geist + Inter + Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (no preflight to avoid breaking Bootstrap) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            corePlugins: { preflight: false },
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        // Stitch design tokens
                        "sg-primary": "{{ $primaryColor }}",
                        "sg-on-primary": "#ffffff",
                        "sg-surface": "#f8f9ff",
                        "sg-background": "#f8f9ff",
                        "sg-on-surface": "#0b1c30",
                        "sg-on-surface-variant": "#464554",
                        "sg-surface-container": "#e5eeff",
                        "sg-surface-container-low": "#eff4ff",
                        "sg-surface-container-high": "#dce9ff",
                        "sg-surface-container-lowest": "#ffffff",
                        "sg-outline-variant": "#c7c4d7",
                        "sg-outline": "#767586",
                        "sg-error": "#ba1a1a",
                        "sg-tertiary": "#904900",
                        "sg-tertiary-container": "#b55d00",
                        "sg-on-tertiary-container": "#fffbff",
                        "sg-secondary-container": "#dae2fd",
                        "sg-on-secondary-container": "#5c647a",
                        "sg-primary-container": "{{ $primaryColor }}",
                        "sg-on-primary-container": "#fffbff",
                        // Legacy compat
                        primary: { DEFAULT: '{{ $primaryColor }}', light: '{{ $primaryColor }}', dark: '{{ $primaryColor }}' },
                        sidebar: { bg: '#ffffff', text: '#464554', dark: '#f8f9ff', active: '#e5eeff', hover: '#dce9ff' },
                        surface: '#ffffff',
                        background: '#f8f9ff',
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Flash-prevention script -->
    <script>
        (function() {
            var savedTheme = localStorage.getItem('virratpos_theme');
            var serverTheme = "{{ isset($settings['cust_darklayout']) ? $settings['cust_darklayout'] : 'off' }}";
            var isDark = savedTheme === 'dark' || (savedTheme !== 'light' && serverTheme === 'on');
            if (isDark) {
                document.documentElement.setAttribute('data-theme', 'dark');
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.setAttribute('data-theme', 'light');
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <style>
        :root {
            --app-bg: #F8FAFC;
            --surface: #FFFFFF;
            --surface-2: #F8FAFC;
            --surface-elevated: #FFFFFF;
            --surface-dropdown: #FFFFFF;
            --text-primary: #0F172A;
            --text-secondary: #64748B;
            --text-muted: #94A3B8;
            --border: #E2E8F0;
            --border-strong: #CBD5E1;
            --input-bg: #FFFFFF;
            --primary: #2563EB;
            --primary-hover: #1D4ED8;
            --sidebar-bg: #FFFFFF;
            --header-bg: #FFFFFF;
            --metric-bg: #EFF6FF;
        }

        .dark,
        html.dark,
        html[data-theme="dark"],
        body.dark {
            --app-bg: #0B1120;
            --surface: #111827;
            --surface-2: #172033;
            --surface-elevated: #1E293B;
            --surface-dropdown: #1E293B;
            --text-primary: #F8FAFC;
            --text-secondary: #CBD5E1;
            --text-muted: #94A3B8;
            --border: #263449;
            --border-strong: #334155;
            --input-bg: #0F172A;
            --primary: #3B82F6;
            --primary-hover: #60A5FA;
            --sidebar-bg: #0F172A;
            --header-bg: #111827;
            --metric-bg: #111827;
        }

        /* Reset and base */
        html, body {
            font-family: 'Inter', sans-serif !important;
            background-color: var(--app-bg) !important;
            color: var(--text-primary) !important;
            min-height: 100vh !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .sg-main-content,
        .sg-content-body,
        .dash-container,
        .dash-content,
        .dash-footer,
        .footer-wrapper,
        .requests-container,
        .coupons-container,
        .stores-container,
        .landing-container,
        .settings-layout-wrapper {
            background-color: var(--app-bg) !important;
            color: var(--text-primary) !important;
        }

        .dash-footer {
            border-top: 1px solid var(--border) !important;
            padding: 16px 24px !important;
            margin-top: auto !important;
        }

        .dash-footer .text-muted,
        .dash-footer span {
            color: var(--text-secondary) !important;
        }

        /* 2. Sidebar Dark Theme (Surface 1 & 2) */
        html.dark .sg-sidebar {
            background-color: #0F172A !important;
            border-color: #1E293B !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.4) !important;
        }
        html.dark .sg-nav-heading {
            color: #94A3B8 !important;
        }
        html.dark .sg-nav-link,
        html.dark .sg-dropdown-link {
            color: #CBD5E1 !important;
            background-color: transparent !important;
        }
        html.dark .sg-nav-link:hover,
        html.dark .sg-dropdown-link:hover {
            background-color: rgba(59, 130, 246, 0.10) !important;
            color: #60A5FA !important;
        }
        html.dark .sg-nav-link.sg-active,
        html.dark .sg-dropdown-link.sg-active {
            background-color: #2563EB !important;
            color: #FFFFFF !important;
            font-weight: 600 !important;
        }

        /* 3. Header Dark Theme (Surface 2) */
        html.dark .sg-header {
            background-color: #111827 !important;
            border-color: #1E293B !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.3) !important;
        }
        html.dark .sg-header button,
        html.dark .sg-header a {
            color: #CBD5E1 !important;
        }
        html.dark .sg-header button:hover,
        html.dark .sg-header a:hover {
            background-color: #1E293B !important;
            color: #FFFFFF !important;
        }
        html.dark .sg-header button[style*="background: #F8FAFC"],
        html.dark .sg-header button[style*="background:#F8FAFC"],
        html.dark .search-stores-input,
        html.dark .search-codes-input {
            background-color: #0F172A !important;
            border-color: #263449 !important;
            color: #F8FAFC !important;
        }
        html.dark .sg-header button[style*="background: #F8FAFC"] span,
        html.dark .search-icon-inside {
            color: #94A3B8 !important;
        }

        /* 4. Cards & Container Tiles (Surface 2) */
        html.dark .card,
        html.dark .landing-card,
        html.dark .requests-table-card,
        html.dark .coupons-table-card,
        html.dark .stores-table-card,
        html.dark .stat-card-box,
        html.dark .coupon-stat-tile,
        html.dark .store-stat-tile,
        html.dark .requests-hero-card,
        html.dark .inner-soft-tile,
        html.dark .repeater-item-box,
        html.dark .og-image-preview-card,
        html.dark .x-ui-card {
            background-color: #111827 !important;
            border-color: #263449 !important;
            color: #F8FAFC !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25) !important;
        }

        /* Elevated Surfaces (Surface 3 & 4) */
        html.dark .store-stat-tile,
        html.dark .coupon-stat-tile,
        html.dark .stat-card-box,
        html.dark .inner-soft-tile,
        html.dark .repeater-item-box {
            background-color: #172033 !important;
            border-color: #263449 !important;
        }

        /* Attention / Red Tile in Dark Mode */
        html.dark .store-stat-tile-attention {
            background-color: #2A1115 !important;
            border-color: #991B1B !important;
        }

        /* 5. Headings & Typography in Dark Mode */
        html.dark h1, html.dark h2, html.dark h3, html.dark h4, html.dark h5, html.dark h6,
        html.dark .requests-header h1,
        html.dark .requests-hero-card h1,
        html.dark .coupons-header h1,
        html.dark .stores-header h1,
        html.dark .landing-header-title-box h1,
        html.dark .stat-big-number,
        html.dark .coupon-stat-big-number,
        html.dark .store-stat-big-number,
        html.dark .store-name,
        html.dark .store-name-text,
        html.dark .card-header,
        html.dark .modal-title {
            color: #F8FAFC !important;
        }

        html.dark p,
        html.dark .requests-header p,
        html.dark .requests-hero-card p,
        html.dark .coupons-header p,
        html.dark .stores-header p,
        html.dark .landing-header-title-box p,
        html.dark .stat-subtext,
        html.dark .coupon-stat-subtext,
        html.dark .store-stat-subtext,
        html.dark .store-id,
        html.dark .store-id-subtext,
        html.dark .footer-count-text,
        html.dark .field-label,
        html.dark .field-char-count {
            color: #CBD5E1 !important;
        }

        /* 6. Form Controls, Inputs & Textareas (Surface 5) */
        html.dark input.form-control,
        html.dark textarea.form-control,
        html.dark select.form-control,
        html.dark .form-input-white,
        html.dark .form-textarea-white,
        html.dark .search-codes-input,
        html.dark .search-stores-input,
        html.dark .choices__inner {
            background-color: #0F172A !important;
            border-color: #334155 !important;
            color: #F8FAFC !important;
        }

        html.dark input.form-control:focus,
        html.dark textarea.form-control:focus,
        html.dark select.form-control:focus,
        html.dark .form-input-white:focus,
        html.dark .form-textarea-white:focus,
        html.dark .search-codes-input:focus,
        html.dark .search-stores-input:focus {
            background-color: #111827 !important;
            border-color: #3B82F6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
        }

        html.dark ::placeholder {
            color: #64748B !important;
            opacity: 1 !important;
        }

        /* 7. Tables & Headers */
        html.dark .table,
        html.dark .custom-requests-table,
        html.dark .custom-coupons-table,
        html.dark .custom-stores-table {
            background-color: #111827 !important;
            color: #F8FAFC !important;
        }

        html.dark .table th,
        html.dark .custom-requests-table th,
        html.dark .custom-coupons-table th,
        html.dark .custom-stores-table th,
        html.dark .requests-table-header,
        html.dark .coupons-table-header,
        html.dark .stores-table-header,
        html.dark thead {
            background-color: #0F172A !important;
            border-color: #263449 !important;
            color: #94A3B8 !important;
        }

        html.dark .table td,
        html.dark .custom-requests-table td,
        html.dark .custom-coupons-table td,
        html.dark .custom-stores-table td,
        html.dark tbody tr {
            border-color: #1E293B !important;
            color: #CBD5E1 !important;
            background-color: #111827 !important;
        }

        html.dark .table tbody tr:hover,
        html.dark .custom-requests-table tr:hover td,
        html.dark .custom-coupons-table tr:hover td,
        html.dark .custom-stores-table tr:hover td {
            background-color: #172033 !important;
        }

        /* 8. Dropdowns, Modals, Drawers & Popups (Surface 4) */
        html.dark .dropdown-menu,
        html.dark .choices__list--dropdown,
        html.dark .modal-content {
            background-color: #1E293B !important;
            border-color: #334155 !important;
            color: #F8FAFC !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5) !important;
        }

        html.dark .dropdown-item {
            color: #CBD5E1 !important;
        }
        html.dark .dropdown-item:hover {
            background-color: rgba(59, 130, 246, 0.12) !important;
            color: #FFFFFF !important;
        }

        /* 9. Buttons in Dark Mode */
        html.dark .btn-primary,
        html.dark .btn-publish-build,
        html.dark .btn-create-coupon,
        html.dark .btn-create-store,
        html.dark .btn-export-csv {
            background-color: #2563EB !important;
            color: #FFFFFF !important;
            border: none !important;
        }
        html.dark .btn-primary:hover,
        html.dark .btn-publish-build:hover,
        html.dark .btn-create-coupon:hover,
        html.dark .btn-create-store:hover,
        html.dark .btn-export-csv:hover {
            background-color: #1D4ED8 !important;
            color: #FFFFFF !important;
        }

        html.dark .btn-discard-changes,
        html.dark .btn-secondary,
        html.dark .btn-icon-square,
        html.dark .btn-filter-action,
        html.dark .btn-action-icon {
            background-color: #1E293B !important;
            border-color: #334155 !important;
            color: #CBD5E1 !important;
        }
        html.dark .btn-discard-changes:hover,
        html.dark .btn-secondary:hover,
        html.dark .btn-icon-square:hover,
        html.dark .btn-filter-action:hover,
        html.dark .btn-action-icon:hover {
            background-color: #263449 !important;
            color: #FFFFFF !important;
        }

        /* 10. Badges & Pills */
        html.dark .badge-current-plan,
        html.dark .badge-requested-plan,
        html.dark .badge-coupon-active,
        html.dark .badge-store-active,
        html.dark .badge-status-reviewing-pill {
            background-color: rgba(59, 130, 246, 0.15) !important;
            color: #60A5FA !important;
        }

        html.dark .badge-status-pending-pill,
        html.dark .badge-store-limit,
        html.dark .btn-action-delete {
            background-color: rgba(239, 68, 68, 0.15) !important;
            color: #F87171 !important;
        }

        html.dark .badge-enterprise-plan {
            background-color: rgba(245, 158, 11, 0.15) !important;
            color: #FBBF24 !important;
        }

        html.dark .badge-coupon-expired {
            background-color: #1E293B !important;
            color: #94A3B8 !important;
        }

        /* 11. Pagination */
        html.dark .page-pill,
        html.dark .pagination .page-item .page-link {
            background-color: #172033 !important;
            color: #CBD5E1 !important;
            border-color: #263449 !important;
        }
        html.dark .page-pill.active,
        html.dark .pagination .page-item.active .page-link {
            background-color: #2563EB !important;
            color: #FFFFFF !important;
        }

        /* 12. Scrollbars */
        html.dark ::-webkit-scrollbar-track {
            background: #0F172A !important;
        }
        html.dark ::-webkit-scrollbar-thumb {
            background: #334155 !important;
            border-radius: 4px !important;
        }
        html.dark ::-webkit-scrollbar-thumb:hover {
            background: #475569 !important;
        }

        /* 13. Smooth Global Theme Transition */
        html, body, .sg-sidebar, .sg-header, .card, .landing-card, .requests-table-card, .coupons-table-card, .stores-table-card, .stat-card-box, input, select, textarea, .dropdown-menu, .hdr-dropdown {
            transition: background-color 180ms ease, color 180ms ease, border-color 180ms ease, box-shadow 180ms ease !important;
        }

        /* 14. Header Control Buttons & Dropdowns Theme Architecture */
        .hdr-btn {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            background: transparent !important;
            border: none !important;
            cursor: pointer;
            color: #475569 !important;
            transition: all 0.18s ease !important;
        }
        .hdr-btn:hover {
            background-color: #F1F5F9 !important;
            color: #2563EB !important;
        }

        .hdr-dropdown {
            background: #FFFFFF !important;
            border: 1px solid #E2E8F0 !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1) !important;
        }
        .hdr-dropdown-item {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            padding: 8px 12px !important;
            border-radius: 8px !important;
            font-family: Inter, sans-serif !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #475569 !important;
            text-decoration: none !important;
            transition: background-color 0.18s, color 0.18s !important;
        }
        .hdr-dropdown-item:hover {
            background-color: #EFF6FF !important;
            color: #2563EB !important;
        }

        /* Dark Mode Overrides for Header Controls */
        html.dark .hdr-btn {
            color: #CBD5E1 !important;
            background: transparent !important;
        }
        html.dark .hdr-btn:hover {
            background-color: #1E293B !important;
            color: #60A5FA !important;
        }
        html.dark .hdr-dropdown {
            background-color: #1E293B !important;
            border-color: #334155 !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5) !important;
        }
        html.dark .hdr-dropdown-header {
            background-color: #172033 !important;
            border-bottom-color: #263449 !important;
        }
        html.dark .hdr-dropdown-header h4,
        html.dark .hdr-dropdown-header h5 {
            color: #F8FAFC !important;
        }
        html.dark .hdr-dropdown-header p {
            color: #CBD5E1 !important;
        }
        html.dark .hdr-dropdown-item {
            color: #CBD5E1 !important;
        }
        html.dark .hdr-dropdown-item:hover {
            background-color: rgba(59, 130, 246, 0.12) !important;
            color: #FFFFFF !important;
        }

        /* 15. Comprehensive Inline Style Overrides in Dark Mode */
        html.dark [style*="color: #0b1c30"],
        html.dark [style*="color:#0b1c30"],
        html.dark [style*="color: #0F172A"],
        html.dark [style*="color:#0F172A"],
        html.dark [style*="color: #0b1b30"],
        html.dark [style*="color: #1e293b"],
        html.dark [style*="color: #111827"],
        html.dark [style*="color: #000"],
        html.dark [style*="color: black"],
        html.dark [style*="color: #000000"] {
            color: #F8FAFC !important;
        }

        html.dark [style*="color: #464554"],
        html.dark [style*="color:#464554"],
        html.dark [style*="color: #64748B"],
        html.dark [style*="color:#64748B"],
        html.dark [style*="color: #767586"],
        html.dark [style*="color:#767586"],
        html.dark [style*="color: #475569"],
        html.dark [style*="color:#475569"],
        html.dark [style*="color: #334155"],
        html.dark [style*="color:#334155"] {
            color: #CBD5E1 !important;
        }

        html.dark [style*="background: #e5eeff"],
        html.dark [style*="background:#e5eeff"],
        html.dark [style*="background: #F0F4FE"],
        html.dark [style*="background:#F0F4FE"],
        html.dark [style*="background: #f0f4fe"],
        html.dark [style*="background: #EEF2FF"],
        html.dark [style*="background:#EEF2FF"],
        html.dark [style*="background: #eef2ff"],
        html.dark [style*="background: #EFF6FF"],
        html.dark [style*="background:#EFF6FF"],
        html.dark [style*="background: #eff6ff"],
        html.dark [style*="background: #ffffff"],
        html.dark [style*="background:#ffffff"],
        html.dark [style*="background: white"],
        html.dark [style*="background: #fff"],
        html.dark [style*="background-color: #ffffff"],
        html.dark [style*="background-color: #fff"],
        html.dark [style*="background-color: #F8FAFC"],
        html.dark [style*="background-color: #f8fafc"],
        html.dark [style*="background-color: #f8f9ff"],
        html.dark [style*="background: #f8f9ff"],
        html.dark [style*="background-color: #fafafa"],
        html.dark [style*="background: #fafafa"],
        html.dark [style*="background: #F8FAFC"],
        html.dark [style*="background:#F8FAFC"] {
            background-color: #111827 !important;
            border-color: #263449 !important;
        }

        html.dark [style*="background: #FEE2E2"],
        html.dark [style*="background:#FEE2E2"] {
            background-color: rgba(239, 68, 68, 0.12) !important;
            color: #F87171 !important;
        }
        html.dark [style*="background: #DBEAFE"],
        html.dark [style*="background:#DBEAFE"] {
            background-color: rgba(59, 130, 246, 0.12) !important;
            color: #60A5FA !important;
        }
        html.dark [style*="rgba(70,72,212,0.05)"],
        html.dark [style*="rgba(70, 72, 212, 0.05)"] {
            background: rgba(59, 130, 246, 0.08) !important;
        }

        /* 16. Shared SaaS Component Dark Overrides (Referral, Domain Requests, Stores, Settings) */
        html.dark .referral-stat-card,
        html.dark .main-table-card,
        html.dark .config-card,
        html.dark .status-system-card,
        html.dark .domain-stat-box,
        html.dark .domain-table-card,
        html.dark .auto-approve-box,
        html.dark .store-table-footer {
            background-color: #111827 !important;
            border-color: #263449 !important;
            color: #F8FAFC !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3) !important;
        }

        html.dark .referral-header h1,
        html.dark .domain-header h1,
        html.dark .table-card-header h3,
        html.dark .config-card-title,
        html.dark .referral-stat-number,
        html.dark .domain-stat-number {
            color: #F8FAFC !important;
        }

        html.dark .referral-header p,
        html.dark .domain-header p,
        html.dark .referral-stat-label,
        html.dark .domain-stat-label,
        html.dark .range-slider-label,
        html.dark .referrer-id {
            color: #CBD5E1 !important;
        }

        html.dark .table-card-header {
            border-bottom-color: #263449 !important;
        }

        html.dark .tab-switch-btn,
        html.dark .btn-export-csv-outline {
            background-color: #1E293B !important;
            border-color: #334155 !important;
            color: #CBD5E1 !important;
        }

        html.dark .tab-switch-btn.active {
            background-color: #2563EB !important;
            color: #FFFFFF !important;
        }

        html.dark .referral-custom-table th,
        html.dark .custom-domain-table th {
            background-color: #0F172A !important;
            border-bottom-color: #263449 !important;
            color: #94A3B8 !important;
        }

        html.dark .referral-custom-table td,
        html.dark .custom-domain-table td {
            background-color: #111827 !important;
            border-bottom-color: #1E293B !important;
            color: #CBD5E1 !important;
        }

        html.dark .referral-custom-table tr:hover td,
        html.dark .custom-domain-table tr:hover td {
            background-color: #172033 !important;
        }

        html.dark .badge-domain-pending {
            background-color: rgba(245, 158, 11, 0.15) !important;
            color: #FBBF24 !important;
        }
        html.dark .badge-domain-approved {
            background-color: rgba(59, 130, 246, 0.15) !important;
            color: #60A5FA !important;
        }
        html.dark .badge-domain-rejected {
            background-color: rgba(239, 68, 68, 0.15) !important;
            color: #F87171 !important;
        }

        html.dark .btn-domain-approve {
            background-color: rgba(59, 130, 246, 0.15) !important;
            color: #60A5FA !important;
        }
        html.dark .btn-domain-approve:hover {
            background-color: #2563EB !important;
            color: #FFFFFF !important;
        }
        html.dark .btn-domain-reject {
            background-color: rgba(239, 68, 68, 0.15) !important;
            color: #F87171 !important;
        }
        html.dark .btn-domain-reject:hover {
            background-color: #DC2626 !important;
            color: #FFFFFF !important;
        }

        /* 17. Shared Pagination Dark Mode Override */
        html.dark .border-t,
        html.dark .border-gray-100,
        html.dark .border-gray-200 {
            border-color: #263449 !important;
        }
        html.dark .text-gray-600,
        html.dark .text-gray-500,
        html.dark .text-\[\#64748B\] {
            color: #CBD5E1 !important;
        }
        html.dark button.hover\:bg-gray-50:hover,
        html.dark .hover\:bg-gray-50:hover {
            background-color: #1E293B !important;
            color: #FFFFFF !important;
        }

        /* 18. Subscription Plans Page Specific Dark Theme Overrides */
        html.dark .plans-container {
            color: #F8FAFC !important;
        }
        html.dark .plans-header h1,
        html.dark .plan-card-title,
        html.dark .plan-price-amount,
        html.dark .subscriber-count,
        html.dark .revenue-header h3,
        html.dark .plan-name-text {
            color: #F8FAFC !important;
        }
        html.dark .plans-header p,
        html.dark .plan-card-subtitle,
        html.dark .plan-price-period,
        html.dark .feature-row,
        html.dark .subscriber-label,
        html.dark .revenue-header p {
            color: #CBD5E1 !important;
        }
        html.dark .plan-card-standard,
        html.dark .subscriber-bar-standard,
        html.dark .revenue-card {
            background-color: #111827 !important;
            border-color: #263449 !important;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25) !important;
        }
        html.dark .revenue-header {
            border-bottom-color: #263449 !important;
        }
        html.dark .revenue-table th {
            background-color: #0F172A !important;
            border-bottom-color: #263449 !important;
            color: #94A3B8 !important;
        }
        html.dark .revenue-table td {
            background-color: #111827 !important;
            border-bottom-color: #1E293B !important;
            color: #CBD5E1 !important;
        }
        html.dark .revenue-table tr:hover td {
            background-color: #172033 !important;
        }
        html.dark .revenue-table tfoot tr td {
            background-color: #0F172A !important;
            border-top-color: #263449 !important;
            color: #F8FAFC !important;
        }
        html.dark .feature-icon-check {
            color: #60A5FA !important;
        }
        html.dark .btn-circle-edit {
            background-color: rgba(59, 130, 246, 0.15) !important;
            color: #60A5FA !important;
        }
        html.dark .btn-circle-edit:hover {
            background-color: #2563EB !important;
            color: #FFFFFF !important;
        }

        /* 19. Email Templates & Shared Components Dark Overrides */
        html.dark .templates-container {
            color: #F8FAFC !important;
        }
        html.dark .templates-header h1,
        html.dark .template-title {
            color: #F8FAFC !important;
        }
        html.dark .templates-header p,
        html.dark .template-category,
        html.dark .template-description,
        html.dark .btn-preview-link {
            color: #CBD5E1 !important;
        }
        html.dark .template-card {
            background-color: #111827 !important;
            border-color: #263449 !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3) !important;
        }
        html.dark .edited-badge-pill {
            background-color: #172033 !important;
            border-color: #263449 !important;
            color: #CBD5E1 !important;
        }
        html.dark .template-card-footer {
            border-top-color: #263449 !important;
        }
        html.dark .stores-table-footer {
            background-color: #111827 !important;
            border-top-color: #263449 !important;
        }
        html.dark .footer-count-text {
            color: #CBD5E1 !important;
        }
        html.dark .page-pill {
            background-color: #172033 !important;
            border-color: #263449 !important;
            color: #CBD5E1 !important;
        }
        html.dark .page-pill.active {
            background-color: #2563EB !important;
            color: #FFFFFF !important;
            border-color: #2563EB !important;
        }

        /* Force brand purple color variables and override legacy themes */
        .nav-pills .nav-link.active,
        .nav-pills .show > .nav-link {
            background-color: {{ $primaryColor }} !important;
            color: #ffffff !important;
        }
        .form-check-input:checked,
        .form-check-input.input-primary:checked {
            background-color: {{ $primaryColor }} !important;
            border-color: {{ $primaryColor }} !important;
        }
        .card.border-primary,
        .border-primary {
            border-color: {{ $primaryColor }} !important;
        }
        .btn-primary {
            background-color: {{ $primaryColor }} !important;
            border-color: {{ $primaryColor }} !important;
        }
        .btn-primary:hover {
            background-color: {{ $primaryColor }} !important;
            border-color: {{ $primaryColor }} !important;
        }
        .text-primary {
            color: {{ $primaryColor }} !important;
        }

        /* Force notification toast/alert colors to brand purple and override theme specific rules */
        .toast.bg-primary,
        .toast.bg-success,
        .toast.bg-info,
        .alert-primary,
        .alert-success,
        body.theme-1 .bg-primary, body.theme-2 .bg-primary, body.theme-3 .bg-primary, body.theme-4 .bg-primary, body.theme-5 .bg-primary, body.theme-6 .bg-primary, body.theme-7 .bg-primary, body.theme-8 .bg-primary, body.theme-9 .bg-primary, body.theme-10 .bg-primary,
        body.theme-1 .alert-primary, body.theme-2 .alert-primary, body.theme-3 .alert-primary, body.theme-4 .alert-primary, body.theme-5 .alert-primary, body.theme-6 .alert-primary, body.theme-7 .alert-primary, body.theme-8 .alert-primary, body.theme-9 .alert-primary, body.theme-10 .alert-primary,
        body.theme-1 .alert-success, body.theme-2 .alert-success, body.theme-3 .alert-success, body.theme-4 .alert-success, body.theme-5 .alert-success, body.theme-6 .alert-success, body.theme-7 .alert-success, body.theme-8 .alert-success, body.theme-9 .alert-success, body.theme-10 .alert-success {
            background-color: {{ $primaryColor }} !important;
            background: {{ $primaryColor }} !important;
            border-color: {{ $primaryColor }} !important;
        }

        /* Force checkboxes/toggles active color across all themes */
        body.theme-1 .form-check-input:checked, body.theme-2 .form-check-input:checked, body.theme-3 .form-check-input:checked, body.theme-4 .form-check-input:checked, body.theme-5 .form-check-input:checked, body.theme-6 .form-check-input:checked, body.theme-7 .form-check-input:checked, body.theme-8 .form-check-input:checked, body.theme-9 .form-check-input:checked, body.theme-10 .form-check-input:checked,
        body.theme-1 .form-check-input.input-primary:checked, body.theme-2 .form-check-input.input-primary:checked, body.theme-3 .form-check-input.input-primary:checked, body.theme-4 .form-check-input.input-primary:checked, body.theme-5 .form-check-input.input-primary:checked, body.theme-6 .form-check-input.input-primary:checked, body.theme-7 .form-check-input.input-primary:checked, body.theme-8 .form-check-input.input-primary:checked, body.theme-9 .form-check-input.input-primary:checked, body.theme-10 .form-check-input.input-primary:checked {
            background-color: {{ $primaryColor }} !important;
            border-color: {{ $primaryColor }} !important;
        }

        /* Force active nav link color across all themes */
        body.theme-1 .nav-pills .nav-link.active, body.theme-2 .nav-pills .nav-link.active, body.theme-3 .nav-pills .nav-link.active, body.theme-4 .nav-pills .nav-link.active, body.theme-5 .nav-pills .nav-link.active, body.theme-6 .nav-pills .nav-link.active, body.theme-7 .nav-pills .nav-link.active, body.theme-8 .nav-pills .nav-link.active, body.theme-9 .nav-pills .nav-link.active, body.theme-10 .nav-pills .nav-link.active {
            background-color: {{ $primaryColor }} !important;
            color: #ffffff !important;
        }

        /* Force primary borders across all themes */
        body.theme-1 .border-primary, body.theme-2 .border-primary, body.theme-3 .border-primary, body.theme-4 .border-primary, body.theme-5 .border-primary, body.theme-6 .border-primary, body.theme-7 .border-primary, body.theme-8 .border-primary, body.theme-9 .border-primary, body.theme-10 .border-primary {
            border-color: {{ $primaryColor }} !important;
        }

        /* Override legacy link colors to inherit or map to neutral gray/black */
        a {
            color: var(--text-primary);
            text-decoration: none;
        }

        .breadcrumb a,
        .breadcrumb-item a,
        [class*="breadcrumbs"] a {
            color: var(--text-muted) !important;
        }
        .breadcrumb a:hover,
        .breadcrumb-item a:hover,
        [class*="breadcrumbs"] a:hover {
            color: var(--text-primary) !important;
        }

        /* Sidebar Link Styles */
        .sg-sidebar a,
        .sg-sidebar button {
            color: var(--text-secondary) !important;
            background-color: transparent !important;
            transition: all 0.2s ease-in-out !important;
            font-weight: 500 !important;
        }
        
        .sg-sidebar a:hover,
        .sg-sidebar button:hover {
            background-color: var(--surface-2) !important;
            color: var(--primary) !important;
        }

        /* Inactive submenu link colors */
        .sg-sidebar div a {
            color: var(--text-secondary) !important;
        }

        /* Active sidebar link styles */
        .sg-sidebar a[style*="background: {{ $primaryColor }}"],
        .sg-sidebar a[style*="background: rgb(96, 99, 238)"],
        .sg-sidebar button[style*="background: {{ $primaryColor }}"],
        .sg-sidebar button[style*="background: rgb(96, 99, 238)"],
        .sg-sidebar a[style*="background:{{ $primaryColor }}"],
        .sg-sidebar a[style*="background:rgb(96,99,238)"] {
            background-color: {{ $primaryColor }} !important;
            color: #ffffff !important;
        }

        /* Active submenu link styles */
        .sg-sidebar div a[style*="background: {{ $primaryColor }}"],
        .sg-sidebar div a[style*="background: rgb(96, 99, 238)"],
        .sg-sidebar div a[style*="background:{{ $primaryColor }}"],
        .sg-sidebar div a[style*="background:rgb(96,99,238)"] {
            background-color: {{ $primaryColor }} !important;
            color: #ffffff !important;
        }

        /* Force children inside sidebar and header to inherit parent text colors */
        .sg-sidebar a *,
        .sg-sidebar button *,
        .sg-header a *,
        .sg-header button * {
            color: inherit !important;
        }

        /* Material Symbols */
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        /* Main content area */
        .sg-main-content {
            padding-left: 16px;
            padding-right: 16px;
        }
        
        /* Content top padding */
        .sg-content-body {
            padding-top: calc(64px + 16px + 16px);
            padding-bottom: 16px;
        }

        .sg-header {
            left: 16px;
            right: 16px;
            top: 16px;
        }

        .sg-sidebar {
            width: 240px;
            margin: 16px;
            height: calc(100vh - 32px);
        }

        .sg-main-content {
            transition: padding-left 0.3s ease-in-out;
        }
        @media (min-width: 1024px) {
            .sg-main-content {
                padding-left: calc(240px + 32px + 32px);
                padding-right: 32px;
            }
            body.sidebar-closed .sg-main-content {
                padding-left: 32px;
            }
            .sg-content-body {
                padding-top: calc(64px + 32px + 16px);
                padding-bottom: 32px;
            }
            .sg-header {
                left: calc(240px + 64px);
                right: 32px;
                top: 32px;
            }
            body.sidebar-closed .sg-header {
                left: 32px;
            }
            .sg-sidebar {
                margin: 32px;
                height: calc(100vh - 64px);
            }
        }

        /* Hide old Bootstrap page header breadcrumbs */
        .page-header { display: none !important; }

        /* Modernize Bootstrap Cards to match Stitch */
        .card {
            border-radius: 12px !important;
            box-shadow: 0 1px 8px rgba(0,0,0,0.04) !important;
            border: 1px solid var(--border) !important;
            background: var(--surface) !important;
            color: var(--text-primary) !important;
            margin-bottom: 24px !important;
        }
        .card-header {
            background-color: transparent !important;
            border-bottom: 1px solid var(--border) !important;
            padding: 20px 24px !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 16px !important;
            font-weight: 600 !important;
            color: var(--text-primary) !important;
            letter-spacing: -0.02em !important;
        }
        .card-body {
            padding: 24px !important;
        }

        /* Form Controls → Stitch style */
        .form-control,
        .custom-select,
        select.form-control,
        .dataTable-input,
        .dataTable-selector {
            border-radius: 8px !important;
            border: 1px solid var(--border) !important;
            padding: 8px 12px !important;
            box-shadow: none !important;
            font-size: 14px !important;
            font-family: 'Inter', sans-serif !important;
            color: var(--text-primary) !important;
            background-color: var(--input-bg) !important;
            transition: box-shadow 0.2s, border-color 0.2s !important;
        }
        .form-control:focus,
        .custom-select:focus,
        .dataTable-input:focus,
        .dataTable-selector:focus {
            border-color: {{ $primaryColor }} !important;
            box-shadow: 0 0 0 3px rgba(70,72,212,0.12) !important;
            outline: none !important;
            background-color: #ffffff !important;
            color: #0b1c30 !important;
        }

        /* Choices.js Dropdown / Select Overrides: Fix Black Box Issue */
        .choices__inner {
            background-color: #f8f9ff !important;
            border: 1px solid #c7c4d7 !important;
            border-radius: 8px !important;
            color: #0b1c30 !important;
            padding: 8px 12px !important;
            min-height: 40px !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 14px !important;
            display: flex !important;
            align-items: center !important;
        }
        .choices.is-focused .choices__inner,
        .choices.is-open .choices__inner {
            border-color: {{ $primaryColor }} !important;
            background-color: #ffffff !important;
            box-shadow: 0 0 0 3px rgba(70,72,212,0.12) !important;
        }
        .choices__list--dropdown {
            background-color: #ffffff !important;
            border: 1px solid #c7c4d7 !important;
            border-radius: 8px !important;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08) !important;
            z-index: 99 !important;
        }
        .choices__list--dropdown .choices__item--selectable.is-highlighted {
            background-color: #f1f5f9 !important;
            color: #0b1c30 !important;
        }
        .choices__list--dropdown .choices__item {
            color: #0b1c30 !important;
            font-size: 14px !important;
            padding: 8px 12px !important;
        }
        
        /* Multi-select active choices pill/badge */
        .choices__list--multiple .choices__item {
            background-color: #e2e8f0 !important;
            border: 1px solid #cbd5e1 !important;
            color: #0b1c30 !important;
            border-radius: 6px !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            padding: 2px 8px !important;
            margin-right: 4px !important;
        }
        .choices__list--multiple .choices__item.is-highlighted {
            background-color: #cbd5e1 !important;
        }
        
        /* Placeholder styling inside choices */
        .choices__input {
            background-color: transparent !important;
            color: #0b1c30 !important;
            font-size: 14px !important;
        }
        .choices__placeholder {
            color: #767586 !important;
            opacity: 0.8 !important;
        }

        label,
        .form-label {
            font-family: 'Geist', sans-serif !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            letter-spacing: 0.02em !important;
            color: #464554 !important;
            margin-bottom: 4px !important;
        }

        /* Buttons */
        .btn {
            border-radius: 8px !important;
            font-weight: 500 !important;
            font-family: 'Geist', sans-serif !important;
            font-size: 12px !important;
            letter-spacing: 0.02em !important;
            padding: 10px 16px !important;
            box-shadow: none !important;
            transition: all 0.2s !important;
            border: none !important;
        }
        .btn-primary {
            background-color: {{ $primaryColor }} !important;
            color: #ffffff !important;
        }
        .btn-primary:hover {
            background-color: {{ $primaryColor }} !important;
            color: #ffffff !important;
        }
        .btn-secondary {
            background-color: #e5eeff !important;
            color: {{ $primaryColor }} !important;
        }
        .btn-secondary:hover {
            background-color: #dce9ff !important;
        }
        .btn-danger {
            background-color: #ba1a1a !important;
            color: #ffffff !important;
        }
        .btn-danger:hover {
            background-color: #93000a !important;
        }
        .btn-success {
            background-color: #1a7431 !important;
            color: #ffffff !important;
        }
        .btn-warning {
            background-color: #904900 !important;
            color: #ffffff !important;
        }
        .btn-light, .btn-outline-secondary {
            background-color: #eff4ff !important;
            color: #464554 !important;
            border: 1px solid rgba(199,196,215,0.4) !important;
        }
        .btn-light:hover, .btn-outline-secondary:hover {
            background-color: #dce9ff !important;
            color: #0b1c30 !important;
        }
        .btn-sm {
            padding: 6px 12px !important;
            font-size: 12px !important;
        }
        .btn-xs {
            padding: 4px 8px !important;
            font-size: 11px !important;
        }

        /* Badges / Pills */
        .badge {
            font-weight: 500 !important;
            font-family: 'Geist', sans-serif !important;
            font-size: 11px !important;
            padding: 4px 8px !important;
            border-radius: 6px !important;
            letter-spacing: 0.02em !important;
        }
        .badge-primary { background-color: #e5eeff !important; color: {{ $primaryColor }} !important; }
        .badge-success { background-color: #e8f5e9 !important; color: #1a7431 !important; }
        .badge-danger { background-color: #ffdad6 !important; color: #ba1a1a !important; }
        .badge-warning { background-color: #fff3e0 !important; color: #904900 !important; }
        .badge-info { background-color: #dae2fd !important; color: #565e74 !important; }

        /* Custom Blue Form Switches & Toggles */
        .form-switch .form-check-input:checked,
        .form-check-input:checked {
            background-color: #4648d4 !important;
            border-color: #4648d4 !important;
        }
        .form-switch .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(70,72,212,0.15) !important;
        }

        /* Tables */
        .table {
            font-family: 'Inter', sans-serif !important;
            font-size: 13px !important;
            color: #0b1c30 !important;
        }
        .table th {
            font-family: 'Geist', sans-serif !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            letter-spacing: 0.05em !important;
            text-transform: uppercase !important;
            color: #767586 !important;
            background-color: #eff4ff !important;
            border-bottom: 1px solid #E2E8F0 !important;
            padding: 12px 16px !important;
        }
        .table td {
            padding: 12px 16px !important;
            vertical-align: middle !important;
            border-bottom: 1px solid #E2E8F0 !important;
            color: #0b1c30 !important;
        }
        .table tbody tr:hover {
            background-color: #eff4ff !important;
        }
        .table-bordered {
            border: 1px solid #E2E8F0 !important;
        }
        .table-bordered th,
        .table-bordered td {
            border: none !important;
            border-bottom: 1px solid #E2E8F0 !important;
        }

        /* Nav Tabs */
        .nav-tabs {
            border-bottom: 1px solid rgba(199,196,215,0.2) !important;
        }
        .nav-tabs .nav-link {
            font-family: 'Geist', sans-serif !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #767586 !important;
            border: none !important;
            padding: 10px 16px !important;
            transition: color 0.2s !important;
            border-radius: 0 !important;
        }
        .nav-tabs .nav-link:hover {
            color: #0b1c30 !important;
            background: none !important;
        }
        .nav-tabs .nav-link.active {
            color: {{ $primaryColor }} !important;
            border-bottom: 2px solid {{ $primaryColor }} !important;
            background: none !important;
        }

        /* Nav Pills (Settings sidebar) */
        .nav-pills .nav-link {
            font-family: 'Geist', sans-serif !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            color: #464554 !important;
            border-radius: 8px !important;
            padding: 10px 14px !important;
            transition: all 0.2s !important;
        }
        .nav-pills .nav-link:hover {
            background-color: #f1f1f1 !important;
            color: #0b1c30 !important;
        }
        .nav-pills .nav-link.active {
            background-color: #e5eeff !important;
            color: {{ $primaryColor }} !important;
        }

        /* Modals */
        .modal-content {
            border-radius: 12px !important;
            border: 1px solid rgba(199,196,215,0.2) !important;
            box-shadow: 0 8px 40px rgba(0,0,0,0.12) !important;
            font-family: 'Inter', sans-serif !important;
        }
        .modal-header {
            padding: 20px 24px !important;
            border-bottom: 1px solid rgba(199,196,215,0.2) !important;
            background: transparent !important;
        }
        .modal-title {
            font-family: 'Geist', sans-serif !important;
            font-size: 16px !important;
            font-weight: 600 !important;
            color: #0b1c30 !important;
        }
        .modal-body {
            padding: 24px !important;
        }
        .modal-footer {
            padding: 16px 24px !important;
            border-top: 1px solid rgba(199,196,215,0.2) !important;
            gap: 8px !important;
        }
        .modal-backdrop.show {
            opacity: 0.3 !important;
        }

        /* Alerts */
        .alert {
            border-radius: 8px !important;
            border: 1px solid !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 13px !important;
            padding: 12px 16px !important;
        }
        .alert-success { background: #e8f5e9 !important; border-color: rgba(26,116,49,0.2) !important; color: #1a7431 !important; }
        .alert-danger { background: #ffdad6 !important; border-color: rgba(186,26,26,0.2) !important; color: #ba1a1a !important; }
        .alert-warning { background: #fff3e0 !important; border-color: rgba(144,73,0,0.2) !important; color: #904900 !important; }
        .alert-info { background: #e5eeff !important; border-color: rgba(70,72,212,0.2) !important; color: {{ $primaryColor }} !important; }

        /* Input groups */
        .input-group-text {
            background-color: #eff4ff !important;
            border: 1px solid #c7c4d7 !important;
            color: #767586 !important;
            border-radius: 8px 0 0 8px !important;
            font-size: 14px !important;
        }
        .input-group .form-control {
            border-radius: 0 8px 8px 0 !important;
        }

        /* Dropdowns */
        .dropdown-menu {
            border-radius: 12px !important;
            border: 1px solid rgba(199,196,215,0.2) !important;
            box-shadow: 0 4px 24px rgba(0,0,0,0.1) !important;
            padding: 6px !important;
            font-family: 'Inter', sans-serif !important;
        }
        .dropdown-item {
            border-radius: 8px !important;
            font-size: 13px !important;
            padding: 8px 12px !important;
            color: #464554 !important;
            transition: background 0.2s !important;
        }
        .dropdown-item:hover {
            background-color: #eff4ff !important;
            color: #0b1c30 !important;
        }
        .dropdown-divider {
            border-top: 1px solid rgba(199,196,215,0.2) !important;
            margin: 4px 0 !important;
        }

        /* DataTables */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: {{ $primaryColor }} !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 8px !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #e5eeff !important;
            color: {{ $primaryColor }} !important;
            border: none !important;
            border-radius: 8px !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 8px !important;
            border: none !important;
            font-family: 'Geist', sans-serif !important;
            font-size: 12px !important;
        }

        /* Select2 */
        .select2-container--default .select2-selection--single {
            height: 42px !important;
            border: 1px solid #c7c4d7 !important;
            border-radius: 8px !important;
            background-color: #f8f9ff !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 42px !important;
            padding-left: 12px !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 14px !important;
            color: #0b1c30 !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 42px !important;
        }
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #c7c4d7 !important;
            border-radius: 8px !important;
            min-height: 42px !important;
            background-color: #f8f9ff !important;
        }
        .select2-dropdown {
            border: 1px solid rgba(199,196,215,0.2) !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 24px rgba(0,0,0,0.1) !important;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #e5eeff !important;
            color: {{ $primaryColor }} !important;
        }

        /* Pagination */
        .pagination .page-item .page-link {
            border-radius: 8px !important;
            border: none !important;
            font-family: 'Geist', sans-serif !important;
            font-size: 12px !important;
            color: #464554 !important;
            transition: all 0.2s !important;
        }
        .pagination .page-item.active .page-link {
            background-color: {{ $primaryColor }} !important;
            color: #ffffff !important;
        }
        .pagination .page-item .page-link:hover {
            background-color: #e5eeff !important;
            color: {{ $primaryColor }} !important;
        }

        /* Dashboard container override */
        .dash-container { margin: 0 !important; padding: 0 !important; width: 100% !important; min-height: auto !important; top: 0 !important; background: transparent !important; }
        .dash-content { padding: 0 !important; margin: 0 !important; }

        /* Section titles */
        .section-title,
        h4.card-title {
            font-family: 'Geist', sans-serif !important;
            font-size: 16px !important;
            font-weight: 600 !important;
            color: #0b1c30 !important;
            letter-spacing: -0.02em !important;
        }

        /* iziToast overrides */
        .iziToast {
            border-radius: 12px !important;
            font-family: 'Inter', sans-serif !important;
        }
        .iziToast-success { background: #e8f5e9 !important; border-left: 4px solid #1a7431 !important; }
        .iziToast-error { background: #ffdad6 !important; border-left: 4px solid #ba1a1a !important; }
        .iziToast-warning { background: #fff3e0 !important; border-left: 4px solid #904900 !important; }
        .iziToast-info { background: #e5eeff !important; border-left: 4px solid {{ $primaryColor }} !important; }
    </style>
    @stack('style')
</head>
<body class="{{ $themeColor }} {{ (isset($settings['cust_darklayout']) && $settings['cust_darklayout'] == 'on') ? 'dark' : '' }} text-on-surface antialiased" x-data="{ sidebarOpen: window.innerWidth >= 1024 }" :class="{ 'sidebar-closed': !sidebarOpen }" @resize.window="if(window.innerWidth >= 1024 && !sidebarOpen && !document.body.classList.contains('sidebar-closed-manual')) { sidebarOpen = true }">
    <script>
        (function() {
            var savedTheme = localStorage.getItem('virratpos_theme');
            var serverTheme = "{{ isset($settings['cust_darklayout']) ? $settings['cust_darklayout'] : 'off' }}";
            var isDark = savedTheme === 'dark' || (savedTheme !== 'light' && serverTheme === 'on');
            if (isDark) {
                document.body.classList.add('dark');
                document.documentElement.classList.add('dark');
                document.documentElement.setAttribute('data-theme', 'dark');
            } else {
                document.body.classList.remove('dark');
                document.documentElement.classList.remove('dark');
                document.documentElement.setAttribute('data-theme', 'light');
            }
        })();
    </script>

    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <div style="display: flex; min-height: 100vh; overflow-x: hidden; background-color: var(--app-bg);">
        
        <!-- Sidebar (Stitch floating card) -->
        @include('partials.ui.sidebar')

        <!-- Main Content Area -->
        <div class="relative flex flex-col flex-1 min-h-screen overflow-y-auto overflow-x-hidden sg-main-content" style="background-color: var(--app-bg);">
            
            <!-- Header (Stitch floating card) -->
            @include('partials.ui.header')

            <!-- Main Content -->
            <main class="w-full flex-1 sg-content-body" style="background-color: var(--app-bg);">
                <div class="dash-container" style="background-color: var(--app-bg);">
                    <div class="dash-content" style="background-color: var(--app-bg);">
                        @yield('content')
                    </div>
                </div>
            </main>

            <!-- Footer (Inside main flex column) -->
            @include('partials.admin.footer')
        </div>
        
    </div>

    <!-- Common Modal -->
    <div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commonModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="commonModalOver" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="commonModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
    @if (isset($settings['enable_cookie']) && $settings['enable_cookie'] == 'on')
        @include('layouts.cookie_consent')
    @endif
    @stack('scripts')
</body>
</html>
