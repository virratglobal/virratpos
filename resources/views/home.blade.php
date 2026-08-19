@extends('layouts.ui-admin')
@php
    $logo=\App\Models\Utility::get_file('uploads/logo/');
    $profile=\App\Models\Utility::get_file('uploads/profile/');
    $logo1=\App\Models\Utility::get_file('uploads/is_cover_image/');
    $setting = App\Models\Utility::settings();
    $company_logo = \App\Models\Utility::getValByName('company_logo');
@endphp

@section('page-title')
    {{ __('Dashboard') }}
@endsection

@push('style')
<style>
    /* Dashboard custom aesthetics */
    .dashboard-card {
        border: 1px solid rgba(199, 196, 215, 0.15) !important;
        box-shadow: 0 1px 8px rgba(0,0,0,0.04) !important;
        border-radius: 12px !important;
        background: #ffffff !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    .dashboard-card:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 16px rgba(0,0,0,0.06) !important;
    }
    
    /* Chart wrappers */
    .chart-container-wrap {
        height: 160px !important;
        width: 100% !important;
        margin-top: 10px !important;
        overflow: hidden !important;
    }
    
    /* Select Dropdown override */
    .timeframe-select-wrap select {
        border-radius: 8px !important;
        border: 1px solid #c7c4d7 !important;
        background-color: #ffffff !important;
        color: #0b1c30 !important;
        font-family: 'Geist', sans-serif !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        padding: 6px 36px 6px 12px !important;
        transition: all 0.2s !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05) !important;
    }
    .timeframe-select-wrap select:focus {
        border-color: #4648d4 !important;
        box-shadow: 0 0 0 3px rgba(70, 72, 212, 0.1) !important;
        outline: none !important;
    }
    
    /* Quick status rows */
    .status-row-item {
        transition: all 0.2s ease !important;
        border-bottom: 1px solid rgba(199, 196, 215, 0.1) !important;
    }
    .status-row-item:last-child {
        border-bottom: none !important;
    }
    .status-row-item:hover {
        background-color: #f8fafc !important;
    }
    .status-icon-box {
        width: 34px !important;
        height: 34px !important;
        border-radius: 8px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.2s !important;
    }
    .status-row-item:hover .status-icon-box {
        transform: scale(1.05) !important;
    }
    
    /* Copy link button and store link styling */
    .store-link-box {
        background-color: #f8fafc !important;
        border: 1px solid rgba(199, 196, 215, 0.15) !important;
        border-radius: 8px !important;
        padding: 8px 12px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 8px !important;
    }
    .store-link-url {
        color: #4648d4 !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        text-decoration: none !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        max-width: 170px !important;
    }
    .store-link-url:hover {
        text-decoration: underline !important;
    }
    .btn-copy-link {
        background-color: #ffffff !important;
        border: 1px solid rgba(199, 196, 215, 0.3) !important;
        color: #464554 !important;
        border-radius: 6px !important;
        padding: 4px 8px !important;
        font-size: 11px !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        transition: all 0.2s !important;
    }
    .btn-copy-link:hover {
        background-color: #4648d4 !important;
        color: #ffffff !important;
        border-color: #4648d4 !important;
    }
    
    /* Shortcuts add button */
    .btn-add-shortcut {
        border: 1px dashed #cbd5e1 !important;
        background-color: #f8fafc !important;
        border-radius: 12px !important;
        height: 80px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.2s !important;
        cursor: pointer !important;
        color: #475569 !important;
        text-decoration: none !important;
    }
    .btn-add-shortcut:hover {
        border-color: #4648d4 !important;
        background-color: #f5f3ff !important;
        color: #4648d4 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(70, 72, 212, 0.05) !important;
    }

    /* Dark Mode Dashboard Overrides */
    html.dark .dashboard-card,
    html.dark .dashboard-custom-card {
        background-color: #111827 !important;
        border-color: #263449 !important;
        color: #F8FAFC !important;
    }
    html.dark .dashboard-custom-title,
    html.dark .timeline-text-main,
    html.dark .plan-name {
        color: #F8FAFC !important;
    }
    html.dark .timeline-text-sub,
    html.dark .plan-users,
    html.dark .plan-revenue,
    html.dark .status-row-item span {
        color: #CBD5E1 !important;
    }
    html.dark .timeline-dot-wrapper {
        background-color: #1E293B !important;
        border-color: #111827 !important;
    }
    html.dark .timeline-line {
        background-color: #263449 !important;
    }
    html.dark .plan-progress-track {
        background-color: #1E293B !important;
    }
    html.dark .timeframe-select-wrap select {
        background-color: #0F172A !important;
        border-color: #334155 !important;
        color: #F8FAFC !important;
    }
    html.dark .status-row-item:hover {
        background-color: #172033 !important;
    }
    html.dark .store-link-box {
        background-color: #0F172A !important;
        border-color: #263449 !important;
    }
    html.dark .btn-copy-link {
        background-color: #1E293B !important;
        border-color: #334155 !important;
        color: #CBD5E1 !important;
    }
    html.dark .btn-copy-link:hover {
        background-color: #2563EB !important;
        color: #FFFFFF !important;
        border-color: #2563EB !important;
    }
    html.dark .btn-add-shortcut {
        background-color: #0F172A !important;
        border-color: #334155 !important;
        color: #CBD5E1 !important;
    }
    html.dark .btn-add-shortcut:hover {
        background-color: #172033 !important;
        border-color: #3B82F6 !important;
        color: #60A5FA !important;
    }
</style>
@endpush
@push('script-page')
    <script>
        var timezone = '{{ !empty($setting['timezone']) ? $setting['timezone'] : 'Asia/Kolkata' }}';

        let today = new Date(new Date().toLocaleString("en-US", {
            timeZone: timezone
        }));
        var curHr = today.getHours()
        var target = document.getElementById("greetings");

        if (curHr < 12) {
            target.innerHTML = "Good Morning,";
        } else if (curHr < 17) {
            target.innerHTML = "Good Afternoon,";
        } else {
            target.innerHTML = "Good Evening,";
        }

    </script>
    <script>
        $(document).on('click', '#code-generate', function() {
            var length = 10;
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            $('#auto-code').val(result);
        });
    </script>
@endpush
@section('content')
@if (\Auth::user()->type == 'super admin')

    <x-ui.page-container>
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 style="font-family: 'Geist', sans-serif; font-size: 1.5rem; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">
                    {{ __('Overview') }}
                </h1>
                <p style="font-family: 'Inter', sans-serif; font-size: 14px; color: #767586; margin-top: 4px;">
                    {{ __('Super Admin Dashboard') }}
                </p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-primary" style="display: flex; gap: 8px;">
                <span class="material-symbols-outlined" style="font-size: 18px;">refresh</span>
                {{ __('Refresh Data') }}
            </a>
        </div>

        <!-- 5 Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <!-- Active Plans -->
            <div style="background: #e5eeff; border-radius: 12px; padding: 24px; position: relative; overflow: hidden;" class="group">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 group-hover:scale-150" style="background: rgba(70,72,212,0.05);"></div>
                <div class="flex justify-between items-start mb-6">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #6063ee; color: #fffbff; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined">workspace_premium</span>
                    </div>
                </div>
                <div>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #464554; margin-bottom: 4px;">{{ __('Active Plans') }}</p>
                    <p style="font-family: 'Geist', sans-serif; font-size: 24px; font-weight: 600; color: #0b1c30; margin: 0;">{{ $user['active_plans'] }}</p>
                </div>
            </div>

            <!-- Pending Requests -->
            <div style="background: #e5eeff; border-radius: 12px; padding: 24px; position: relative; overflow: hidden;" class="group">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 group-hover:scale-150" style="background: rgba(70,72,212,0.05);"></div>
                <div class="flex justify-between items-start mb-6">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #f59e0b; color: #fffbff; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </div>
                </div>
                <div>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #464554; margin-bottom: 4px;">{{ __('Pending Requests') }}</p>
                    <p style="font-family: 'Geist', sans-serif; font-size: 24px; font-weight: 600; color: #0b1c30; margin: 0;">{{ $user['pending_requests'] }}</p>
                </div>
            </div>

            <!-- Monthly Growth -->
            <div style="background: #e5eeff; border-radius: 12px; padding: 24px; position: relative; overflow: hidden;" class="group">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 group-hover:scale-150" style="background: rgba(70,72,212,0.05);"></div>
                <div class="flex justify-between items-start mb-6">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #6063ee; color: #fffbff; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined">trending_up</span>
                    </div>
                    @if($user['monthly_growth'] >= 0)
                        <span style="background: #e6f6ec; color: #0f7636; padding: 4px 8px; border-radius: 16px; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                            <span class="material-symbols-outlined" style="font-size: 14px;">arrow_upward</span>
                            {{ $user['monthly_growth'] }}%
                        </span>
                    @else
                        <span style="background: #feeceb; color: #c01d14; padding: 4px 8px; border-radius: 16px; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                            <span class="material-symbols-outlined" style="font-size: 14px;">arrow_downward</span>
                            {{ abs($user['monthly_growth']) }}%
                        </span>
                    @endif
                </div>
                <div>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #464554; margin-bottom: 4px;">{{ __('Monthly Growth') }}</p>
                    <p style="font-family: 'Geist', sans-serif; font-size: 24px; font-weight: 600; color: #0b1c30; margin: 0;">{{ $user['monthly_growth'] }}%</p>
                </div>
            </div>

            <!-- Total Stores -->
            <div style="background: #e5eeff; border-radius: 12px; padding: 24px; position: relative; overflow: hidden;" class="group">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 group-hover:scale-150" style="background: rgba(70,72,212,0.05);"></div>
                <div class="flex justify-between items-start mb-6">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #10b981; color: #fffbff; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined">storefront</span>
                    </div>
                </div>
                <div>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #464554; margin-bottom: 4px;">{{ __('Total Stores') }}</p>
                    <p style="font-family: 'Geist', sans-serif; font-size: 24px; font-weight: 600; color: #0b1c30; margin: 0;">{{ $user->total_user }}</p>
                </div>
            </div>

            <!-- Total Revenue -->
            <div style="background: #e5eeff; border-radius: 12px; padding: 24px; position: relative; overflow: hidden;" class="group">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 group-hover:scale-150" style="background: rgba(70,72,212,0.05);"></div>
                <div class="flex justify-between items-start mb-6">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #6063ee; color: #fffbff; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                </div>
                <div>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #464554; margin-bottom: 4px;">{{ __('Total Revenue') }}</p>
                    <p style="font-family: 'Geist', sans-serif; font-size: 24px; font-weight: 600; color: #0b1c30; margin: 0;">{{ \App\Models\Utility::priceFormat($user['total_plan_price']) }}</p>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <!-- Chart Section -->
        <style>
        @import url('https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600&family=Inter:wght@400;500&family=JetBrains+Mono:wght@400&display=swap');
        
        .dashboard-custom-card {
            background-color: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            height: 100%;
        }
        .dashboard-custom-title {
            font-family: 'Geist', sans-serif;
            font-size: 20px;
            font-weight: 600;
            color: #0b1c30;
            margin: 0;
        }
        .dashboard-custom-link {
            font-family: 'Geist', sans-serif;
            font-size: 13px;
            font-weight: 500;
            color: #4648d4;
            text-decoration: none;
        }
        .dashboard-custom-link:hover { text-decoration: underline; }
        
        .timeline-container { position: relative; margin-top: 24px; }
        .timeline-line {
            position: absolute;
            left: 15px;
            top: 8px;
            bottom: 8px;
            width: 1px;
            background-color: rgba(199, 196, 215, 0.4);
        }
        .timeline-item {
            display: flex;
            gap: 16px;
            position: relative;
            padding-bottom: 28px;
        }
        .timeline-item:last-child { padding-bottom: 0; }
        .timeline-dot-wrapper {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #dce9ff;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            border: 4px solid #fff;
            flex-shrink: 0;
        }
        .timeline-dot { width: 8px; height: 8px; border-radius: 50%; }
        
        .text-primary-dot { background-color: #4648d4; }
        .text-error-dot { background-color: #ba1a1a; }
        .text-tertiary-dot { background-color: #904900; }
        
        .timeline-content {
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-top: 4px;
        }
        .timeline-text-main {
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            color: #0b1c30;
            margin: 0;
        }
        .timeline-text-sub {
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            color: #464554;
            margin: 4px 0 0 0;
        }
        
        .status-badge {
            padding: 4px 10px;
            border-radius: 4px;
            font-family: 'Geist', sans-serif;
            font-size: 12px;
            font-weight: 500;
        }
        .status-success { background-color: rgba(70, 72, 212, 0.1); color: #4648d4; }
        .status-pending { background-color: rgba(144, 73, 0, 0.1); color: #904900; }
        .status-error { background-color: rgba(186, 26, 26, 0.1); color: #ba1a1a; }
        
        .plan-item { margin-bottom: 28px; }
        .plan-item:last-child { margin-bottom: 0; }
        .plan-item-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-family: 'Geist', sans-serif;
            font-size: 13px;
            font-weight: 500;
        }
        .plan-name { color: #0b1c30; }
        .plan-users { color: #464554; }
        .plan-progress-track {
            width: 100%;
            height: 8px;
            background-color: #d3e4fe;
            border-radius: 4px;
            margin-bottom: 8px;
        }
        .plan-progress-fill {
            height: 100%;
            border-radius: 4px;
        }
        .plan-revenue {
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
            color: #464554;
            text-align: right;
            margin: 0;
        }
        </style>
        <div class="row mb-4">
            <div class="col-md-8 mb-4 mb-md-0">
                <div class="dashboard-custom-card">
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <h2 class="dashboard-custom-title">{{ __('Recent Activity') }}</h2>
                        <a href="{{ route('order.index') }}" class="dashboard-custom-link">{{ __('View All') }}</a>
                    </div>
                    <div class="timeline-container">
                        <div class="timeline-line"></div>
                        @foreach($recentActivity as $activity)
                        <div class="timeline-item">
                            <div class="timeline-dot-wrapper">
                                <div class="timeline-dot {{ $activity->payment_status == 'success' ? 'text-primary-dot' : ($activity->payment_status == 'pending' ? 'text-tertiary-dot' : 'text-error-dot') }}"></div>
                            </div>
                            <div class="timeline-content">
                                <div>
                                    <p class="timeline-text-main">
                                        <span style="font-weight: 500;">{{ $activity->name }}</span>
                                        {{ __('purchased') }} 
                                        <span style="font-weight: 500;">{{ $activity->plan_name }}</span>
                                    </p>
                                    <p class="timeline-text-sub">{{ $activity->created_at->diffForHumans() }}</p>
                                </div>
                                @if($activity->payment_status == 'success')
                                    <span class="status-badge status-success">{{ ucfirst($activity->payment_status) }}</span>
                                @elseif($activity->payment_status == 'pending')
                                    <span class="status-badge status-pending">{{ ucfirst($activity->payment_status) }}</span>
                                @else
                                    <span class="status-badge status-error">{{ ucfirst($activity->payment_status) }}</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                        @if($recentActivity->isEmpty())
                        <div class="timeline-item">
                            <div class="timeline-dot-wrapper">
                                <div class="timeline-dot" style="background-color: #c7c4d7;"></div>
                            </div>
                            <div class="timeline-content">
                                <p class="timeline-text-main" style="color: #464554;">{{ __('No recent activity found.') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="dashboard-custom-card">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                        <h2 class="dashboard-custom-title">{{ __('Top-Performing Plans') }}</h2>
                    </div>
                    <div>
                        @foreach($topPlans as $index => $plan)
                        @php
                            $colors = ['#4648d4', '#c0c1ff', '#494bd6'];
                            $fillColor = $colors[$index % count($colors)];
                            
                            $maxRevenue = $topPlans->first()->revenue > 0 ? $topPlans->first()->revenue : 1;
                            $percentage = ($plan->revenue / $maxRevenue) * 100;
                        @endphp
                        <div class="plan-item">
                            <div class="plan-item-header">
                                <span class="plan-name">{{ $plan->name }}</span>
                                <span class="plan-users">{{ $plan->users_count }} {{ __('Users') }}</span>
                            </div>
                            <div class="plan-progress-track">
                                <div class="plan-progress-fill" style="width: {{ $percentage }}%; background-color: {{ $fillColor }};"></div>
                            </div>
                            <p class="plan-revenue">
                                @if(env('CURRENCY_SYMBOL'))
                                    {{ env('CURRENCY_SYMBOL') }}
                                @else
                                    $
                                @endif
                                {{ number_format($plan->revenue) }}
                            </p>
                        </div>
                        @endforeach
                        @if($topPlans->isEmpty())
                            <p class="timeline-text-main" style="color: #464554;">{{ __('No plan data available.') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a class="card mb-0 hover:bg-surface-container-high transition-colors group flex-row items-center gap-4 p-6" href="{{ route('store-resource.index') }}" style="border-radius: 12px; cursor: pointer; text-decoration: none;">
                <div style="width: 48px; height: 48px; border-radius: 8px; background: #6063ee; color: #fffbff; display: flex; align-items: center; justify-content: center;" class="group-hover:scale-110 transition-transform flex-shrink-0">
                    <span class="material-symbols-outlined text-[24px]">business</span>
                </div>
                <div>
                    <h3 style="font-family: 'Geist', sans-serif; font-size: 16px; font-weight: 600; color: #0b1c30; margin: 0 0 4px;">{{ __('Store Management') }}</h3>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586; margin: 0;">{{ __('View and edit registered stores') }}</p>
                </div>
            </a>
            <a class="card mb-0 hover:bg-surface-container-high transition-colors group flex-row items-center gap-4 p-6" href="{{ route('plans.index') }}" style="border-radius: 12px; cursor: pointer; text-decoration: none;">
                <div style="width: 48px; height: 48px; border-radius: 8px; background: #dae2fd; color: #131b2e; display: flex; align-items: center; justify-content: center;" class="group-hover:scale-110 transition-transform flex-shrink-0">
                    <span class="material-symbols-outlined text-[24px]">subscriptions</span>
                </div>
                <div>
                    <h3 style="font-family: 'Geist', sans-serif; font-size: 16px; font-weight: 600; color: #0b1c30; margin: 0 0 4px;">{{ __('Plan Management') }}</h3>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586; margin: 0;">{{ __('Configure subscription tiers and pricing') }}</p>
                </div>
            </a>
            <a class="card mb-0 hover:bg-surface-container-high transition-colors group flex-row items-center gap-4 p-6" href="{{ route('coupons.index') }}" style="border-radius: 12px; cursor: pointer; text-decoration: none;">
                <div style="width: 48px; height: 48px; border-radius: 8px; background: #ffdcc5; color: #301400; display: flex; align-items: center; justify-content: center;" class="group-hover:scale-110 transition-transform flex-shrink-0">
                    <span class="material-symbols-outlined text-[24px]">local_activity</span>
                </div>
                <div>
                    <h3 style="font-family: 'Geist', sans-serif; font-size: 16px; font-weight: 600; color: #0b1c30; margin: 0 0 4px;">{{ __('Coupon Management') }}</h3>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586; margin: 0;">{{ __('Create and track promotional codes') }}</p>
                </div>
            </a>
        </div>
    </x-ui.page-container>

@else


    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-[1.5rem] font-semibold text-gray-900" style="font-family: 'Geist', sans-serif; line-height: 40px; letter-spacing: -0.04em; margin: 0;">{{ __('Your overview') }}</h1>
            <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586; margin-top: 2px;">{{ __('Real-time store performance & metrics') }}</p>
        </div>
        <div class="relative timeframe-select-wrap">
            <select class="appearance-none bg-white border border-gray-200 rounded-md py-1.5 pl-3 pr-8 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <option>{{ __('Lifetime') }}</option>
                <option>{{ __('Today') }}</option>
                <option>{{ __('Yesterday') }}</option>
                <option>{{ __('This Week') }}</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Total Sales Card -->
        <div class="dashboard-card p-6 flex flex-col">
            <div class="flex justify-between items-start mb-2">
                <div class="flex items-center text-sm font-medium text-gray-500">
                    {{ __('Total sales') }}
                    <svg class="w-4 h-4 ml-1.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                </div>
                <div class="status-icon-box" style="background: rgba(70, 72, 212, 0.08); color: #4648d4;">
                    <span class="material-symbols-outlined" style="font-size: 18px;">payments</span>
                </div>
            </div>
            <div class="flex items-end justify-between mb-4">
                <h3 class="text-3xl font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">{{ \App\Models\Utility::priceFormat($totle_sale) }}</h3>
                <span class="text-xs text-gray-500 font-semibold mb-1" style="background: #f1f5f9; padding: 2px 8px; border-radius: 12px;">{{ $totle_order }} {{ __('orders') }}</span>
            </div>
            
            <div class="chart-container-wrap">
                <div id="traffic-chart"></div>
            </div>
            
            <div class="mt-4 pt-3 border-t border-gray-100 text-center">
                <a href="{{ route('orders.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 flex items-center justify-center gap-1" style="color: #4648d4 !important;">
                    {{ __('View order history') }} 
                    <span class="material-symbols-outlined" style="font-size: 16px;">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- Store Conversion Rate Card -->
        <div class="dashboard-card p-6 flex flex-col">
            <div class="flex justify-between items-start mb-2">
                <div class="flex items-center text-sm font-medium text-gray-500">
                    {{ __('Store conversion rate') }}
                    <svg class="w-4 h-4 ml-1.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                </div>
                <div class="status-icon-box" style="background: rgba(16, 185, 129, 0.08); color: #10b981;">
                    <span class="material-symbols-outlined" style="font-size: 18px;">analytics</span>
                </div>
            </div>
            <div class="flex items-end justify-between mb-4">
                <h3 class="text-3xl font-bold text-gray-900" style="font-family: 'Plus Jakarta Sans', sans-serif;">0%</h3>
                <span class="text-xs text-gray-500 font-semibold mb-1" style="background: #f1f5f9; padding: 2px 8px; border-radius: 12px;">0 {{ __('sessions') }}</span>
            </div>
            
            <div class="chart-container-wrap">
                <div id="conversion-chart"></div>
            </div>
            
            <div class="mt-4 pt-3 border-t border-gray-100 text-center">
                <a href="{{ route('storeanalytic') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 flex items-center justify-center gap-1" style="color: #4648d4 !important;">
                    {{ __('View analytics') }} 
                    <span class="material-symbols-outlined" style="font-size: 16px;">arrow_forward</span>
                </a>
            </div>
        </div>

        <!-- Store Link & Quick Status -->
        <div class="flex flex-col space-y-4">
            <div class="dashboard-card p-6">
                <div class="flex justify-between items-start mb-3">
                    <div class="text-sm font-semibold text-gray-500">{{ __('Store link') }}</div>
                    <a href="#" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800" style="color: #4648d4 !important;">{{ __('Link domain') }}</a>
                </div>
                <div class="store-link-box">
                    <a href="{{ $store_id['store_url'] ?? '' }}" target="_blank" class="store-link-url flex items-center gap-1">
                        {{ $store_id['store_url'] ?? 'mydukaan.io/virrat' }}
                        <span class="material-symbols-outlined" style="font-size: 14px;">open_in_new</span>
                    </a>
                    <button class="btn-copy-link cp_link" data-link="{{ $store_id['store_url'] ?? '' }}">
                        {{ __('Copy') }}
                    </button>
                </div>
            </div>
            
            <!-- List items -->
            <div class="dashboard-card py-2">
                <div class="divide-y divide-gray-100">
                    <a href="#" class="status-row-item flex items-center justify-between px-5 py-3.5 transition-colors text-decoration-none">
                        <div class="flex items-center">
                            <div class="status-icon-box mr-3" style="background: rgba(79, 70, 229, 0.08); color: #4f46e5;">
                                <span class="material-symbols-outlined" style="font-size: 18px;">shopping_bag</span>
                            </div>
                            <span class="text-sm text-gray-700 font-semibold">{{ __('No new orders pending') }}</span>
                        </div>
                        <span class="material-symbols-outlined text-gray-400" style="font-size: 18px;">chevron_right</span>
                    </a>
                    <a href="#" class="status-row-item flex items-center justify-between px-5 py-3.5 transition-colors text-decoration-none">
                        <div class="flex items-center">
                            <div class="status-icon-box mr-3" style="background: rgba(217, 119, 6, 0.08); color: #d97706;">
                                <span class="material-symbols-outlined" style="font-size: 18px;">local_shipping</span>
                            </div>
                            <span class="text-sm text-gray-700 font-semibold">{{ __('No order to ship today') }}</span>
                        </div>
                        <span class="material-symbols-outlined text-gray-400" style="font-size: 18px;">chevron_right</span>
                    </a>
                    <a href="#" class="status-row-item flex items-center justify-between px-5 py-3.5 transition-colors text-decoration-none">
                        <div class="flex items-center">
                            <div class="status-icon-box mr-3" style="background: rgba(220, 38, 38, 0.08); color: #dc2626;">
                                <span class="material-symbols-outlined" style="font-size: 18px;">shopping_cart_off</span>
                            </div>
                            <span class="text-sm text-gray-700 font-semibold">{{ __('No abandoned order') }}</span>
                        </div>
                        <span class="material-symbols-outlined text-gray-400" style="font-size: 18px;">chevron_right</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Shortcuts -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900" style="font-family: 'Geist', sans-serif; letter-spacing: -0.02em;">{{ __('Shortcuts') }}</h2>
            <button class="text-gray-400 hover:text-gray-600">
                <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
            </button>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('product.create') }}" class="btn-add-shortcut flex items-center justify-center p-6 transition-colors">
                <span class="material-symbols-outlined mr-2" style="font-size: 18px;">add</span>
                <span class="font-semibold text-sm">{{ __('Add new shortcut') }}</span>
            </a>
        </div>
    </div>

@endif
@endsection
@push('script-page')
@if (\Auth::user()->type == 'super admin')
<script>
    (function() {
        var options = {
            chart: {
                height: 250,
                type: 'area',
                toolbar: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2,
                curve: 'smooth'
            },


            series: [{
                name: "{{ __('Order') }}",
                data: {!! json_encode($chartData['data']) !!}
            }],

            xaxis: {
                axisBorder: {
                    show: !1
                },
                type: "MMM",
                categories: {!! json_encode($chartData['label']) !!},
                title: {
                    text: '{{ __("Days") }}'
                }
            },
            colors: ['#e83e8c'],

            grid: {
                strokeDashArray: 4,
            },
            legend: {
                show: false,
            },
            // markers: {
            //     size: 4,
            //     colors: ['#FFA21D'],
            //     opacity: 0.9,
            //     strokeWidth: 2,
            //     hover: {
            //         size: 7,
            //     }
            // },
            yaxis: {
                tickAmount: 3,
                title: {
                text: '{{ __("Amount") }}'
            },
            }
        };
        var chart = new ApexCharts(document.querySelector("#plan_order"), options);
        chart.render();
    })();

</script>
@else
<script>
    $(document).ready(function() {
        $('.cp_link').on('click', function() {
            var value = $(this).attr('data-link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();
            show_toastr('Success', '{{ __('Link copied') }}', 'success')
        });
    });
    (function () {
        var options = {
            chart: {
                height: 140,
                type: 'area',
                sparkline: {
                    enabled: false
                },
                toolbar: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2,
                curve: 'smooth'
            },
            series: [{
                name: "{{ __('Order') }}",
                data: {!! json_encode($chartData['data']) !!}
            }],
            xaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                categories: {!! json_encode($chartData['label']) !!},
                labels: {
                    style: {
                        colors: '#767586',
                        fontSize: '10px'
                    }
                }
            },
            colors: ['#4648d4'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            grid: {
                borderColor: 'rgba(199, 196, 215, 0.15)',
                strokeDashArray: 4,
            },
            legend: {
                show: false,
            },
            yaxis: {
                tickAmount: 3,
                labels: {
                    style: {
                        colors: '#767586',
                        fontSize: '10px'
                    }
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#traffic-chart"), options);
        chart.render();
    })();

    (function () {
        var options = {
            chart: {
                height: 140,
                type: 'area',
                toolbar: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2,
                curve: 'smooth'
            },
            series: [{
                name: "{{ __('Sessions') }}",
                data: [0, 0, 0, 0, 0, 0, 0]
            }],
            xaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                labels: {
                    style: {
                        colors: '#767586',
                        fontSize: '10px'
                    }
                }
            },
            colors: ['#6063ee'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.3,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            grid: {
                borderColor: 'rgba(199, 196, 215, 0.15)',
                strokeDashArray: 4,
            },
            legend: {
                show: false,
            },
            yaxis: {
                tickAmount: 3,
                labels: {
                    style: {
                        colors: '#767586',
                        fontSize: '10px'
                    }
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#conversion-chart"), options);
        chart.render();
    })();


    (function () {
        var options = {
            series: [{{ round($storage_limit,2) }}],
            chart: {
                height: 600,
                type: 'radialBar',
                offsetY: -20,
                sparkline: {
                    enabled: true
                }
            },
            plotOptions: {
                radialBar: {
                    startAngle: -90,
                    endAngle: 90,
                    track: {
                        background: "#e7e7e7",
                        strokeWidth: '97%',
                        margin: 5, // margin is in pixels
                    },
                    dataLabels: {
                        name: {
                            show: true
                        },
                        value: {
                            offsetY: -50,
                            fontSize: '20px'
                        }
                    }
                }
            },
            grid: {
                padding: {
                    top: -10
                }
            },
            colors: ["#6FD943"],
            labels: ['Used'],
            responsive: [{
                breakpoint: 1300, // Maximum screen width for this rule
                options: {
                    chart: {
                        width: '100%',
                        height:'400px'// Set width to 100% for responsiveness
                    },
                    legend: {
                        position: 'bottom' // Position legend at the bottom
                    }
                },
                // breakpoint: 380, // Maximum screen width for this rule
                // options: {
                //     chart: {
                //         width: '100%',
                //         height:'300px'// Set width to 100% for responsiveness
                //     },
                //     legend: {
                //         position: 'bottom' // Position legend at the bottom
                //     }
                // },

            }]
        };
        var chart = new ApexCharts(document.querySelector("#device-chart"), options);
        chart.render();
    })();


    //social sharing
    $(document).ready(function() {
        var customURL = {!! json_encode(url('/store/' . $store_id->slug)) !!};
        $('.Demo1').socialSharingPlugin({
            url: customURL,
            title: $('meta[property="og:title"]').attr('content'),
            description: $('meta[property="og:description"]').attr('content'),
            img: $('meta[property="og:image"]').attr('content'),
            enable: ['whatsapp', 'facebook', 'twitter', 'pinterest', 'linkedin']
        });

        $('.socialShareButton').click(function(e) {
            e.preventDefault();
            $('.sharingButtonsContainer').toggle();
        });
    });
</script>
@endif
@endpush

