@php
// get theme color
$setting = App\Models\Utility::colorset();

$settings = Utility::settings();
$color = !empty($setting['color']) ? $setting['color'] : 'theme-3';

if(isset($setting['color_flag']) && $setting['color_flag'] == 'true')
{
    $themeColor = 'custom-color';
}
else {
    $themeColor = $color;
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
            corePlugins: { preflight: false },
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        // Stitch design tokens
                        "sg-primary": "#4648d4",
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
                        "sg-primary-container": "#6063ee",
                        "sg-on-primary-container": "#fffbff",
                        // Legacy compat
                        primary: { DEFAULT: '#4648d4', light: '#6063ee', dark: '#2f2ebe' },
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

    <style>
        /* Reset and base */
        body {
            font-family: 'Inter', sans-serif !important;
            background-color: #f8f9ff !important;
            color: #0b1c30 !important;
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

        @media (min-width: 1024px) {
            .sg-main-content {
                padding-left: calc(240px + 32px + 32px);
                padding-right: 32px;
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
            border: 1px solid rgba(199,196,215,0.15) !important;
            background: #ffffff !important;
            margin-bottom: 24px !important;
        }
        .card-header {
            background-color: transparent !important;
            border-bottom: 1px solid rgba(199,196,215,0.2) !important;
            padding: 20px 24px !important;
            font-family: 'Geist', sans-serif !important;
            font-size: 16px !important;
            font-weight: 600 !important;
            color: #0b1c30 !important;
            letter-spacing: -0.02em !important;
        }
        .card-body {
            padding: 24px !important;
        }

        /* Form Controls → Stitch style */
        .form-control,
        .custom-select,
        select.form-control {
            border-radius: 8px !important;
            border: 1px solid #c7c4d7 !important;
            padding: 10px 12px !important;
            box-shadow: none !important;
            font-size: 14px !important;
            font-family: 'Inter', sans-serif !important;
            color: #0b1c30 !important;
            background-color: #f8f9ff !important;
            transition: box-shadow 0.2s, border-color 0.2s !important;
        }
        .form-control:focus,
        .custom-select:focus {
            border-color: #4648d4 !important;
            box-shadow: 0 0 0 3px rgba(70,72,212,0.12) !important;
            outline: none !important;
            background-color: #ffffff !important;
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
            background-color: #4648d4 !important;
            color: #ffffff !important;
        }
        .btn-primary:hover {
            background-color: #2f2ebe !important;
            color: #ffffff !important;
        }
        .btn-secondary {
            background-color: #e5eeff !important;
            color: #4648d4 !important;
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
        .badge-primary { background-color: #e5eeff !important; color: #4648d4 !important; }
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
            color: #4648d4 !important;
            border-bottom: 2px solid #4648d4 !important;
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
            background-color: #eff4ff !important;
            color: #0b1c30 !important;
        }
        .nav-pills .nav-link.active {
            background-color: #e5eeff !important;
            color: #4648d4 !important;
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
        .alert-info { background: #e5eeff !important; border-color: rgba(70,72,212,0.2) !important; color: #4648d4 !important; }

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
            background: #4648d4 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 8px !important;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #e5eeff !important;
            color: #4648d4 !important;
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
            color: #4648d4 !important;
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
            background-color: #4648d4 !important;
            color: #ffffff !important;
        }
        .pagination .page-item .page-link:hover {
            background-color: #e5eeff !important;
            color: #4648d4 !important;
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
        .iziToast-info { background: #e5eeff !important; border-left: 4px solid #4648d4 !important; }
    </style>
    @stack('style')
</head>
<body class="{{ $themeColor }} text-on-surface antialiased" x-data="{ sidebarOpen: false }" style="background-color: #f8f9ff !important;">

    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <div style="display: flex; min-height: 100vh; background: #f8f9ff; overflow-x: hidden;">
        
        <!-- Sidebar (Stitch floating card) -->
        @include('partials.ui.sidebar')

        <!-- Main Content Area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden sg-main-content">
            
            <!-- Header (Stitch floating card) -->
            @include('partials.ui.header')

            <!-- Main Content -->
            <main class="w-full sg-content-body">
                <div class="dash-container">
                    <div class="dash-content">
                        @yield('content')
                    </div>
                </div>
            </main>
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
