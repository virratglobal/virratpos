@php
    use App\Models\Utility;
    $logo  =  Utility::get_file('uploads/landing_page_image');
    $sup_logo  =  Utility::get_file('uploads/logo');
    $setting = \App\Models\Utility::colorset();
@endphp
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <title>{{ env('APP_NAME', 'VirratPOS') }}</title>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
    <meta name="description" content="Empowering global businesses with sophisticated, high-performance commerce solutions designed for scale and ambition." />
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{ env('APP_NAME', 'VirratPOS') }}">
    <meta property="og:description" content="Empowering global businesses with sophisticated, high-performance commerce solutions designed for scale and ambition.">

    <!-- Favicon icon -->
    <link rel="icon" href="{{ $sup_logo.'/favicon.png' . '?timestamp='. time() }}" type="image/x-icon" />

    <!-- Font CSS & Icons -->
    <link rel="stylesheet" href=" {{ asset('assets/fonts/tabler-icons.min.css')}}" />
    <link rel="stylesheet" href=" {{ asset('assets/fonts/feather.css')}}" />
    <link rel="stylesheet" href="  {{ asset('assets/fonts/fontawesome.css')}}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css')}}" />
    
    <!-- External Icon Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&family=Hanken+Grotesk:ital,wght@0,100..900;1,100..900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Caveat:wght@400..700&family=Shadows+Into+Light&family=Public+Sans:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        // Global Brand Colors (aligned with Elevate theme)
                        primary: "#0043c8",
                        "on-primary": "#ffffff",
                        "primary-container": "#0058ff",
                        "on-primary-container": "#e6e9ff",
                        background: "#faf9fa",
                        "on-background": "#1b1c1d",
                        surface: "#ffffff",
                        "on-surface": "#1b1c1d",
                        "surface-variant": "#e4e2e2",
                        "on-surface-variant": "#434656",
                        outline: "#737688",
                        "outline-variant": "#c3c5d9",
                        
                        // Elevation/Surface tiers
                        "surface-dim": "#dbd9d9",
                        "surface-bright": "#fbf9f8",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#f5f3f3",
                        "surface-container": "#f0eded",
                        "surface-container-high": "#eae8e7",
                        "surface-container-highest": "#e4e2e2",
                        
                        // Zoho specific colors
                        "brand-green": "#00D87B",
                        "brand-green-dark": "#008A52",
                        "brand-red": "#FF4500",
                        "brand-beige": "#F9F6ED",

                        // Support specific colors
                        brand: {
                            green: '#9ca3af',
                            dark: '#1a1c1e',
                            accent: '#e5e7eb',
                        },
                        
                        // Other standard tokens
                        secondary: "#5f5e5e",
                        "on-secondary": "#ffffff",
                        "secondary-container": "#e5e2e1",
                        "on-secondary-container": "#656464",
                        "secondary-fixed": "#e5e2e1",
                        "secondary-fixed-dim": "#c8c6c5",
                        "on-secondary-fixed": "#1c1b1b",
                        "on-secondary-fixed-variant": "#474646",
                        tertiary: "#4f5253",
                        "on-tertiary": "#ffffff",
                        "tertiary-container": "#686a6b",
                        "on-tertiary-container": "#e9ebec",
                        "tertiary-fixed": "#e1e3e4",
                        "tertiary-fixed-dim": "#c5c7c8",
                        "on-tertiary-fixed": "#191c1d",
                        "on-tertiary-fixed-variant": "#454748",
                        error: "#ba1a1a",
                        "on-error": "#ffffff",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                        "primary-fixed-dim": "#b6c4ff",
                        "inverse-primary": "#b6c4ff",
                        "inverse-surface": "#303030",
                        "inverse-on-surface": "#f2f0f0",
                        "on-primary-fixed": "#00164f",
                        "on-primary-fixed-variant": "#003bb1"
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        sm: "0.125rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        "2xl": "1rem",
                        "3xl": "1.5rem",
                        "4xl": "2rem",
                        full: "9999px"
                    },
                    spacing: {
                        xs: "0.25rem",
                        sm: "0.5rem",
                        md: "1rem",
                        lg: "1.5rem",
                        xl: "2.5rem",
                        xxl: "4rem",
                        "margin-mobile": "16px",
                        gutter: "24px",
                        "container-max": "1280px"
                    },
                    fontFamily: {
                        // Alexandria Font Config
                        headline: ["Noto Serif", "serif"],
                        display: ["Noto Serif", "serif"],
                        body: ["Noto Serif", "serif"],
                        label: ["Public Sans", "sans-serif"],
                        
                        // Elevate/Zoho Config
                        "headline-lg": ["Noto Serif", "serif"],
                        "headline-md": ["Noto Serif", "serif"],
                        "display-lg": ["Noto Serif", "serif"],
                        "display-lg-mobile": ["Noto Serif", "serif"],
                        "body-lg": ["Inter", "sans-serif"],
                        "body-md": ["Inter", "sans-serif"],
                        "body-sm": ["Inter", "sans-serif"],
                        "label-md": ["Inter", "sans-serif"],
                        
                        // Support Script config
                        script: ["Caveat", "cursive"],
                        handwritten: ["'Shadows Into Light'", "cursive"],
                        
                        // Fallback defaults
                        sans: ["Hanken Grotesk", "Inter", "sans-serif"]
                    },
                    fontSize: {
                        "display-lg": ["64px", { "lineHeight": "72px", "letterSpacing": "-0.02em", "fontWeight": "300" }],
                        "display-lg-mobile": ["40px", { "lineHeight": "48px", "letterSpacing": "-0.01em", "fontWeight": "300" }],
                        "headline-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "300" }],
                        "headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "300" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                        "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "body-sm": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "label-md": ["14px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600" }]
                    }
                }
            }
        }
    </script>

    <style data-purpose="custom-styles">
        .blue-container {
            background-color: #3366cc;
            border-radius: 40px;
        }
        
        .card-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .strikethrough-green {
            position: relative;
            display: inline-block;
            color: #008A52;
        }

        .strikethrough-green::after {
            content: '';
            position: absolute;
            left: -5%;
            top: 50%;
            width: 110%;
            height: 4px;
            background-color: #00D87B;
            transform: rotate(-2deg);
            z-index: 1;
        }

        .nav-toggle-bg {
            background-color: #666;
            background: linear-gradient(90deg, #666 0%, #666 66%, #00D87B 66%, #00D87B 100%);
        }

        /* Order cycle animation styles */
        .workflow-path {
            position: absolute;
            border-width: 2px;
            border-style: dashed;
            border-color: #c3c5d9;
            border-radius: 100px;
            z-index: 0;
            top: 20px;
            bottom: 20px;
            left: 20px;
            right: 20px;
        }
        @media (min-width: 768px) {
            .workflow-path {
                border-radius: 200px;
            }
        }
        @media (max-width: 767px) {
            .workflow-path {
                left: 50%;
                transform: translateX(-50%);
                width: 0;
                height: 100%;
                border-radius: 0;
                border-left-width: 2px;
                border-right-width: 0;
                border-top-width: 0;
                border-bottom-width: 0;
                top: 0;
                bottom: 0;
            }
        }

        .stage-icon {
            transition: all 0.5s ease;
        }

        .stage.active .stage-icon {
            transform: scale(1.1);
            background-color: #0043c8;
            color: #ffffff;
            box-shadow: 0 0 20px #0043c8;
        }

        .stage.active .stage-label {
            opacity: 1;
            font-weight: 700;
            color: #0043c8;
        }

        .stage-label {
            transition: all 0.5s ease;
            opacity: 0.6;
        }

        .order-dot {
            width: 16px;
            height: 16px;
            background-color: #0058ff;
            border-radius: 50%;
            position: absolute;
            box-shadow: 0 0 15px #0058ff;
            z-index: 10;
            offset-path: path('M 200 40 C 400 40 400 360 200 360 C 0 360 0 40 200 40');
            animation: moveDotDesktop 10.8s linear infinite;
        }

        @supports not (offset-path: path('M 0 0')) {
             .order-dot {
                animation: fallbackMoveDot 10.8s linear infinite;
             }
        }

        @media (max-width: 767px) {
            .order-dot {
                offset-path: none;
                left: 50%;
                transform: translateX(-50%);
                animation: moveDotMobile 10.8s linear infinite;
            }
        }

        @keyframes moveDotDesktop {
            0% { offset-distance: 0%; }
            100% { offset-distance: 100%; }
        }

        @keyframes fallbackMoveDot {
            0% { top: 0%; left: 50%; }
            25% { top: 50%; left: 100%; }
            50% { top: 100%; left: 50%; }
            75% { top: 50%; left: 0%; }
            100% { top: 0%; left: 50%; }
        }

        @keyframes moveDotMobile {
            0% { top: 0%; }
            100% { top: 100%; }
        }

        /* Scroll reveal effects */
        .reveal-up {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 800ms cubic-bezier(0.4, 0, 0.2, 1), transform 800ms cubic-bezier(0.4, 0, 0.2, 1);
            will-change: transform, opacity;
        }
        .reveal-up.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body class="bg-background text-on-background font-body antialiased min-h-screen flex flex-col">

    <!-- [ Header / Navigation ] start -->
    <nav class="flex items-center justify-between px-8 py-4 bg-surface border-b border-outline-variant/30 sticky top-0 z-50">
        <div class="flex items-center gap-10">
            <a class="text-xl font-bold font-headline tracking-tight text-on-surface" href="#home">{{ env('APP_NAME', 'VirratPOS') }}</a>
            <ul class="hidden md:flex items-center gap-6 text-[15px] font-medium text-on-surface-variant font-label">
                <li><a class="hover:text-primary transition-colors" href="#home">Home</a></li>
                <li><a class="hover:text-primary transition-colors" href="#features">Features</a></li>
                <li><a class="hover:text-primary transition-colors" href="#website-builder">Builder</a></li>
                <li><a class="hover:text-primary transition-colors" href="#marketing">Marketing</a></li>
                <li><a class="hover:text-primary transition-colors" href="#workflow">Workflow</a></li>
                <li><a class="hover:text-primary transition-colors" href="#templates">Templates</a></li>
                <li><a class="hover:text-primary transition-colors" href="#support">Support</a></li>
            </ul>
        </div>
        <div class="flex items-center gap-4 font-label">
            <a href="{{ route('login') }}" class="hidden sm:inline-block text-[15px] font-medium text-on-surface-variant hover:text-primary transition-colors">Login</a>
            <a href="{{ route('register') }}" class="bg-primary hover:bg-primary-container text-on-primary px-5 py-2 rounded-full font-medium transition-colors text-[14px] sm:text-[15px]">
                Create Your Store
            </a>
            <!-- Hamburger button -->
            <button id="mobile-menu-btn" class="md:hidden text-on-surface focus:outline-none" aria-label="Toggle Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path id="hamburger-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu panel -->
    <div id="mobile-menu" class="hidden md:hidden bg-surface border-b border-outline-variant/30 px-8 py-4 space-y-3 font-medium text-on-surface-variant font-label">
        <a class="block hover:text-primary transition-colors" href="#home">Home</a>
        <a class="block hover:text-primary transition-colors" href="#features">Features</a>
        <a class="block hover:text-primary transition-colors" href="#website-builder">Builder</a>
        <a class="block hover:text-primary transition-colors" href="#marketing">Marketing</a>
        <a class="block hover:text-primary transition-colors" href="#workflow">Workflow</a>
        <a class="block hover:text-primary transition-colors" href="#templates">Templates</a>
        <a class="block hover:text-primary transition-colors" href="#support">Support</a>
        <a class="block sm:hidden hover:text-primary transition-colors" href="{{ route('login') }}">Login</a>
    </div>
    <!-- [ Header / Navigation ] end -->

    <!-- Main Content Area composed from Sections -->
    <main class="flex-grow">

        <!-- SECTION 1: Hero Section (from alexandria_theme_premium_e_commerce_hero) -->
        <section id="home" class="pt-24 pb-16 px-4 flex flex-col items-center text-center bg-background">
            <h1 class="text-[40px] md:text-[64px] leading-[1.1] font-normal font-display mb-6 tracking-wider max-w-4xl mx-auto text-on-background" style="font-weight: 300;">
                Create an online store. Kickstart your success.
            </h1>
            <p class="text-[17px] text-on-surface-variant mb-10 max-w-2xl mx-auto leading-relaxed font-body">
                Build an online store that fits your vision. Customize the design, access all-in-one eComm solutions and hit the web ready to do business.
            </p>
            <div class="flex flex-col items-center mb-20 font-label">
                <a href="{{ route('register') }}" class="bg-primary hover:bg-primary-container text-on-primary px-10 py-4 rounded-full text-xl font-medium mb-3 transition-colors">
                    Create Your Store
                </a>
                <p class="text-sm text-on-surface-variant font-body">Start for free. No credit card required.</p>
            </div>
            
            <!-- UI Showcase Container -->
            <div class="blue-container w-full max-w-[1400px] p-6 md:p-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative overflow-hidden text-left">
                <!-- Cart Widget (Left) -->
                <div class="lg:col-span-3 card-glass rounded-xl p-6 text-on-primary h-[580px] flex flex-col font-body">
                    <h3 class="text-xl mb-4 font-medium font-headline">My Cart (1)</h3>
                    <div class="flex gap-4 mb-6">
                        <div class="w-20 h-24 bg-gray-200 rounded-lg overflow-hidden shrink-0">
                            <img alt="Flex-Band" class="w-full h-full object-cover" src="{{ asset('assets/images/flex-band-product.png') }}">
                        </div>
                        <div>
                            <h4 class="font-bold text-lg mb-1 font-headline">Flex-Band</h4>
                            <p class="text-sm opacity-90 mb-1">$45.00</p>
                            <p class="text-xs opacity-75 mb-3">Color: Orange</p>
                            <div class="relative inline-block text-xs">
                                <select class="bg-transparent border border-white/30 rounded px-2 py-1 text-xs text-on-primary [&>option]:text-on-surface">
                                    <option>1</option>
                                    <option>2</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button class="flex items-center gap-2 text-sm opacity-90 mb-8 hover:opacity-100 transition-opacity">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        Add a promo code
                    </button>
                    <div class="mt-auto space-y-3 text-sm border-t border-white/20 pt-4">
                        <div class="flex justify-between">
                            <span class="opacity-90">Subtotal</span>
                            <span>$45.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="opacity-90">Shipping <span class="text-xs opacity-75 ml-1">New Jersey</span></span>
                            <span>$8.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="opacity-90">Sales Tax</span>
                            <span>$7.00</span>
                        </div>
                        <div class="flex justify-between text-lg font-bold border-t border-white/20 pt-3 mt-3 font-headline">
                            <span>Total</span>
                            <span>$60.00</span>
                        </div>
                    </div>
                    <a href="{{ route('register') }}" class="w-full bg-transparent border border-white/40 hover:bg-white/10 text-on-primary rounded-lg py-3 mt-6 font-medium flex items-center justify-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        Checkout
                    </a>
                </div>
                <!-- Website Mockup (Center) -->
                <div class="lg:col-span-6 bg-surface rounded-t-xl rounded-b-xl overflow-hidden shadow-[0_25px_50px_-12px_rgba(51,102,204,0.4)] h-[580px] flex flex-col relative">
                    <div class="h-full w-full overflow-hidden bg-surface">
                        <img alt="Bharat Bazar Storefront" class="w-full h-full object-cover object-top" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCOdCqRY-OOeOWltcYQehF54PGiLVfXpTfpRXMqsnSHpU19sJrQgu-KEvlBSCreMK0M2MqBXYGODl8ne1YsFoiXrRaiFnGZcIJC_ukVQMxs64fxTHzJyq5CeIX5UCP2jFYR53vI_nrhKs9DBkMHBjw3tlF1irzIVw3J2Bl5ULCcxYGn1rITTcKExIKFkhLFB9QLO9HX03K8_wZQ9GPLc3OafHF0pXLAMx0d-1CoV48Ezy0Shn5eOJE0svieF0uClOpNuXE">
                    </div>
                </div>
                <!-- Analytics & Info (Right) -->
                <div class="lg:col-span-3 h-[580px] flex flex-col gap-6 font-body">
                    <!-- Total Sales Card -->
                    <div class="card-glass rounded-xl p-5 text-on-primary">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-xs opacity-80 mb-1 uppercase tracking-wider font-label">Total Sales</p>
                                <h3 class="text-3xl font-bold font-headline">₹4,82,900</h3>
                            </div>
                            <div class="bg-tertiary-container text-on-tertiary-container text-[10px] font-bold px-2 py-1 rounded-full">+24%</div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between text-xs">
                                <span class="opacity-70">Menswear</span>
                                <span>₹2,10,000</span>
                            </div>
                            <div class="w-full bg-white/10 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-white h-full w-[45%]"></div>
                            </div>
                            <div class="flex justify-between text-xs">
                                <span class="opacity-70">Accessories</span>
                                <span>₹1,42,000</span>
                            </div>
                            <div class="w-full bg-white/10 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-white h-full w-[30%]"></div>
                            </div>
                        </div>
                    </div>
                    <!-- New Orders Card -->
                    <div class="card-glass rounded-xl p-5 text-on-primary flex-1 flex flex-col">
                        <div class="mb-6">
                            <p class="text-xs opacity-80 mb-1 uppercase tracking-wider font-label">New Orders</p>
                            <h3 class="text-3xl font-bold font-headline">1,240</h3>
                        </div>
                        <div class="flex-1 relative flex items-end mb-4">
                            <svg class="w-full h-24" preserveAspectRatio="none" viewBox="0 0 100 40">
                                <path d="M0,35 Q15,30 25,35 T50,15 T75,25 T100,5" fill="none" stroke="white" stroke-linecap="round" stroke-width="2"></path>
                                <path d="M0,35 Q15,30 25,35 T50,15 T75,25 T100,5 V40 H0 Z" fill="url(#gradient)" opacity="0.2"></path>
                                <defs>
                                    <linearGradient id="gradient" x1="0%" x2="0%" y1="0%" y2="100%">
                                        <stop offset="0%" style="stop-color:white;stop-opacity:1"></stop>
                                        <stop offset="100%" style="stop-color:white;stop-opacity:0"></stop>
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                        <div class="pt-4 border-t border-white/20 flex justify-between items-center text-xs">
                            <span class="opacity-70">Avg. Order Value</span>
                            <span class="font-bold">₹3,894</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 2: Feature Showcase (from premium_e_commerce_feature_showcase) -->
        <section id="features" class="py-20 bg-surface border-t border-outline-variant/20">
            <!-- Header Section -->
            <div class="py-12 px-gutter max-w-container-max mx-auto text-center reveal-up">
                <span class="inline-block py-1 px-3 bg-surface-container-low text-on-surface-variant font-label-md rounded-full mb-md tracking-wider text-xs uppercase">PLATFORM</span>
                <h2 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-lg max-w-4xl mx-auto leading-tight">
                    Everything you need to start, run and grow your online store.
                </h2>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                    A seamless, unified platform designed for modern brands seeking effortless sophistication and total control.
                </p>
            </div>
            
            <!-- Features Grid -->
            <div class="pb-16 px-gutter max-w-container-max mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-xl">
                    <!-- Feature 1 -->
                    <div class="flex flex-col bg-surface-container-lowest rounded-xl border border-outline-variant/30 overflow-hidden shadow-[0px_10px_40px_rgba(0,0,0,0.04)] hover:shadow-[0px_14px_50px_rgba(0,0,0,0.08)] transition-all duration-300 reveal-up">
                        <div class="w-full h-64 bg-surface-container-low overflow-hidden p-2">
                            <img alt="Create your store visual" class="w-full h-full object-cover rounded-lg border border-outline-variant/20 shadow-sm transition-transform duration-500 hover:scale-105" src="{{ asset('assets/images/create-store-visual.png') }}">
                        </div>
                        <div class="p-6 flex flex-col gap-2 flex-grow">
                            <h3 class="font-headline-md text-headline-md text-on-surface">Create your store</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant">Build a professional online store without coding. Choose a theme, add your branding and go live in minutes.</p>
                        </div>
                    </div>
                    <!-- Feature 2 -->
                    <div class="flex flex-col bg-surface-container-lowest rounded-xl border border-outline-variant/30 overflow-hidden shadow-[0px_10px_40px_rgba(0,0,0,0.04)] hover:shadow-[0px_14px_50px_rgba(0,0,0,0.08)] transition-all duration-300 reveal-up">
                        <div class="w-full h-64 bg-surface-container-low overflow-hidden p-2">
                            <img alt="Manage products visual" class="w-full h-full object-cover rounded-lg border border-outline-variant/20 shadow-sm transition-transform duration-500 hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDfbSiODRbUOz1XumbjrGPqm7n1lssYa0F9cas3r7SZ67QnQkuNquOVSjzC_uLN-i2Gm_DLhYlokjI45jnXiL6bbPXkjIzf3emfMjgYi3oIaCLCe5tTsK1MOtcarHyvqxDLKKpi8zDFLjtT_CXNjdAlFBbHMqrdH3kLTXfNDHg3O3IIIrhQSmXNMyypdVmMtazXkekLLh92LAU_pS4kS4RTEc4Yj70CcE-Mfkj-7lQUgdCDhf_E4oYqbw">
                        </div>
                        <div class="p-6 flex flex-col gap-2 flex-grow">
                            <h3 class="font-headline-md text-headline-md text-on-surface">Manage products</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant">Add products, images, prices, variants and inventory from one simple dashboard.</p>
                        </div>
                    </div>
                    <!-- Feature 3 -->
                    <div class="flex flex-col bg-surface-container-lowest rounded-xl border border-outline-variant/30 overflow-hidden shadow-[0px_10px_40px_rgba(0,0,0,0.04)] hover:shadow-[0px_14px_50px_rgba(0,0,0,0.08)] transition-all duration-300 reveal-up">
                        <div class="w-full h-64 bg-surface-container-low overflow-hidden p-2">
                            <img alt="Accept online payments visual" class="w-full h-full object-cover rounded-lg border border-outline-variant/20 shadow-sm transition-transform duration-500 hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuATT8gsiKks_ty_-wFAipC-nnf3CNR9m-dBTa0vC6Y8FnS6WsBOe0e4JFVO9W8aV9ebDvegKgJCVVJmwLJhJJ7v6y0lYPyI8AFwDsWM3TfFKwBtnqCL6rrrAaoUIJ5TaOOMk9qwYWcDkPUHWg21djT64CBJhQeiUmMxbtIgiiqexR-yHL30IEjpXbk1dl-BlNoOXKXMf7l_AOIFXxlbJpocOLil6rlP030aGrPb9jKpaQY7f7spaSE-sg">
                        </div>
                        <div class="p-6 flex flex-col gap-2 flex-grow">
                            <h3 class="font-headline-md text-headline-md text-on-surface">Accept online payments</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant">Let customers pay securely with multiple payment options.</p>
                        </div>
                    </div>
                    <!-- Feature 4 -->
                    <div class="flex flex-col bg-surface-container-lowest rounded-xl border border-outline-variant/30 overflow-hidden shadow-[0px_10px_40px_rgba(0,0,0,0.04)] hover:shadow-[0px_14px_50px_rgba(0,0,0,0.08)] transition-all duration-300 reveal-up">
                        <div class="w-full h-64 bg-surface-container-low overflow-hidden p-2">
                            <img alt="Manage orders visual" class="w-full h-full object-cover rounded-lg border border-outline-variant/20 shadow-sm transition-transform duration-500 hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAwnZIC4ImJTJvBSk2ortZMk5mfNaOWRrThbe-oX9oS9fHEUnh6CVglVhfoQ1-tKWkvbOm-N6CiaTuthqFVuJud-RzRFOodm4ubKxZpseuPTGnUk4i3hUEDNjArly2SKFFLTjjoyNnlNRPWMKVzb3QSUwbaRsAahWv68EL--zZUlo5U57LuL67WW3Uc75D0v53G65PzmnoQDxkglx4V9JKMHOJEAk5YAFxN9I5je9nep-Ft3FQnGKu5UQ">
                        </div>
                        <div class="p-6 flex flex-col gap-2 flex-grow">
                            <h3 class="font-headline-md text-headline-md text-on-surface">Manage orders</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant">Track new orders, update order statuses and manage fulfilment from one place.</p>
                        </div>
                    </div>
                    <!-- Feature 5 -->
                    <div class="flex flex-col bg-surface-container-lowest rounded-xl border border-outline-variant/30 overflow-hidden shadow-[0px_10px_40px_rgba(0,0,0,0.04)] hover:shadow-[0px_14px_50px_rgba(0,0,0,0.08)] transition-all duration-300 reveal-up">
                        <div class="w-full h-64 bg-surface-container-low overflow-hidden p-2">
                            <img alt="Sell everywhere visual" class="w-full h-full object-cover rounded-lg border border-outline-variant/20 shadow-sm transition-transform duration-500 hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDeR0Sp9UKSPlw0-LQKvE52f3d7lcH8fK6l0bOm3JMwhVg8VufisEZJjklHIG2A0QlmHXTwbdCRrYHP4prLDQw1YJBbkQ_UjEhFltDc6vW1pQHpwYsbFAxzcpVQk789yFFr6-dex4AZsgJwo0fCsXIAtG-EfoiJu7dyIO11Lc8ISJrhj6-bQCUZwdAr7ZHw9a8tE66s1ruLxJE1lhoHot6QkmtE1PU_wCTx3OAqkulCGcmlZP_4q8sugw">
                        </div>
                        <div class="p-6 flex flex-col gap-2 flex-grow">
                            <h3 class="font-headline-md text-headline-md text-on-surface">Sell everywhere</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant">Share your store through links, social media and multiple sales channels.</p>
                        </div>
                    </div>
                    <!-- Feature 6 -->
                    <div class="flex flex-col bg-surface-container-lowest rounded-xl border border-outline-variant/30 overflow-hidden shadow-[0px_10px_40px_rgba(0,0,0,0.04)] hover:shadow-[0px_14px_50px_rgba(0,0,0,0.08)] transition-all duration-300 reveal-up">
                        <div class="w-full h-64 bg-surface-container-low overflow-hidden p-2">
                            <img alt="Track your business visual" class="w-full h-full object-cover rounded-lg border border-outline-variant/20 shadow-sm transition-transform duration-500 hover:scale-105" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAjuSX2OfiZB1SgN66lB-MKJL_1M8Vldmggs7uUetwBQuR3E6pX32LOPslOsbfc-tyfJcnRoi7QaomhRBNb7IBGedg_7fRm63Q74vXJ_kVdJgUUblnLHpTmi1GEeS-WSmgs2OvRUTcHeVUucM-cDwcLUORKoZ7SVSiWTaB9K9HXI6WV6XmsXXyixZcTBexcaI63uIjhsZXZnyevyKTgfYQlGYZ1a6RD8tkVDxqf_B-4rLF0hCfIFvlnBw">
                        </div>
                        <div class="p-6 flex flex-col gap-2 flex-grow">
                            <h3 class="font-headline-md text-headline-md text-on-surface">Track your business</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant">Monitor sales, orders, products and store performance from one dashboard.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 2b: Autoplay Synchronized Video Showcase -->
        <section id="video-showcase" class="py-12 md:py-16 bg-white border-t border-zinc-100 relative overflow-hidden">
            <div class="w-full max-w-[1200px] mx-auto px-4 md:px-6">

                <!-- Header -->
                <div class="text-center mb-8 md:mb-10">
                    <span class="inline-block text-xs font-semibold tracking-[0.2em] uppercase text-emerald-600 mb-3 font-mono">Product Tour</span>
                    <h2 class="text-3xl md:text-5xl text-zinc-900 tracking-tight leading-[1.1] mb-4 font-display-lg">Everything your store needs,<br class="hidden sm:inline"/> working together.</h2>
                    <p class="text-zinc-500 text-base md:text-lg max-w-xl mx-auto font-sans font-light leading-relaxed">From beautiful storefronts to seamless checkout — see how every piece fits.</p>
                </div>

                <!-- Video Container -->
                <div id="vs-video-container" class="relative w-full rounded-2xl overflow-hidden bg-zinc-100 shadow-[0_20px_60px_rgba(0,0,0,0.08)] border border-zinc-200/60" style="aspect-ratio: 1900 / 900;">
                    <video id="vs-vid-0" class="absolute inset-0 w-full h-full object-contain object-center transition-opacity duration-700 ease-in-out opacity-0" style="transform: scaleX(1.03);" muted playsinline preload="auto" src="{{ asset('assets/videos/web1.mp4') }}"></video>
                    <video id="vs-vid-1" class="absolute inset-0 w-full h-full object-contain object-center transition-opacity duration-700 ease-in-out opacity-0" style="transform: scaleX(1.03);" muted playsinline preload="metadata" src="{{ asset('assets/videos/web2.mp4') }}"></video>
                    <video id="vs-vid-2" class="absolute inset-0 w-full h-full object-contain object-center transition-opacity duration-700 ease-in-out opacity-0" style="transform: scaleX(1.03);" muted playsinline preload="metadata" src="{{ asset('assets/videos/web3.mp4') }}"></video>
                    <video id="vs-vid-3" class="absolute inset-0 w-full h-full object-contain object-center transition-opacity duration-700 ease-in-out opacity-0" style="transform: scaleX(1.03);" muted playsinline preload="metadata" src="{{ asset('assets/videos/web4.mp4') }}"></video>
                </div>

                <!-- Active Step Styles -->
                <style>
                    .vs-step {
                        position: relative;
                        padding: 16px 14px 14px;
                        border-radius: 12px;
                        transition: transform 350ms cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 350ms ease;
                        transform: translateY(0) scale(1);
                        will-change: transform;
                    }
                    .vs-step::before {
                        content: '';
                        position: absolute;
                        inset: -8px;
                        border-radius: 16px;
                        background: radial-gradient(circle at 50% 50%, rgba(16,185,129,0.0), transparent 70%);
                        transition: background 350ms ease, opacity 350ms ease;
                        opacity: 0;
                        pointer-events: none;
                        z-index: -1;
                    }
                    .vs-step-active {
                        transform: translateY(-5px) scale(1.015);
                    }
                    .vs-step-active::before {
                        background: radial-gradient(circle at 50% 50%, rgba(16,185,129,0.13), transparent 70%);
                        opacity: 1;
                    }
                    .vs-step-num {
                        transition: opacity 350ms ease, font-weight 350ms ease;
                    }
                    .vs-step-title {
                        transition: color 350ms ease !important;
                    }
                    .vs-step-desc {
                        transition: color 350ms ease, opacity 350ms ease !important;
                    }
                    .vs-progress {
                        box-shadow: none;
                        transition: box-shadow 350ms ease;
                    }
                    .vs-step-active .vs-progress {
                        box-shadow: 0 0 8px 1px rgba(16,185,129,0.35), 0 0 3px 0 rgba(16,185,129,0.25);
                    }
                </style>

                <!-- Feature Steps -->
                <div id="vs-steps" class="mt-6 md:mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">

                    <!-- Step 0 -->
                    <div class="vs-step group cursor-pointer select-none" data-index="0">
                        <div class="flex items-baseline gap-2 mb-1.5">
                            <span class="vs-step-num text-[11px] font-mono font-semibold text-emerald-600 tracking-wider" style="opacity:0.5;">01</span>
                        </div>
                        <h3 class="vs-step-title text-base md:text-lg font-semibold text-zinc-400 mb-1.5 leading-snug">Powerful Store Builder</h3>
                        <p class="vs-step-desc text-[13px] md:text-sm text-zinc-300 leading-relaxed mb-4" style="opacity:0.7;">Create and customize your storefront with beautiful themes — no coding required.</p>
                        <div class="w-full h-[3px] bg-zinc-200/80 rounded-full overflow-hidden">
                            <div class="vs-progress h-full bg-emerald-500 rounded-full" style="width:100%; transform-origin:left center; transform:scaleX(0);"></div>
                        </div>
                    </div>

                    <!-- Step 1 -->
                    <div class="vs-step group cursor-pointer select-none" data-index="1">
                        <div class="flex items-baseline gap-2 mb-1.5">
                            <span class="vs-step-num text-[11px] font-mono font-semibold text-emerald-600 tracking-wider" style="opacity:0.5;">02</span>
                        </div>
                        <h3 class="vs-step-title text-base md:text-lg font-semibold text-zinc-400 mb-1.5 leading-snug">Launch with Zero Code</h3>
                        <p class="vs-step-desc text-[13px] md:text-sm text-zinc-300 leading-relaxed mb-4" style="opacity:0.7;">Save time and costs — confidently run your online store from day one.</p>
                        <div class="w-full h-[3px] bg-zinc-200/80 rounded-full overflow-hidden">
                            <div class="vs-progress h-full bg-emerald-500 rounded-full" style="width:100%; transform-origin:left center; transform:scaleX(0);"></div>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="vs-step group cursor-pointer select-none" data-index="2">
                        <div class="flex items-baseline gap-2 mb-1.5">
                            <span class="vs-step-num text-[11px] font-mono font-semibold text-emerald-600 tracking-wider" style="opacity:0.5;">03</span>
                        </div>
                        <h3 class="vs-step-title text-base md:text-lg font-semibold text-zinc-400 mb-1.5 leading-snug">Customize, Start to Finish</h3>
                        <p class="vs-step-desc text-[13px] md:text-sm text-zinc-300 leading-relaxed mb-4" style="opacity:0.7;">Show your buyers how easy and secure it is to shop from your store.</p>
                        <div class="w-full h-[3px] bg-zinc-200/80 rounded-full overflow-hidden">
                            <div class="vs-progress h-full bg-emerald-500 rounded-full" style="width:100%; transform-origin:left center; transform:scaleX(0);"></div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="vs-step group cursor-pointer select-none" data-index="3">
                        <div class="flex items-baseline gap-2 mb-1.5">
                            <span class="vs-step-num text-[11px] font-mono font-semibold text-emerald-600 tracking-wider" style="opacity:0.5;">04</span>
                        </div>
                        <h3 class="vs-step-title text-base md:text-lg font-semibold text-zinc-400 mb-1.5 leading-snug">Curate Pretty Displays</h3>
                        <p class="vs-step-desc text-[13px] md:text-sm text-zinc-300 leading-relaxed mb-4" style="opacity:0.7;">Thoughtfully list, categorize, and add your products to stunning collections.</p>
                        <div class="w-full h-[3px] bg-zinc-200/80 rounded-full overflow-hidden">
                            <div class="vs-progress h-full bg-emerald-500 rounded-full" style="width:100%; transform-origin:left center; transform:scaleX(0);"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Video Showcase Script -->
            <script>
                (function() {
                    const TOTAL = 4;
                    let activeIndex = 0;
                    let isVisible = false;
                    let hasStarted = false;
                    let rafId = null;

                    const videos = [];
                    const steps = document.querySelectorAll('.vs-step');
                    const progressBars = document.querySelectorAll('.vs-progress');

                    for (let i = 0; i < TOTAL; i++) {
                        videos.push(document.getElementById('vs-vid-' + i));
                        // Init progress bars for scaleX approach
                        progressBars[i].style.width = '100%';
                        progressBars[i].style.transformOrigin = 'left center';
                        progressBars[i].style.transform = 'scaleX(0)';
                    }

                    // --- rAF progress loop ---
                    function startProgressLoop() {
                        cancelAnimationFrame(rafId);
                        function tick() {
                            var vid = videos[activeIndex];
                            if (vid && vid.duration && vid.duration > 0 && !vid.paused) {
                                var pct = vid.currentTime / vid.duration;
                                progressBars[activeIndex].style.transform = 'scaleX(' + Math.min(pct, 1) + ')';
                            }
                            rafId = requestAnimationFrame(tick);
                        }
                        rafId = requestAnimationFrame(tick);
                    }

                    function stopProgressLoop() {
                        cancelAnimationFrame(rafId);
                        rafId = null;
                    }

                    // --- Activate a step ---
                    function activateStep(index) {
                        stopProgressLoop();
                        activeIndex = index;

                        for (let i = 0; i < TOTAL; i++) {
                            const vid = videos[i];
                            const step = steps[i];
                            const bar = progressBars[i];

                            if (i === index) {
                                // Activate video
                                vid.style.opacity = '1';
                                vid.currentTime = 0;
                                vid.play().catch(function() {});

                                // Activate card: lift + glow
                                step.classList.add('vs-step-active');
                                step.querySelector('.vs-step-title').style.color = '#18181b';
                                step.querySelector('.vs-step-desc').style.color = '#71717a';
                                step.querySelector('.vs-step-desc').style.opacity = '1';
                                step.querySelector('.vs-step-num').style.opacity = '1';

                                // Progress starts at 0
                                bar.style.transform = 'scaleX(0)';
                            } else {
                                // Deactivate video
                                vid.pause();
                                vid.currentTime = 0;
                                vid.style.opacity = '0';

                                // Deactivate card: remove lift + glow
                                step.classList.remove('vs-step-active');
                                step.querySelector('.vs-step-title').style.color = '#a1a1aa';
                                step.querySelector('.vs-step-desc').style.color = '#d4d4d8';
                                step.querySelector('.vs-step-desc').style.opacity = '0.7';
                                step.querySelector('.vs-step-num').style.opacity = '0.5';

                                // Reset progress
                                bar.style.transform = 'scaleX(0)';
                            }
                        }

                        startProgressLoop();
                    }

                    // --- ended: advance to next ---
                    for (let i = 0; i < TOTAL; i++) {
                        videos[i].addEventListener('ended', function() {
                            if (i !== activeIndex) return;
                            stopProgressLoop();
                            progressBars[i].style.transform = 'scaleX(1)';
                            setTimeout(function() {
                                var next = (activeIndex + 1) % TOTAL;
                                activateStep(next);
                            }, 120);
                        });
                    }

                    // --- Click handling ---
                    steps.forEach(function(step, idx) {
                        step.addEventListener('click', function() {
                            if (idx === activeIndex) return;
                            activateStep(idx);
                        });
                    });

                    // --- Keyboard accessibility ---
                    steps.forEach(function(step, idx) {
                        step.setAttribute('tabindex', '0');
                        step.setAttribute('role', 'button');
                        step.addEventListener('keydown', function(e) {
                            if (e.key === 'Enter' || e.key === ' ') {
                                e.preventDefault();
                                if (idx !== activeIndex) activateStep(idx);
                            }
                        });
                    });

                    // --- Visibility: start/pause ---
                    var section = document.getElementById('video-showcase');
                    if (section && 'IntersectionObserver' in window) {
                        var obs = new IntersectionObserver(function(entries) {
                            entries.forEach(function(entry) {
                                if (entry.isIntersecting) {
                                    isVisible = true;
                                    if (!hasStarted) {
                                        hasStarted = true;
                                        activateStep(0);
                                    } else {
                                        var vid = videos[activeIndex];
                                        if (vid.paused && vid.currentTime < vid.duration) {
                                            vid.play().catch(function() {});
                                        }
                                        startProgressLoop();
                                    }
                                } else {
                                    isVisible = false;
                                    stopProgressLoop();
                                    videos[activeIndex].pause();
                                }
                            });
                        }, { threshold: 0.15 });
                        obs.observe(section);
                    } else {
                        hasStarted = true;
                        activateStep(0);
                    }

                    // --- prefers-reduced-motion ---
                    if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
                        videos.forEach(function(v) {
                            v.style.transition = 'none';
                        });
                    }
                })();
            </script>
        </section>

        <!-- SECTION 3: Ecommerce Website Builder (from ecommerce_website_builder_showcase) -->
        <section id="website-builder" class="py-20 bg-[#faf9fa] border-t border-outline-variant/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Header -->
                <div class="text-center mb-16 reveal-up">
                    <h2 class="text-4xl md:text-[44px] leading-tight mb-4 tracking-tight font-headline-lg">
                        Build a powerful ecommerce website<br/>for your online store
                    </h2>
                    <p class="text-lg md:text-xl text-gray-700 font-body">
                        Add ecommerce to any website on the web (literally).
                    </p>
                </div>
                <!-- Grid Content -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 font-body">
                    <!-- Left Module - Create Website -->
                    <div class="bg-[#f5f3f3] rounded-3xl overflow-hidden flex flex-col border border-outline-variant/10 shadow-sm hover:shadow-md transition-shadow duration-300 reveal-up">
                        <!-- Mockup Image Area -->
                        <div class="bg-[#1a1b1e] p-6 pt-10 flex justify-center items-end relative overflow-hidden h-[400px]">
                            <img alt="Ecommerce interface preview" class="w-[90%] max-w-[500px] object-cover object-top rounded-t-2xl shadow-2xl absolute bottom-0 translate-y-12 transition-transform duration-500 hover:translate-y-4" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBK_jbgbGhMHW6hot61UHBGAbKGnmAwJoz5UMVd9NmdeZvpH23xynX6XOSNXL4erMzMtXqklsthKC0VDKESTsz15vsF-fey5MFqDF8SUTfpphe3ZkT9eWC1aOzE7u4UV2PIeCBAOARa-QUEbqEjeUi6iY_wIQPE174ynleTgmCxZNxhQkkNJfUYP0ZNTNMNGBcXJXapfJ6WtI5nE6jFAC3es6m8_ji6E0uP31hP8mWkizux-msKNkb3JY8dZRtv0rjJZ0M">
                        </div>
                        <!-- Content Area -->
                        <div class="p-10 flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="text-2xl font-bold mb-4 font-headline-md">Create your own website</h3>
                                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                                    With a built-in ecommerce website builder, you can create your very own, unique website. Select a <a class="text-primary font-medium hover:underline" href="#templates">design</a> from ready-made <a class="text-primary font-medium hover:underline" href="#templates">ecommerce templates</a> and get your business up and running.
                                </p>
                            </div>
                            <div class="flex items-center space-x-6 font-label">
                                <a class="bg-[#2c2d30] hover:bg-black text-white px-8 py-3.5 rounded-lg font-medium transition-colors" href="{{ route('register') }}">
                                    Get started
                                </a>
                                <a class="flex items-center text-gray-900 font-medium hover:text-gray-600 transition-colors group" href="#templates">
                                    Learn more
                                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- Right Module - Add Ecommerce -->
                    <div class="bg-[#f5f3f3] rounded-3xl overflow-hidden flex flex-col border border-outline-variant/10 shadow-sm hover:shadow-md transition-shadow duration-300 reveal-up">
                        <!-- Mockup Image Area -->
                        <div class="bg-[#1a1b1e] p-6 pt-10 flex justify-center items-center relative overflow-hidden h-[400px]">
                            <img alt="Add ecommerce to any website" class="w-[90%] max-w-[500px] object-cover rounded-2xl shadow-2xl transition-transform duration-500 hover:scale-105 scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCc7buVVI181vnlUmnY_BHYPW0NWN00TYpxaMfSid6mIwZar4HLp2jUFuA1oY-HCKigI4qEel8g_raSUluautq2yxoY9VtW6o7b5Jccr6hGyPXDMD5kkLcO_zh3YrcuKILLj5DMhINp4X6P5tKEMeu3qtcXvZf3eFQrCWFL9WrDHWHa3ym8D6YXcfruFD4t9khN2xx6sifmWJrYWlIVxbeCWtDX027kdmnOP8bsfV0Mq6mYESEaK4iwtj7_u5cjdltAUYs">
                        </div>
                        <!-- Content Area -->
                        <div class="p-10 flex-grow flex flex-col justify-between">
                            <div>
                                <h3 class="text-2xl font-bold mb-4 font-headline-md">Add ecommerce to any website</h3>
                                <p class="text-gray-600 text-lg leading-relaxed mb-8">
                                    Already have a website? Transform it into an <a class="text-primary font-medium hover:underline" href="{{ route('register') }}">ecommerce website</a> in no time. Just add your online store directly to your existing site, and it will automatically blend with your website's look and feel.
                                </p>
                            </div>
                            <div class="flex items-center space-x-6 font-label">
                                <a class="bg-[#2c2d30] hover:bg-black text-white px-8 py-3.5 rounded-lg font-medium transition-colors" href="{{ route('register') }}">
                                    Get started
                                </a>
                                <a class="flex items-center text-gray-900 font-medium hover:text-gray-600 transition-colors group" href="#features">
                                    Learn more
                                    <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 4: Marketing Bento Grid (from zoho_commerce_market_hero_section) -->
        <section id="marketing" class="py-20 bg-surface border-t border-outline-variant/20">
            <div class="max-w-container-max mx-auto px-gutter">
                <!-- Header Section -->
                <div class="mb-16 relative reveal-up">
                    <h2 class="font-display-lg text-display-lg-mobile md:text-display-lg max-w-4xl tracking-tight leading-tight text-on-surface">
                        Tools to find your <br>
                        <span class="strikethrough-green font-bold">buyers</span> loyal fan-base.
                    </h2>
                </div>
                <!-- Bento Grid -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                    <!-- Top Left: SEO -->
                    <div class="bg-brand-beige md:col-span-5 rounded-xl p-6 md:p-10 flex flex-col justify-between relative overflow-hidden group shadow-sm border border-outline-variant/10 reveal-up">
                        <div class="z-10 relative max-w-[85%]">
                            <span class="text-brand-red font-label-md text-[12px] uppercase tracking-wider mb-4 block">SEO</span>
                            <h3 class="font-headline-lg text-headline-md md:text-headline-lg mb-4 text-black font-semibold">Be the first store <br>in search</h3>
                            <p class="font-body-lg text-sm md:text-base text-on-surface-variant">The built-in and extensible SEO tools ensures your store is found first when a shopper is looking to make a purchase.</p>
                        </div>
                        <div class="absolute right-0 bottom-6 w-1/3 max-w-[200px] z-0 pointer-events-none">
                            <img class="w-full h-auto object-contain" alt="SEO illustration" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCOiqA2f1S7nRvHNzhODTzXO5EekJpp3ttmdgNYpmEtZsQjbd8ZkEqF-buJOHyF2xhNrTpibK77Qwr-6RTbQdPP5HL72IKPmp-ygm0RuP0qzDv1YObhDGPRcsqHod2mTVSjtZ1FmMDhdgG2vkH2BuPl3ZjliW7QjXMU2JByiFGBlhhF61ZD1Ic2wPniq9HnafnUzVjLgqQ1M_gqoAdrSwNxNP9FvZJ0ID-3D8tJOtSH75JIBJdT6-rL9g">
                        </div>
                    </div>
                    <!-- Top Right: Social Selling -->
                    <div class="bg-[#faf9fa] md:col-span-7 border border-outline-variant/30 rounded-xl p-6 md:p-10 flex flex-col justify-between relative overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300 reveal-up">
                        <div class="z-10 relative max-w-[65%]">
                            <span class="text-brand-red font-label-md text-[12px] uppercase tracking-wider mb-4 block">SOCIAL SELLING</span>
                            <h3 class="font-headline-lg text-headline-md md:text-headline-lg mb-4 text-black font-semibold">Make them buy where they browse</h3>
                            <p class="font-body-lg text-sm md:text-base text-on-surface-variant">Make it easier for your buyers to shop from you, regardless of what social platform they're on.</p>
                        </div>
                        <div class="absolute right-[-5%] bottom-6 w-1/2 max-w-[250px] z-0 pointer-events-none">
                            <img class="w-full h-auto object-contain" alt="Social Selling illustration" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAyZ0ZfdmqvVq10UqIt4s3kFCVNVUuy2ka1VP_9NA8Eh3rTQnu6kLRE_8FyRkmfHUi26S_zNsDRP2D5RXTPddJpgRgilDB7hvnHi5mfWdRiwHHLGRcNvllOQTqat9yTol8wYzXybKhyNpY8Q2R2-ETK7mi3GCL97s8I5ckUdPUEnc1LuScKakalDooSrPakdEMnYxe_bdL0BQ5-_f9WZQ7qSAv3pRVW5HmbsebHqR4vOkmql6bFagSH0g">
                        </div>
                    </div>
                    <!-- Bottom Left: Campaigns -->
                    <div class="bg-brand-green-dark md:col-span-7 rounded-xl p-6 md:p-10 flex flex-col justify-between relative overflow-hidden text-white shadow-sm reveal-up">
                        <div class="z-10 relative max-w-[65%]">
                            <span class="text-brand-green font-label-md text-[12px] uppercase tracking-wider mb-4 block opacity-90">CAMPAIGNS</span>
                            <h3 class="font-headline-lg text-headline-md md:text-headline-lg mb-4 text-white font-semibold">Get shoppers to the finish line</h3>
                            <p class="font-body-lg text-sm md:text-base text-white/90">Turn all your shoppers into buyers as you prompt them to finish their checkout line using effective campaigns and smart notifications.</p>
                        </div>
                        <div class="absolute right-5 bottom-5 w-1/3 max-w-[220px] z-0 pointer-events-none">
                            <img class="w-full h-auto object-contain" alt="Campaigns illustration" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDqXy4lJdeQv9MC9d40OrpSeCg41wqjF2oUERQiYJqGfgZUUmOu9rWT9FSINuArNq6FLSDrUUSqCLhBMa-qjy6oJBpqf4Ge_ArMlr2VbnKHvPrwWRnwUHCwTCIt9ZlBxqETzneT-u-q_nogliq98hL7cT32V4fFhqC0Oq1CPZOEXgUqEcByRympSKokrx1rLzYhY6Y7F3pEUb7ppSIAzhnOgcraKGtQUavyWS2TaUyYdElG8vbf6dqfcw">
                        </div>
                    </div>
                    <!-- Bottom Right: Visual -->
                    <div class="rounded-xl md:col-span-5 overflow-hidden relative min-h-[350px] shadow-sm border border-outline-variant/10 reveal-up">
                        <img class="absolute inset-0 w-full h-full object-cover" alt="Collaborative business team" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBsGoKEQcWeXqTJP6OkBZa9btVkSG5_v7v9IdlqL0RGRUk9iUeV40gEDM1CUIyk-vUt2NMlAyFyd2fTjKMUWdFzxb_bU-TxDJXosICnCJ_ne8HmoUJLrcBqSmVYLANsZF2_ikY8liKKRwQ5gUT7NCvCERlQlaYUoQVNqtNU5jLfJ0aHVAfauYiSB4gEJkK_sx1VczvdN2JD8xgoo-X5xH10gpY6znIQ8BNPlSzxx5RP2Az3G6mUL_aIvQ">
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 5: Global Scale (Cinematic 24/7 Commerce Globe) -->
        <section id="workflow" class="py-24 bg-[#faf9fa] border-t border-zinc-200/80 relative overflow-hidden flex flex-col items-center justify-center min-h-[700px] lg:min-h-[800px] text-zinc-900">
            <!-- Scoped Starfield background canvas (soft emerald dust) -->
            <canvas id="stars-canvas" class="absolute inset-0 w-full h-full pointer-events-none z-0"></canvas>

            <!-- Inline Styles for Section 5 -->
            <style>
                /* Pulsing green marker keyframes */
                @keyframes pulse-emerald {
                    0%, 100% {
                        box-shadow: 0 0 10px rgba(16, 185, 129, 0.2), 0 0 20px rgba(16, 185, 129, 0.1);
                        border-color: rgba(52, 211, 153, 0.3);
                    }
                    50% {
                        box-shadow: 0 0 18px rgba(16, 185, 129, 0.5), 0 0 30px rgba(16, 185, 129, 0.2);
                        border-color: rgba(52, 211, 153, 0.6);
                    }
                }
                .pulse-card {
                    animation: pulse-emerald 2s infinite ease-in-out;
                }
            </style>

            <div class="relative w-full max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center z-10">
                <!-- LEFT COLUMN: Animated Commerce Globe (~60% space) -->
                <div class="lg:col-span-7 flex flex-col items-center justify-center relative min-h-[500px] lg:min-h-[700px] overflow-visible w-full">
                    <!-- Radial background green glow centered on globe -->
                    <div class="absolute w-[350px] h-[350px] lg:w-[620px] lg:h-[620px] rounded-full bg-emerald-500/[0.06] blur-[80px] lg:blur-[140px] pointer-events-none z-0 left-1/2 top-1/2 -translate-y-1/2 -translate-x-1/2"></div>
                    
                    <!-- WebGL Globe Container & Overlay Elements -->
                    <div id="globe-wrapper" class="relative w-[330px] h-[330px] lg:w-[580px] lg:h-[580px] select-none flex items-center justify-center opacity-0 scale-95 transition-all duration-500 ease-out z-10">
                        
                        <!-- WebGL Canvas -->
                        <canvas id="cobe-canvas" class="w-full h-full block opacity-0 transition-opacity duration-500 cursor-grab relative z-10" style="aspect-ratio: 1 / 1;"></canvas>
                        
                        <!-- Center 24/7 Card Overlay -->
                        <div id="center-status-card" class="absolute z-20 w-[210px] lg:w-[230px] bg-white/90 backdrop-blur-xl border border-zinc-200/80 rounded-2xl p-5 shadow-[0_10px_35px_rgba(0,0,0,0.06)] flex flex-col items-center text-center select-none pointer-events-none transition-all duration-500 scale-90 opacity-0">
                            <div class="flex items-center gap-2 px-2 py-0.5 rounded bg-emerald-50 text-[9px] font-semibold text-emerald-600 border border-emerald-100 tracking-wider mb-1.5 font-mono">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_6px_rgba(16,185,129,0.6)]"></span>
                                YOUR STORE IS ALWAYS OPEN
                            </div>
                            <div class="text-6xl lg:text-7xl font-extrabold text-emerald-600 tracking-tighter font-sans my-0.5">24/7</div>
                            <div class="text-xs lg:text-sm font-semibold text-zinc-500 font-sans tracking-wide">Everywhere.</div>
                        </div>

                        <!-- FLOATING COMMERCE DATA CARDS -->
                        <!-- Card 1 (Top-Left: NY Order Alert) -->
                        <div id="card-1" class="absolute top-[8%] left-[-8%] md:left-[-12%] lg:left-[-16%] z-20 w-[170px] lg:w-[185px] bg-white/80 backdrop-blur-md border border-zinc-200/80 rounded-xl p-3 shadow-[0_8px_30px_rgba(0,0,0,0.04)] flex items-center gap-3 transition-all duration-700 opacity-0 translate-y-4">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0 shadow-[0_0_8px_rgba(16,185,129,0.06)]">
                                <span class="material-symbols-outlined text-[18px]">shopping_cart</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-[9px] font-semibold text-emerald-600 tracking-wider uppercase font-mono mb-0.5">Order received</div>
                                <div id="card-1-time" class="text-xs lg:text-sm font-bold text-zinc-900 font-sans leading-none">11:42 PM</div>
                                <div id="card-1-location" class="text-[10px] text-zinc-500 font-sans truncate">New York, USA</div>
                            </div>
                        </div>

                        <!-- Card 2 (Middle-Left: Total Sales Live counter) -->
                        <div id="card-2" class="hidden lg:flex absolute top-[43%] left-[-15%] lg:left-[-24%] z-20 w-[270px] bg-white/80 backdrop-blur-md border border-zinc-200/80 rounded-xl p-3 shadow-[0_8px_30px_rgba(0,0,0,0.04)] items-center gap-3 transition-all duration-700 opacity-0 translate-y-4">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0 shadow-[0_0_8px_rgba(16,185,129,0.06)]">
                                <span class="material-symbols-outlined text-[18px]">trending_up</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div id="card-2-value" class="text-base font-bold text-emerald-600 font-mono tracking-tight leading-none mb-1">₹74,158,082,002,254</div>
                                <div class="text-[9px] font-semibold text-zinc-400 tracking-wider uppercase font-mono">TOTAL SALES — AND COUNTING</div>
                            </div>
                        </div>

                        <!-- Card 3 (Bottom-Left: Cape Town Order Alert) -->
                        <div id="card-3" class="absolute bottom-[12%] left-[-6%] md:left-[-10%] lg:left-[-14%] z-20 w-[170px] lg:w-[185px] bg-white/80 backdrop-blur-md border border-zinc-200/80 rounded-xl p-3 shadow-[0_8px_30px_rgba(0,0,0,0.04)] flex items-center gap-3 transition-all duration-700 opacity-0 translate-y-4">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0 shadow-[0_0_8px_rgba(16,185,129,0.06)]">
                                <span class="material-symbols-outlined text-[18px]">inventory_2</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-[9px] font-semibold text-emerald-600 tracking-wider uppercase font-mono mb-0.5">Order received</div>
                                <div id="card-3-time" class="text-xs lg:text-sm font-bold text-zinc-900 font-sans leading-none">9:28 PM</div>
                                <div id="card-3-location" class="text-[10px] text-zinc-500 font-sans truncate">Cape Town, SA</div>
                            </div>
                        </div>

                        <!-- Card 4 (Top-Right: London Order Alert) -->
                        <div id="card-4" class="absolute top-[6%] right-[-8%] md:right-[-12%] lg:right-[-16%] z-20 w-[170px] lg:w-[185px] bg-white/80 backdrop-blur-md border border-zinc-200/80 rounded-xl p-3 shadow-[0_8px_30px_rgba(0,0,0,0.04)] flex items-center gap-3 transition-all duration-700 opacity-0 translate-y-4">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0 shadow-[0_0_8px_rgba(16,185,129,0.06)]">
                                <span class="material-symbols-outlined text-[18px]">shopping_bag</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-[9px] font-semibold text-emerald-600 tracking-wider uppercase font-mono mb-0.5">Order received</div>
                                <div id="card-4-time" class="text-xs lg:text-sm font-bold text-zinc-900 font-sans leading-none">6:27 AM</div>
                                <div id="card-4-location" class="text-[10px] text-zinc-500 font-sans truncate">London, UK</div>
                            </div>
                        </div>

                        <!-- Card 5 (Middle-Right: Sales Per Minute Peak) -->
                        <div id="card-5" class="hidden lg:flex absolute top-[44%] right-[-15%] lg:right-[-24%] z-20 w-[240px] bg-white/80 backdrop-blur-md border border-zinc-200/80 rounded-xl p-3 shadow-[0_8px_30px_rgba(0,0,0,0.04)] items-center gap-3 transition-all duration-700 opacity-0 translate-y-4">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0 shadow-[0_0_8px_rgba(16,185,129,0.06)]">
                                <span class="material-symbols-outlined text-[18px]">bolt</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-base font-bold text-emerald-600 font-sans tracking-tight leading-none mb-1">₹351,539,440</div>
                                <div class="text-[9px] font-semibold text-zinc-400 tracking-wider uppercase font-mono">SALES PER MINUTE AT PEAK</div>
                            </div>
                        </div>

                        <!-- Card 6 (Bottom-Right: Edge PoP statistics) -->
                        <div id="card-6" class="hidden lg:flex absolute bottom-[14%] right-[-10%] lg:right-[-14%] z-20 w-[210px] bg-white/80 backdrop-blur-md border border-zinc-200/80 rounded-xl p-3 shadow-[0_8px_30px_rgba(0,0,0,0.04)] items-center gap-3 transition-all duration-700 opacity-0 translate-y-4">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0 shadow-[0_0_8px_rgba(16,185,129,0.06)]">
                                <span class="material-symbols-outlined text-[18px]">language</span>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-bold text-zinc-900 font-sans leading-none mb-1">300 Edge Points</div>
                                <div class="text-[9px] font-semibold text-zinc-400 tracking-wider uppercase font-mono">INSTANT PAGE LOAD WORLDWIDE</div>
                            </div>
                        </div>
                    </div>

                    <!-- Subtle drag hint under the globe -->
                    <div id="drag-hint" class="absolute bottom-[3%] left-1/2 -translate-x-1/2 flex flex-col items-center gap-1 opacity-0 text-[9px] tracking-[0.25em] font-mono text-zinc-400 uppercase select-none z-20 pointer-events-none transition-all duration-1000 delay-[1200ms]">
                        <div class="flex items-center gap-2 text-zinc-500">
                            <span class="material-symbols-outlined text-[12px] animate-pulse">keyboard_double_arrow_left</span>
                            <span class="material-symbols-outlined text-[14px]">touch_gesture</span>
                            <span class="material-symbols-outlined text-[12px] animate-pulse">keyboard_double_arrow_right</span>
                        </div>
                        Drag to explore
                    </div>
                </div>

                <!-- RIGHT COLUMN: Pristine Typography Content (~40% space) -->
                <div id="text-column" class="lg:col-span-5 flex flex-col items-start gap-6 select-none pl-0 lg:pl-8 opacity-0 translate-y-8 transition-all duration-1000 ease-out z-10">
                    <!-- Live Online Status Pill -->
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-emerald-50 border border-emerald-200/60 rounded-full text-[10px] font-semibold text-emerald-600 uppercase tracking-widest font-mono shadow-[0_0_8px_rgba(16,185,129,0.04)]">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-ping"></span>
                        ● STORE ONLINE
                    </div>

                    <!-- Headline -->
                    <h1 class="text-5xl md:text-[68px] leading-[1.05] tracking-tighter text-zinc-900 font-sans font-extralight">
                        Always open.<br/>
                        <span class="text-emerald-600 font-light">Everywhere.</span>
                    </h1>

                    <!-- Supporting Paragraph -->
                    <p class="text-zinc-600 text-lg md:text-xl leading-relaxed max-w-sm font-sans font-light">
                        Your store keeps selling while customers shop around the world. Delivering fast, reliable experiences at every hour, from every continent.
                    </p>

                    <!-- Premium Minimal CTA Button -->
                    <a href="{{ route('register') }}" class="group mt-2 inline-flex items-center gap-3 bg-zinc-950 hover:bg-emerald-600 text-white px-7 py-4 rounded-full text-[14px] font-semibold transition-all duration-300 shadow-[0_4px_20px_rgba(0,0,0,0.05)] hover:shadow-[0_0_30px_rgba(16,185,129,0.15)] tracking-wide">
                        Explore Global Reach
                        <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Globe initialization & dynamic logic (cobe ESM module script) -->
            <script type="module">
                import createGlobe from '{{ asset('assets/js/cobe.js') }}';

                // 1. WebGL Globe setup
                const canvas = document.getElementById("cobe-canvas");
                if (canvas) {
                    let phi = 0;
                    let targetPhi = 0;
                    let pointerInteracting = null;
                    let width = 0;
                    let time = 0;

                    // Locations of active commerce cities
                    const baseMarkers = [
                        { location: [40.7128, -74.006], size: 0.04 },   // Index 0: New York
                        { location: [51.5074, -0.1278], size: 0.04 },   // Index 1: London
                        { location: [19.076, 72.8777], size: 0.04 },    // Index 2: Mumbai
                        { location: [-33.8688, 151.2093], size: 0.04 }, // Index 3: Sydney
                        { location: [-33.9249, 18.4241], size: 0.04 },  // Index 4: Cape Town
                        { location: [-23.5505, -46.6333], size: 0.04 }, // Index 5: São Paulo
                        { location: [35.6762, 139.6503], size: 0.04 },  // Index 6: Tokyo
                        { location: [25.2048, 55.2708], size: 0.04 },   // Index 7: Dubai
                    ];

                    let currentMarkers = baseMarkers.map(m => ({ ...m }));

                    // Resize handler — keeps globe responsive
                    const onResize = () => {
                        if (canvas) {
                            width = canvas.offsetWidth || canvas.parentElement?.offsetWidth || 500;
                            canvas.style.width = width + 'px';
                            canvas.style.height = width + 'px';
                        }
                    };
                    window.addEventListener("resize", onResize);

                    // Ensure width is always a positive value — re-read right before creating the globe
                    width = canvas.offsetWidth
                        || canvas.parentElement?.offsetWidth
                        || canvas.closest('[class*="col"]')?.offsetWidth
                        || 500;
                    canvas.style.width = width + 'px';
                    canvas.style.height = width + 'px';

                    const config = {
                        width: width * 2,
                        height: width * 2,
                        devicePixelRatio: 2,
                        phi: 0,
                        theta: 0.3,
                        dark: 0, // light background oceans
                        diffuse: 0.4,
                        mapSamples: 12000,
                        mapBrightness: 6, // high contrast for light mode dots
                        baseColor: [1, 1, 1], // white background sphere
                        markerColor: [0.06, 0.73, 0.4], // neon green pulsing markers
                        glowColor: [0.95, 0.95, 0.95], // soft light-gray atmospheric glow
                        markers: currentMarkers,
                        arcs: [
                            { from: [40.7128, -74.006], to: [51.5074, -0.1278] }, // NY -> London
                            { from: [19.076, 72.8777], to: [1.3521, 103.8198] },  // Mumbai -> Singapore
                            { from: [51.5074, -0.1278], to: [25.2048, 55.2708] },  // London -> Dubai
                            { from: [35.6762, 139.6503], to: [34.0522, -118.2437] },// Tokyo -> LA
                            { from: [-23.5505, -46.6333], to: [-33.9249, 18.4241] },// São Paulo -> Cape Town
                            { from: [-33.8688, 151.2093], to: [19.076, 72.8777] }   // Sydney -> Mumbai
                        ],
                        arcColor: [0.06, 0.73, 0.4], // glowing green connection lines
                        arcWidth: 1.5,
                        arcHeight: 0.3
                    };

                    let globe;
                    try {
                        globe = createGlobe(canvas, config);
                    } catch (e) {
                        console.error("COBE initialization error:", e);
                    }
                    
                    // Immediately reveal canvas and globe-wrapper (don't rely solely on IntersectionObserver)
                    setTimeout(() => {
                        canvas.style.opacity = "1";
                        const globeWrapper = document.getElementById("globe-wrapper");
                        if (globeWrapper) {
                            globeWrapper.style.opacity = "1";
                            globeWrapper.style.transform = "translateY(0) scale(1)";
                        }
                    }, 200);

                    // Drag Interactions
                    canvas.addEventListener("pointerdown", (e) => {
                        pointerInteracting = e.clientX;
                        canvas.style.cursor = "grabbing";
                    });
                    window.addEventListener("pointermove", (e) => {
                        if (pointerInteracting !== null) {
                            const delta = e.clientX - pointerInteracting;
                            targetPhi += delta / 220;
                            pointerInteracting = e.clientX;
                        }
                    });
                    window.addEventListener("pointerup", () => {
                        pointerInteracting = null;
                        canvas.style.cursor = "grab";
                    });
                    window.addEventListener("pointercancel", () => {
                        pointerInteracting = null;
                        canvas.style.cursor = "grab";
                    });

                    // Mobile Touch support
                    canvas.addEventListener("touchstart", (e) => {
                        if (e.touches[0]) {
                            pointerInteracting = e.touches[0].clientX;
                        }
                    });
                    window.addEventListener("touchmove", (e) => {
                        if (pointerInteracting !== null && e.touches[0]) {
                            const delta = e.touches[0].clientX - pointerInteracting;
                            targetPhi += delta / 220;
                            pointerInteracting = e.touches[0].clientX;
                        }
                    });
                    window.addEventListener("touchend", () => {
                        pointerInteracting = null;
                    });

                    // Animation Loop (60fps)
                    function animate() {
                        // 1. Rotation update
                        phi += (targetPhi - phi) * 0.08;
                        if (!pointerInteracting) {
                            targetPhi += 0.0035; // Auto-rotate speed
                        }

                        // 2. Nodding/Vertical tilt sway simulation using a sine wave
                        time += 1;
                        const theta = 0.3 + Math.sin(time / 150) * 0.05;

                        // 3. Pulse decay for markers
                        let markersChanged = false;
                        currentMarkers.forEach((m, idx) => {
                            const baseSize = baseMarkers[idx].size;
                            if (m.size > baseSize) {
                                m.size -= 0.005; // smooth decay
                                if (m.size < baseSize) m.size = baseSize;
                                markersChanged = true;
                            }
                        });

                        // 4. Update cobe
                        if (globe) {
                            const updatePayload = { phi: phi, theta: theta };
                            if (markersChanged) {
                                updatePayload.markers = currentMarkers;
                            }
                            globe.update(updatePayload);
                        }

                        requestAnimationFrame(animate);
                    }
                    animate();

                    // 3. Dynamic Order Cards update logic
                    const cities = [
                        { name: "New York, USA", markerIdx: 0, icon: "shopping_cart" },
                        { name: "London, UK", markerIdx: 1, icon: "shopping_bag" },
                        { name: "Mumbai, India", markerIdx: 2, icon: "bolt" },
                        { name: "Sydney, Australia", markerIdx: 3, icon: "shopping_cart" },
                        { name: "Cape Town, SA", markerIdx: 4, icon: "inventory_2" },
                        { name: "São Paulo, Brazil", markerIdx: 5, icon: "shopping_bag" },
                        { name: "Tokyo, Japan", markerIdx: 6, icon: "shopping_cart" },
                        { name: "Dubai, UAE", markerIdx: 7, icon: "shopping_bag" }
                    ];

                    const activeCards = [
                        { id: "card-1", element: document.getElementById("card-1") },
                        { id: "card-3", element: document.getElementById("card-3") },
                        { id: "card-4", element: document.getElementById("card-4") }
                    ];

                    let cardIndexCycle = 0;
                    setInterval(() => {
                        const activeCard = activeCards[cardIndexCycle];
                        const cardEl = activeCard.element;
                        if (!cardEl) return;

                        // Select a random city
                        const randomCity = cities[Math.floor(Math.random() * cities.length)];

                        // Generate a random local formatted time
                        const d = new Date();
                        let hours = d.getHours() + Math.floor(Math.random() * 8) - 4;
                        if (hours < 0) hours += 24;
                        if (hours >= 24) hours -= 24;
                        const minutes = Math.floor(Math.random() * 60);
                        const ampm = hours >= 12 ? 'PM' : 'AM';
                        const formattedHours = hours % 12 || 12;
                        const formattedMinutes = minutes < 10 ? '0' + minutes : minutes;
                        const timeString = `${formattedHours}:${formattedMinutes} ${ampm}`;

                        // Fade Card Out
                        cardEl.style.opacity = "0";
                        cardEl.style.transform = "translateY(8px) scale(0.95)";

                        setTimeout(() => {
                            // Update content
                            const timeEl = document.getElementById(`${activeCard.id}-time`);
                            const locationEl = document.getElementById(`${activeCard.id}-location`);
                            const iconEl = cardEl.querySelector(".material-symbols-outlined");

                            if (timeEl) timeEl.textContent = timeString;
                            if (locationEl) locationEl.textContent = randomCity.name;
                            if (iconEl) iconEl.textContent = randomCity.icon;

                            // Trigger flashing pulse node on the globe
                            currentMarkers[randomCity.markerIdx].size = 0.25;
                            if (globe) {
                                globe.update({ markers: currentMarkers });
                            }

                            // Fade Card In & add Pulse class
                            cardEl.style.opacity = "1";
                            cardEl.style.transform = "translateY(0) scale(1)";
                            cardEl.classList.add("pulse-card");
                            setTimeout(() => cardEl.classList.remove("pulse-card"), 1500);

                        }, 400);

                        // Increment cycle
                        cardIndexCycle = (cardIndexCycle + 1) % activeCards.length;

                    }, 3500);
                }

                // 4. Stars background drift animation (subtle green dust on white background)
                const starsCanvas = document.getElementById('stars-canvas');
                if (starsCanvas) {
                    const ctx = starsCanvas.getContext('2d');
                    let stars = [];
                    
                    const resize = () => {
                        if (starsCanvas && starsCanvas.parentElement) {
                            starsCanvas.width = starsCanvas.parentElement.clientWidth;
                            starsCanvas.height = starsCanvas.parentElement.clientHeight;
                        }
                    };
                    window.addEventListener('resize', resize);
                    resize();

                    // Initialize stars
                    for (let i = 0; i < 65; i++) {
                        stars.push({
                            x: Math.random() * starsCanvas.width,
                            y: Math.random() * starsCanvas.height,
                            r: Math.random() * 0.9 + 0.3,
                            alpha: Math.random() * 0.4 + 0.15,
                            speed: Math.random() * 0.04 + 0.01,
                            glowSpeed: Math.random() * 0.015 + 0.005,
                            glowPhase: Math.random() * Math.PI
                        });
                    }

                    const animate = () => {
                        ctx.clearRect(0, 0, starsCanvas.width, starsCanvas.height);
                        for (let s of stars) {
                            s.x -= s.speed;
                            if (s.x < 0) s.x = starsCanvas.width;
                            
                            s.glowPhase += s.glowSpeed;
                            const alpha = s.alpha + Math.sin(s.glowPhase) * 0.15;

                            ctx.beginPath();
                            ctx.arc(s.x, s.y, s.r, 0, Math.PI * 2);
                            ctx.fillStyle = `rgba(16, 185, 129, ${Math.max(0.03, Math.min(1, alpha * 0.35))})`;
                            ctx.fill();
                        }
                        requestAnimationFrame(animate);
                    };
                    requestAnimationFrame(animate);
                }

                // 5. Real-time Total Sales Counter Incrementer
                let salesValue = 74158082002254;
                const salesValEl = document.getElementById("card-2-value");
                if (salesValEl) {
                    setInterval(() => {
                        // Add a random increment representing live global sales
                        salesValue += Math.floor(Math.random() * 75000) + 15000;
                        
                        // Format in Indian styling (crore/lakh commas) or standard commas
                        const formatted = "₹" + salesValue.toLocaleString("en-IN");
                        salesValEl.textContent = formatted;
                    }, 150);
                }

                // 6. Section Intersection observer for scroll reveal animations
                const sectionObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            // Text Column Reveal
                            const textCol = document.getElementById("text-column");
                            if (textCol) {
                                textCol.style.opacity = "1";
                                textCol.style.transform = "translateY(0)";
                            }

                            // Globe Canvas Reveal
                            const globeWrapper = document.getElementById("globe-wrapper");
                            if (globeWrapper) {
                                globeWrapper.style.opacity = "1";
                                globeWrapper.style.transform = "translateY(0) scale(1)";
                            }

                            // Center 24/7 Card Reveal
                            setTimeout(() => {
                                const centerCard = document.getElementById("center-status-card");
                                if (centerCard) {
                                    centerCard.style.opacity = "0.9";
                                    centerCard.style.transform = "scale(1)";
                                }
                            }, 150);

                            // Data Cards sequential fade-in
                            const cardIds = ["card-1", "card-2", "card-3", "card-4", "card-5", "card-6"];
                            cardIds.forEach((id, index) => {
                                setTimeout(() => {
                                    const card = document.getElementById(id);
                                    if (card) {
                                        card.style.opacity = "1";
                                        card.style.transform = "translateY(0)";
                                    }
                                }, 250 + (index * 60));
                            });

                            // Drag instruction reveal
                            setTimeout(() => {
                                const dragHint = document.getElementById("drag-hint");
                                if (dragHint) {
                                    dragHint.style.opacity = "0.6";
                                }
                            }, 800);

                            sectionObserver.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.15 });

                const targetSec = document.getElementById("workflow");
                if (targetSec) {
                    sectionObserver.observe(targetSec);
                }
            </script>
        </section>

        <!-- SECTION 6: Templates Gallery (from elevate_theme_e_commerce_templates_gallery) -->
        <section id="templates" class="py-20 bg-surface border-t border-outline-variant/20 flex flex-col items-center">
            <div class="w-full max-w-[1280px] px-4">
                <h2 class="text-4xl md:text-display-lg text-on-surface mb-12 tracking-tight font-headline-lg">Templates Gallery</h2>
                <!-- Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Card 1 -->
                    <div class="bg-surface rounded-xl p-4 overflow-hidden group cursor-pointer border border-outline-variant hover:shadow-md transition-all">
                        <div class="rounded-lg overflow-hidden aspect-[4/3] mb-4 bg-surface-container relative">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="Skincare theme" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAJLkhrlCOg80l0j8NcCQuIPwqR13AzN9Vzb4VTFQUVShR-WQ_reL_UhoSW-0jZsA2xT9_imml-_Unwe_5yPMy7NWU4vGzNUX-0ap2kn9wY1pU_i8-56QUMW76yoPXmNQn2SbeShsbbtyaEt401qZbj2iFjuRuWZUL5LH8L-0z-r1vqy7A2bH6Z_8b7BavyFwao0fZzQ6cCtCeqItG-JdFnRfjjlrQvdaEqNcj1GNKP98k1EnOeFKN3jA">
                        </div>
                        <h4 class="font-headline-md font-semibold text-lg text-on-surface">Rosé Skin</h4>
                        <p class="text-xs text-on-surface-variant font-body mt-1">Beauty & Cosmetics Store</p>
                    </div>
                    <!-- Card 2 -->
                    <div class="bg-surface rounded-xl p-4 overflow-hidden group cursor-pointer border border-outline-variant hover:shadow-md transition-all">
                        <div class="rounded-lg overflow-hidden aspect-[4/3] mb-4 bg-surface-container relative">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="Men fashion theme" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDnZ7uHiCNTuJqSM_mAmpjSpPsJYa0e7Tz-Ot0YSZ4oM24QgBbyyGi_cKy4snXywTpGKzrLYyIODkUjlgMOfUspBCFPi-xJnpC2iIKqjPt8hw13bgOfrgLv8_H18my7kD2WRnyJdsu4aG_5mgeUXa3LT8DFjsysCOPLLimQ83yKAQnY9BoBbm1rgCfZHktnOglZ5bhJPD0CHHw-eAFXZJAJ5YWiRFwFHRuJA7IEC6hUXQUZ19NGRSezOw">
                        </div>
                        <h4 class="font-headline-md font-semibold text-lg text-on-surface">Urban Chic</h4>
                        <p class="text-xs text-on-surface-variant font-body mt-1">Men's Modern Streetwear</p>
                    </div>
                    <!-- Card 3 -->
                    <div class="bg-surface rounded-xl p-4 overflow-hidden group cursor-pointer border border-outline-variant hover:shadow-md transition-all">
                        <div class="rounded-lg overflow-hidden aspect-[4/3] mb-4 bg-surface-container relative">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="Organic theme" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAB3UqJAIcScvw8Okt9VQLl53eNY4w5pqIy-MKGfX2gY9WOdWErqWtua30hWb9uIDN9DTmJGfVf7V53WYNNSZCNAS5IzxhTb1_v_AKcl1YtUfFCeMsBRq4Op1V4iQoxemmcKBMzguIicoPEBrXS-ZzmdMdOMDif0RvSrV3o4AEPxLhRkZHM9o6YYqEWMk-OFv2VH8_oVuerUN0-XsYvtkalRLiny3EvGP8Ks05eEeSqVIz-lCsRBq6b_Q">
                        </div>
                        <h4 class="font-headline-md font-semibold text-lg text-on-surface">Terra Skincare</h4>
                        <p class="text-xs text-on-surface-variant font-body mt-1">Organic Beauty Products</p>
                    </div>
                    <!-- Card 4 -->
                    <div class="bg-surface rounded-xl p-4 overflow-hidden group cursor-pointer border border-outline-variant hover:shadow-md transition-all">
                        <div class="rounded-lg overflow-hidden aspect-[4/3] mb-4 bg-surface-container relative">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="Electronics theme" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAQrIdIkvrOsU3BxgsR9gXgn2xifoTSatEYtt_oGaN_CK8SZcaWoa6iyJCF4YzMm_1KmfkbnaHAHLzd1GR0tbZ3lEX1nQ9HlZeSh_nEwcZK8x9fbs5FrFcXe1Jd1ge8ExMSP0CJlybjahH4TJdpeD9YNxdPhaX4a76zDi53OaayqBEWKyxMNkHUJ120eO0-1s3W0HHVspqouRFPc_Sr44WGeCybbudjdmmV6YCeycQGZFUdFxyUhQtHiw">
                        </div>
                        <h4 class="font-headline-md font-semibold text-lg text-on-surface">Volt Gear</h4>
                        <p class="text-xs text-on-surface-variant font-body mt-1">High-Tech Storefront</p>
                    </div>
                    <!-- Card 5 -->
                    <div class="bg-surface rounded-xl p-4 overflow-hidden group cursor-pointer border border-outline-variant hover:shadow-md transition-all">
                        <div class="rounded-lg overflow-hidden aspect-[4/3] mb-4 bg-surface-container relative">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="Jewelry theme" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAhbfxEjqhnsIhfqHfH4Sk5LHOoPCKtCcgn1YAl7rWbgJqGMv9vowDpd2dMp6jXatRMTbmkIbREqXY614I-dZhyYXSsN3Zn3guJo4d9q0JBI6askT3QB0MLZQdt8fiJeCWBUWc7bBVJSybi-V8d2sbDpjEv0FGZp5uJ0DlKwnn_Bv7LGmHqzP8LWF3ZmseNJEbiKUu4cUXqwq6tBLQWogOG_b5EOgou8Uao2XmTYWvCE1Z4DpOFcCscwA">
                        </div>
                        <h4 class="font-headline-md font-semibold text-lg text-on-surface">Silverspark</h4>
                        <p class="text-xs text-on-surface-variant font-body mt-1">Refined Luxury Jewelry</p>
                    </div>
                    <!-- Card 6 -->
                    <div class="bg-surface rounded-xl p-4 overflow-hidden group cursor-pointer border border-outline-variant hover:shadow-md transition-all">
                        <div class="rounded-lg overflow-hidden aspect-[4/3] mb-4 bg-surface-container relative">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="Women fashion theme" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA_lJl34_yvM8OaMGB4a-sPVzl1pBmG9b1a4-S1ipWPanOgek4kag00sr6w0OXwIhMyFW1ZtBXgOs06Sn_V5-A6dSieTmHjH82RfOpFoyWSwiN8Y1i-B7da--jv56Q-J_dArRv4-LhRhbhRVA_Vf8cQq9VjYjN0hp_q5k84q_fyJzNSHbYeJ7MBtSOrpvfaPFhmJqbCQIkm1O4ld3l72heh5EVB4iD7_YOJMVYZMJyCH06MKG34bbUdRA">
                        </div>
                        <h4 class="font-headline-md font-semibold text-lg text-on-surface">Maison Atelier</h4>
                        <p class="text-xs text-on-surface-variant font-body mt-1">Chic Everyday Editorial</p>
                    </div>
                    <!-- Card 7 -->
                    <div class="bg-surface rounded-xl p-4 overflow-hidden group cursor-pointer border border-outline-variant hover:shadow-md transition-all">
                        <div class="rounded-lg overflow-hidden aspect-[4/3] mb-4 bg-surface-container relative">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="Toys theme" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCzk66Cgo_CtSCVKlZ0MEYplqS1SgitTlGvx22TtZ83UJTfBasyJmcTuUukFkImq2NRuu16pXz7ALurVceyUgFeO1li6zXKkXaihYnUcahRfhAzh2rukPOrLURtFPEcLeiYB6vtaKAKspWh6T-CJRgxyHOw93WslaraahiQaoGAg52iqeSAtVJ-0SycV9ZKPEnrZbqGnL4Z7YSYysdUKd6DicE72tLKIADMF9bEw-vh1Fj3iplqRNNPpA">
                        </div>
                        <h4 class="font-headline-md font-semibold text-lg text-on-surface">Kidsland</h4>
                        <p class="text-xs text-on-surface-variant font-body mt-1">Playful Children's Toys</p>
                    </div>
                    <!-- Card 8 -->
                    <div class="bg-surface rounded-xl p-4 overflow-hidden group cursor-pointer border border-outline-variant hover:shadow-md transition-all">
                        <div class="rounded-lg overflow-hidden aspect-[4/3] mb-4 bg-surface-container relative">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="Furniture theme" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAe8SKKZSEjjaPsvl9T6Me5YCFIN7Le6B-dclL_YJkfQNqx1Kk3FrXsH-5QtB7lnDj6LoI2spD7vHFZuuxr419iF-4ZSwh92FJwJjpmWeJsTgUfNg0cZyDgCulZs0ftmCr_DHy5mRQWJbCtlLpQdPlRo4ENk9WpsC0yxsEZHr2ntNkEAf8TE624CkvVWxWwo3FBywxavSsoGtxp8s9EqPEoaG6kNkqrApoOfY_KFEpU5baAsCDHb5rKRQ">
                        </div>
                        <h4 class="font-headline-md font-semibold text-lg text-on-surface">Fjäll Design</h4>
                        <p class="text-xs text-on-surface-variant font-body mt-1">Scandinavian Furnishings</p>
                    </div>
                    <!-- Card 9 -->
                    <div class="bg-surface rounded-xl p-4 overflow-hidden group cursor-pointer border border-outline-variant hover:shadow-md transition-all">
                        <div class="rounded-lg overflow-hidden aspect-[4/3] mb-4 bg-surface-container relative">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="Streetwear theme" src="https://lh3.googleusercontent.com/aida-public/AB6AXuATiERe3PQaWbmzPRFPshv0vOkoJ0Lm4Oqk_1ORyfbpn9HzpwhXXgrC-OXVnmUHgP7wgfotMlVjutIfNIfxM7nsvTJpvd7TgqmOfAIojwPO_5Z2jDAxNExMEQBab3fFErobk9fflJ5pGQ1SPVWqKxsxxbis-L2sqydUi_XppDNW1Ix6wGnVrE8nT57U9PjXbPJvd3k_2XHs62jXpy2_83lJ2qTAsEPvwUjUuANbXURDrtAhOeCXPk049g">
                        </div>
                        <h4 class="font-headline-md font-semibold text-lg text-on-surface">Concrete Edge</h4>
                        <p class="text-xs text-on-surface-variant font-body mt-1">Urban Streetwear</p>
                    </div>
                    <!-- Card 10 -->
                    <div class="bg-surface rounded-xl p-4 overflow-hidden group cursor-pointer border border-outline-variant hover:shadow-md transition-all">
                        <div class="rounded-lg overflow-hidden aspect-[4/3] mb-4 bg-surface-container relative">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="Garden theme" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCwTLSx2WYIeSk4g07xlL64USAcnhlIIJaWGECgmA4o8Y67lcYTrrfaf2onSwrgp03JDD0didzk8F_kmgohZB_aTojUMBoKOzwdYu9C2U5c_TdXMTrQ3rueKY4zIJFHV612tdl6Nos43_qQ5Efp7uanjBqyWWdQoc4P2kiGTeizfcM_VMEC2OuKi4sAv_Nvy9SPy78hWRDsCPGHdBx6j5CoMcpRtbWhLVSXvVPLMzqJrr6Q8YlYAuVlRg">
                        </div>
                        <h4 class="font-headline-md font-semibold text-lg text-on-surface">Botanic Studio</h4>
                        <p class="text-xs text-on-surface-variant font-body mt-1">Fresh Home &amp; Garden</p>
                    </div>
                    <!-- Card 11 -->
                    <div class="bg-surface rounded-xl p-4 overflow-hidden group cursor-pointer border border-outline-variant hover:shadow-md transition-all">
                        <div class="rounded-lg overflow-hidden aspect-[4/3] mb-4 bg-surface-container relative">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="Audio theme" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCR-7NSCF7G3HUK7f78OhbnN96udLAOIoIcwzTtqAgCIFsPNunYk56nOa-CaiWhyZeWx3_Zm05Z52ubfI3BKx66vLQ5Mozok2ZmmpYiA-RJDsfOnfkyOx6v7DXveHy2QzTn5ALKrtsjam0SJerOXETnpngLa0dLaKO60HNpyJZAo1m-0_qoKQu87lUPc7gSMaWHt4iaSnsvSXgIDdeKh0rs5OPr6zb_GPZfuS039of1nPXOf15i9bQLuw">
                        </div>
                        <h4 class="font-headline-md font-semibold text-lg text-on-surface">Acoustic Audio</h4>
                        <p class="text-xs text-on-surface-variant font-body mt-1">Premium Audio Equipment</p>
                    </div>
                    <!-- Card 12 -->
                    <div class="bg-surface rounded-xl p-4 overflow-hidden group cursor-pointer border border-outline-variant hover:shadow-md transition-all">
                        <div class="rounded-lg overflow-hidden aspect-[4/3] mb-4 bg-surface-container relative">
                            <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="Artisan theme" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB835SQ8BUDicZM3zBdQlfAwGp8PLnDEkE-OzM5K6ChZQAQklfEuNEjx5RVv_IWUWD8TFMJOuA9M0RJFrc_01ci_NJwyfFDTRDxl2JDojoFdGnE3SS8ezTC5TkIG-B1UXlTJ_SeVG53n8asuts9RGuxlqZI0Nr324vadDJQnsNXThytpEVPyJL4M32QT3Dg9wkAqFVnnP-MAw5F-P1b9gWOgTk2dMmzCsng2TLDX9G5344zyyDOxpTwpg">
                        </div>
                        <h4 class="font-headline-md font-semibold text-lg text-on-surface">Studio Craft</h4>
                        <p class="text-xs text-on-surface-variant font-body mt-1">Handmade Artisan Goods</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 7: Customer Support (from support_section_variant_vertical_stack_layout) -->
        <section id="support" class="bg-brand-dark text-white py-20 relative overflow-hidden" data-purpose="hero-support">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-16">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
                    <!-- Text Content Left -->
                    <div class="lg:col-span-7 flex flex-col justify-center reveal-up">
                        <p class="font-script text-3xl md:text-4xl text-brand-accent mb-6 tracking-wide transform -rotate-2 origin-left">
                            Customer Support
                        </p>
                        <h2 class="text-4xl md:text-5xl lg:text-7xl tracking-tight leading-tight mb-8 text-white font-display-lg">
                            No problem too big,<br>no question too small.
                        </h2>
                        <p class="text-lg md:text-xl text-gray-200 max-w-2xl leading-relaxed font-light font-body">
                            We're committed to the growth of your ecommerce business, just as you are. Reach out to us when in need.
                        </p>
                    </div>
                    <!-- Action Cards Right -->
                    <div class="lg:col-span-5 flex flex-col gap-4 font-label">
                        <!-- Email Card -->
                        <a class="group flex items-center justify-between bg-white/5 hover:bg-white/10 border border-white/20 rounded-2xl py-5 px-6 transition-all duration-300 w-full" href="mailto:support@virratpos.com">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center mr-4">
                                    <i class="far fa-envelope text-gray-300 text-xl"></i>
                                </div>
                                <span class="font-semibold text-lg text-white">Send us an email</span>
                            </div>
                            <div class="bg-brand-accent text-brand-dark rounded-full w-8 h-8 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-chevron-right text-sm"></i>
                            </div>
                        </a>
                        <!-- Call Back Card -->
                        <a class="group flex items-center justify-between bg-white/5 hover:bg-white/10 border border-white/20 rounded-2xl py-5 px-6 transition-all duration-300 w-full" href="#">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center mr-4">
                                    <i class="fas fa-phone-alt text-gray-300 text-xl"></i>
                                </div>
                                <span class="font-semibold text-lg text-white">Request a call back</span>
                            </div>
                            <div class="bg-brand-accent text-brand-dark rounded-full w-8 h-8 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-chevron-right text-sm"></i>
                            </div>
                        </a>
                        <!-- Demo Card -->
                        <a class="group flex items-center justify-between bg-white/5 hover:bg-white/10 border border-white/20 rounded-2xl py-5 px-6 transition-all duration-300 w-full" href="{{ route('register') }}">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center mr-4">
                                    <i class="fas fa-desktop text-gray-300 text-xl"></i>
                                </div>
                                <span class="font-semibold text-lg text-white">Schedule a free demo</span>
                            </div>
                            <div class="bg-brand-accent text-brand-dark rounded-full w-8 h-8 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <i class="fas fa-chevron-right text-sm"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Full Width Panoramic Image Below -->
            <div class="w-full h-96 md:h-[500px] overflow-hidden relative border-t border-white/10">
                <img alt="Support Agent" class="object-cover object-center w-full h-full opacity-70 mix-blend-luminosity hover:mix-blend-normal transition-all duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAMXDQQ-iNyazshsMFNEiv7HNublxzJRfC6d9UCzdmgNO-2wOlx2qWrpcmQfeFVivoJd_jf8hOCAyOnj5Ewa7N-V5h7BoBZbtm5k5LMa7q0Tl4azNBmOFF-cU0CBUtYc46o3t3KzF1vSJf2WhMc6KHrj_5of-S7QuZXats9lQnECMQpCfOJwNVw44jtjIYK7jfWJQZQHjjL6YTRF2iwMPHedktgF_b9iL8jvF0u8q2VpPkTUjRQyG_NnQ">
                <div class="absolute inset-0 bg-gradient-to-t from-brand-dark via-transparent to-brand-dark opacity-50"></div>
            </div>
        </section>

    </main>

    <!-- SECTION 8: Footer (from premium_elevate_commerce_footer) -->
    <footer class="bg-surface-container border-t border-secondary-container dark:border-outline-variant w-full rounded-none">
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter py-xxl flex flex-col md:grid md:grid-cols-5 gap-lg">
            <!-- Column 1: Brand & Mission -->
            <div class="col-span-1 md:col-span-2 lg:col-span-1 flex flex-col gap-md">
                <div class="font-headline-md text-headline-md font-bold text-primary">
                    {{ env('APP_NAME', 'VirratPOS') }}
                </div>
                <p class="font-body-sm text-body-sm text-secondary max-w-[280px]">
                    Empowering global businesses with sophisticated, high-performance commerce solutions designed for scale and ambition.
                </p>
            </div>
            <!-- Column 2: Product -->
            <div class="flex flex-col gap-md">
                <h4 class="font-headline-md text-headline-md font-semibold text-on-surface">Product</h4>
                <nav class="flex flex-col gap-sm">
                    <a class="font-body-sm text-body-sm text-secondary hover:text-primary transition-colors duration-200" href="#features">Features</a>
                    <a class="font-body-sm text-body-sm text-secondary hover:text-primary transition-colors duration-200" href="#marketing">Marketplace</a>
                    <a class="font-body-sm text-body-sm text-secondary hover:text-primary transition-colors duration-200" href="#workflow">Workflow</a>
                    <a class="font-body-sm text-body-sm text-secondary hover:text-primary transition-colors duration-200" href="#templates">Themes</a>
                </nav>
            </div>
            <!-- Column 3: Company -->
            <div class="flex flex-col gap-md">
                <h4 class="font-headline-md text-headline-md font-semibold text-on-surface">Company</h4>
                <nav class="flex flex-col gap-sm">
                    <a class="font-body-sm text-body-sm text-secondary hover:text-primary transition-colors duration-200" href="#">About Us</a>
                    <a class="font-body-sm text-body-sm text-secondary hover:text-primary transition-colors duration-200" href="#">Careers</a>
                    <a class="font-body-sm text-body-sm text-secondary hover:text-primary transition-colors duration-200" href="#">Press</a>
                    <a class="font-body-sm text-body-sm text-secondary hover:text-primary transition-colors duration-200" href="#">Blog</a>
                </nav>
            </div>
            <!-- Column 4: Support -->
            <div class="flex flex-col gap-md">
                <h4 class="font-headline-md text-headline-md font-semibold text-on-surface">Support</h4>
                <nav class="flex flex-col gap-sm">
                    <a class="font-body-sm text-body-sm text-secondary hover:text-primary transition-colors duration-200" href="#support">Help Center</a>
                    <a class="font-body-sm text-body-sm text-secondary hover:text-primary transition-colors duration-200" href="#support">Contact Us</a>
                    <a class="font-body-sm text-body-sm text-secondary hover:text-primary transition-colors duration-200" href="#support">Community</a>
                    <a class="font-body-sm text-body-sm text-secondary hover:text-primary transition-colors duration-200" href="{{ route('register') }}">Partner Program</a>
                </nav>
            </div>
            <!-- Column 5: Newsletter -->
            <div class="flex flex-col gap-md col-span-1 md:col-span-2 lg:col-span-1">
                <h4 class="font-headline-md text-headline-md font-semibold text-on-surface">Stay Updated</h4>
                <p class="font-body-sm text-body-sm text-secondary">
                    Get the latest commerce insights delivered to your inbox.
                </p>
                <form class="flex flex-col gap-sm mt-xs" method="post" action="{{ route('join_us_store') }}">
                    @csrf
                    <input class="h-[48px] bg-surface-container-low border border-outline-variant/30 focus:border-primary focus:ring-1 focus:ring-primary focus:bg-surface-container-lowest rounded-lg px-md font-body-md text-body-md text-on-surface transition-all duration-200" placeholder="Email address" required name="email" type="email"/>
                    <button class="h-[48px] bg-primary text-on-primary font-label-md text-label-md rounded-lg hover:bg-primary-container hover:shadow-[0px_14px_50px_rgba(0,0,0,0.08)] transition-all duration-200 flex items-center justify-center gap-xs" type="submit">
                        Subscribe
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 0;">arrow_forward</span>
                    </button>
                </form>
            </div>
        </div>
        <!-- Bottom Bar -->
        <div class="max-w-container-max mx-auto px-margin-mobile md:px-gutter py-xl border-t border-secondary-container flex flex-col md:flex-row items-center justify-between gap-md">
            <div class="font-body-sm text-body-sm text-secondary">
                © {{ date('Y') }} {{ env('APP_NAME', 'VirratPOS') }}. All rights reserved.
            </div>
            <nav class="flex items-center gap-md font-label">
                <a class="font-body-sm text-body-sm text-secondary hover:text-primary transition-colors duration-200" href="#">Privacy Policy</a>
                <a class="font-body-sm text-body-sm text-secondary hover:text-primary transition-colors duration-200" href="#">Terms of Service</a>
                <a class="font-body-sm text-body-sm text-secondary hover:text-primary transition-colors duration-200" href="#">Cookies</a>
            </nav>
            <div class="flex items-center gap-sm text-secondary">
                <a aria-label="Instagram" class="p-xs hover:text-primary transition-colors duration-200" href="#">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path clip-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" fill-rule="evenodd"></path>
                    </svg>
                </a>
                <a aria-label="LinkedIn" class="p-xs hover:text-primary transition-colors duration-200" href="#">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path clip-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" fill-rule="evenodd"></path>
                    </svg>
                </a>
                <a aria-label="X/Twitter" class="p-xs hover:text-primary transition-colors duration-200" href="#">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.008 5.975H5.059z"></path>
                    </svg>
                </a>
                <a aria-label="Facebook" class="p-xs hover:text-primary transition-colors duration-200" href="#">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path clip-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" fill-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </footer>

    <!-- Floating Action Buttons -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end space-y-4" data-purpose="floating-widgets">
        <!-- Schedule Demo Floating Widget -->
        <div class="flex items-center group cursor-pointer">
            <div class="bg-white border border-gray-200 text-gray-700 text-sm font-medium py-2 px-4 rounded-full shadow-md mr-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform translate-x-4 group-hover:translate-x-0 relative">
                Schedule a free demo
                <div class="absolute right-[-6px] top-1/2 transform -translate-y-1/2 w-3 h-3 bg-white border-r border-t border-gray-200 rotate-45"></div>
            </div>
            <a href="{{ route('register') }}" class="bg-brand-dark hover:bg-gray-800 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg transition-all duration-300">
                <i class="fas fa-desktop text-xl"></i>
            </a>
        </div>
        <!-- Live Chat Floating Widget -->
        <button class="bg-brand-dark hover:bg-gray-800 text-white rounded-full w-14 h-14 flex items-center justify-center shadow-lg transition-all duration-300">
            <i class="fas fa-comment-alt text-xl"></i>
        </button>
    </div>

    <!-- Interactive JavaScripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Mobile responsive menu handler
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerIcon = document.getElementById('hamburger-icon');
            const closeIcon = document.getElementById('close-icon');

            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', () => {
                    const isHidden = mobileMenu.classList.contains('hidden');
                    if (isHidden) {
                        mobileMenu.classList.remove('hidden');
                        hamburgerIcon.classList.add('hidden');
                        closeIcon.classList.remove('hidden');
                    } else {
                        mobileMenu.classList.add('hidden');
                        hamburgerIcon.classList.remove('hidden');
                        closeIcon.classList.add('hidden');
                    }
                });

                // Close mobile menu when anchor link is clicked
                mobileMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        mobileMenu.classList.add('hidden');
                        hamburgerIcon.classList.remove('hidden');
                        closeIcon.classList.add('hidden');
                    });
                });
            }



            // 3. Scroll reveal effects (.reveal-up)
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.reveal-up').forEach((el) => {
                observer.observe(el);
            });
        });
    </script>
</body>

</html>
