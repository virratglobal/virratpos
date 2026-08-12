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
        body { font-family: 'Inter', sans-serif !important; background-color: #f8f9ff !important; color: #0b1c30 !important; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .sg-main-content { padding-left: calc(240px + 32px + 32px); padding-right: 32px; }
        .sg-content-body { padding-top: calc(64px + 32px + 16px); padding-bottom: 32px; }
        .page-header { display: none !important; }
        .dash-container { margin: 0 !important; padding: 0 !important; width: 100% !important; min-height: auto !important; top: 0 !important; background: transparent !important; }
        .dash-content { padding: 0 !important; margin: 0 !important; }
        .card { border-radius: 12px !important; box-shadow: 0 1px 8px rgba(0,0,0,0.04) !important; border: 1px solid rgba(199,196,215,0.15) !important; background: #ffffff !important; margin-bottom: 24px !important; }
        .card-header { background-color: transparent !important; border-bottom: 1px solid rgba(199,196,215,0.2) !important; padding: 20px 24px !important; font-family: 'Geist', sans-serif !important; font-size: 16px !important; font-weight: 600 !important; color: #0b1c30 !important; }
        .card-body { padding: 24px !important; }
        .form-control, .custom-select { border-radius: 8px !important; border: 1px solid #c7c4d7 !important; padding: 10px 12px !important; box-shadow: none !important; font-size: 14px !important; font-family: 'Inter', sans-serif !important; color: #0b1c30 !important; background-color: #f8f9ff !important; }
        .form-control:focus { border-color: #4648d4 !important; box-shadow: 0 0 0 3px rgba(70,72,212,0.12) !important; }
        .btn { border-radius: 8px !important; font-weight: 500 !important; font-family: 'Geist', sans-serif !important; font-size: 12px !important; padding: 10px 16px !important; box-shadow: none !important; border: none !important; }
        .btn-primary { background-color: #4648d4 !important; color: #ffffff !important; }
        .btn-primary:hover { background-color: #2f2ebe !important; }
        .btn-secondary { background-color: #e5eeff !important; color: #4648d4 !important; }
        .btn-danger { background-color: #ba1a1a !important; color: #ffffff !important; }
        .badge { font-weight: 500 !important; font-family: 'Geist', sans-serif !important; font-size: 11px !important; padding: 4px 8px !important; border-radius: 6px !important; }
        .table th { font-family: 'Geist', sans-serif !important; font-size: 11px !important; text-transform: uppercase !important; letter-spacing: 0.08em !important; color: #767586 !important; background-color: #eff4ff !important; border-bottom: 1px solid rgba(199,196,215,0.2) !important; padding: 12px 16px !important; }
        .table td { padding: 12px 16px !important; border-bottom: 1px solid rgba(199,196,215,0.1) !important; }
        .modal-content { border-radius: 12px !important; box-shadow: 0 8px 40px rgba(0,0,0,0.12) !important; }
        .modal-header { padding: 20px 24px !important; border-bottom: 1px solid rgba(199,196,215,0.2) !important; }
        .modal-title { font-family: 'Geist', sans-serif !important; font-size: 16px !important; font-weight: 600 !important; color: #0b1c30 !important; }
        .modal-body { padding: 24px !important; }
        .dropdown-menu { border-radius: 12px !important; border: 1px solid rgba(199,196,215,0.2) !important; box-shadow: 0 4px 24px rgba(0,0,0,0.1) !important; padding: 6px !important; }
        .dropdown-item { border-radius: 8px !important; font-size: 13px !important; padding: 8px 12px !important; color: #464554 !important; }
        .dropdown-item:hover { background-color: #eff4ff !important; color: #0b1c30 !important; }
        .nav-pills .nav-link { font-family: 'Geist', sans-serif !important; font-size: 13px !important; color: #464554 !important; border-radius: 8px !important; padding: 10px 14px !important; }
        .nav-pills .nav-link.active { background-color: #e5eeff !important; color: #4648d4 !important; }
    </style>
</head>
<body class="{{ $themeColor }} antialiased" x-data="{ sidebarOpen: false }" style="background-color: #f8f9ff !important;">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>

    <div style="display: flex; min-height: 100vh; background: #f8f9ff; overflow-x: hidden;">
        
        <!-- Sidebar -->
        @include('partials.ui.sidebar')

        <!-- Main Content Area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden sg-main-content">
            <!-- Header -->
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

    @include('partials.admin.footer')
    @if (isset($settings['enable_cookie']) && $settings['enable_cookie'] == 'on')
        @include('layouts.cookie_consent')
    @endif
</body>
</html>
