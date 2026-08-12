@php
    $logo = asset('storage/uploads/logo/');
    $company_logo = Utility::getValByName('company_logo');
    $darklogo = Utility::getValByName('company_logo_dark');
    $setting = App\Models\Utility::colorset();
    $color = 'theme-3';
    if (!empty($setting['color'])) {
        $color = $setting['color'];
    }
    
    // For language dropdown
    $lang = \App::getLocale('lang');
    if($lang == 'ar' || $lang == 'he'){
        $setting['SITE_RTL'] = 'on';
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ isset($setting['SITE_RTL']) && $setting['SITE_RTL'] == 'on' ? 'rtl' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{(Utility::getValByName('title_text')) ? Utility::getValByName('title_text') : config('app.name', 'SaaS')}} - @yield('page-title')</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "on-secondary": "#ffffff",
                        "tertiary-fixed": "#ffdcc5",
                        "inverse-surface": "#213145",
                        "on-secondary-fixed-variant": "#3f465c",
                        "on-surface": "#0b1c30",
                        "surface": "#f8f9ff",
                        "on-tertiary": "#ffffff",
                        "surface-container": "#e5eeff",
                        "on-tertiary-fixed-variant": "#703700",
                        "outline-variant": "#c7c4d7",
                        "on-primary-container": "#fffbff",
                        "on-tertiary-container": "#fffbff",
                        "on-tertiary-fixed": "#301400",
                        "surface-dim": "#cbdbf5",
                        "surface-tint": "#494bd6",
                        "primary-fixed": "#e1e0ff",
                        "secondary-fixed": "#dae2fd",
                        "error": "#ba1a1a",
                        "primary": "#4648d4",
                        "tertiary": "#904900",
                        "tertiary-fixed-dim": "#ffb783",
                        "outline": "#767586",
                        "on-primary": "#ffffff",
                        "on-error": "#ffffff",
                        "error-container": "#ffdad6",
                        "surface-variant": "#d3e4fe",
                        "surface-container-high": "#dce9ff",
                        "secondary-container": "#dae2fd",
                        "tertiary-container": "#b55d00",
                        "primary-container": "#6063ee",
                        "surface-container-highest": "#d3e4fe",
                        "on-secondary-fixed": "#131b2e",
                        "background": "#f8f9ff",
                        "inverse-on-surface": "#eaf1ff",
                        "on-secondary-container": "#5c647a",
                        "primary-fixed-dim": "#c0c1ff",
                        "on-background": "#0b1c30",
                        "inverse-primary": "#c0c1ff",
                        "on-error-container": "#93000a",
                        "secondary": "#565e74",
                        "surface-container-low": "#eff4ff",
                        "surface-bright": "#f8f9ff",
                        "on-primary-fixed": "#07006c",
                        "surface-container-lowest": "#ffffff",
                        "on-surface-variant": "#464554",
                        "secondary-fixed-dim": "#bec6e0",
                        "on-primary-fixed-variant": "#2f2ebe"
                    },
                    fontFamily: {
                        "body-sm": ["Inter"],
                        "body-lg": ["Inter"],
                        "label-md": ["Geist"],
                        "headline-lg": ["Geist"],
                        "body-md": ["Inter"],
                        "headline-md": ["Geist"],
                        "display": ["Geist"]
                    },
                    fontSize: {
                        "body-sm": ["13px", { lineHeight: "18px", fontWeight: "400" }],
                        "body-lg": ["16px", { lineHeight: "24px", fontWeight: "400" }],
                        "label-md": ["12px", { lineHeight: "16px", letterSpacing: "0.02em", fontWeight: "500" }],
                        "headline-lg": ["24px", { lineHeight: "32px", letterSpacing: "-0.02em", fontWeight: "600" }],
                        "body-md": ["14px", { lineHeight: "20px", fontWeight: "400" }],
                        "headline-md": ["20px", { lineHeight: "28px", letterSpacing: "-0.02em", fontWeight: "600" }],
                        "display": ["36px", { lineHeight: "40px", letterSpacing: "-0.04em", fontWeight: "600" }]
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        @layer base { html, body { margin: 0; padding: 0; } body { overscroll-behavior: none; } }
        ::-webkit-scrollbar { display: none; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    </style>

    @stack('custom-scripts')
</head>
<body class="bg-surface text-on-surface h-screen w-full flex overflow-hidden">
    <!-- Language Bar (floating top right) -->
    <div class="absolute top-0 right-0 w-full z-20">
        <div class="flex justify-end p-6">
            @yield('language-bar')
        </div>
    </div>

    <main class="flex w-full h-full">
        <!-- BEGIN: LeftBrandingSide -->
        <section class="hidden lg:flex lg:w-3/5 relative bg-gradient-to-br from-indigo-50 via-blue-100 to-indigo-100 flex-col justify-between p-12 overflow-hidden">
            <!-- Decorative background elements -->
            <div class="absolute inset-0 z-0 opacity-50 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-300 via-transparent to-transparent"></div>
            <!-- Top Logo Area -->
            <div class="z-10 flex items-center gap-2">
                @if($company_logo)
                    <img src="{{ $logo . '/' . $company_logo }}" class="h-12 w-auto object-contain" alt="{{ config('app.name', 'StoreGo') }}">
                @else
                    <div class="w-8 h-8 bg-primary rounded-md flex items-center justify-center shadow-md">
                        <svg fill="none" height="20" stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" x2="21" y1="6" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-gray-800">{{ config('app.name', 'StoreGo') }}</span>
                @endif
            </div>
            <!-- Bottom Content Area -->
            <div class="z-10 mt-auto pb-12">
                <h1 class="text-4xl lg:text-5xl font-bold leading-tight mb-8 max-w-lg text-gray-900">
                Join thousands of businesses scaling with {{ config('app.name', 'StoreGo') }}
                </h1>
                <div class="flex flex-col sm:flex-row gap-6 font-medium text-gray-700">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-green-500">check</span>
                        Fast Setup
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-green-500">check</span>
                        No Hidden Fees
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-green-500">check</span>
                        Dedicated Support
                    </div>
                </div>
            </div>
        </section>
        <!-- END: LeftBrandingSide -->

        <!-- BEGIN: RightFormSide -->
        <section class="w-full lg:w-2/5 bg-surface-container-lowest h-full flex flex-col items-center justify-center p-8 sm:p-12 lg:p-16 overflow-y-auto">
            <div class="w-full max-w-md mx-auto space-y-8">
                <!-- Mobile Logo (visible only on small screens) -->
                <div class="lg:hidden flex flex-col items-center justify-center gap-2 mb-8">
                    @if($company_logo)
                        <img src="{{ $logo . '/' . $company_logo }}" class="h-12 w-auto object-contain" alt="{{ config('app.name', 'StoreGo') }}">
                    @else
                        <div class="w-12 h-12 bg-primary rounded-lg flex items-center justify-center text-on-primary shadow-md">
                            <span class="material-symbols-outlined" style="font-size: 28px;">storefront</span>
                        </div>
                        <span class="text-2xl font-bold text-gray-800 tracking-tight">{{ config('app.name', 'StoreGo') }}</span>
                    @endif
                </div>

                @yield('content')

            </div>
        </section>
        <!-- END: RightFormSide -->
    </main>

</body>
</html>
