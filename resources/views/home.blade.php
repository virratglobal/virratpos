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

    /* ===== Dashboard Customization System ===== */
    .db-widget { position: relative; transition: transform 0.15s, box-shadow 0.15s; }
    .widget-controls { position: absolute; top: 10px; right: 10px; display: flex; gap: 4px; z-index: 20; opacity: 0; pointer-events: none; transition: opacity 0.2s; }
    .dash-customize-active .widget-controls { opacity: 1 !important; pointer-events: all !important; }
    .widget-drag-handle { width: 28px; height: 28px; border-radius: 6px; background: rgba(255,255,255,0.96); border: 1px solid rgba(199,196,215,0.5); display: flex; align-items: center; justify-content: center; cursor: grab; box-shadow: 0 1px 4px rgba(0,0,0,0.1); color: #767586; transition: all 0.15s; }
    .widget-drag-handle:hover { background: #5146e5 !important; color: #fff !important; border-color: #5146e5 !important; }
    .widget-drag-handle:active { cursor: grabbing !important; }
    .widget-actions-btn { width: 28px; height: 28px; border-radius: 6px; background: rgba(255,255,255,0.96); border: 1px solid rgba(199,196,215,0.5); display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 1px 4px rgba(0,0,0,0.1); color: #767586; transition: all 0.15s; padding: 0; }
    .widget-actions-btn:hover { background: #f1f5f9; color: #0b1c30; }
    .widget-actions-dropdown { position: absolute; top: 32px; right: 0; min-width: 155px; background: #fff; border: 1px solid rgba(199,196,215,0.3); border-radius: 8px; box-shadow: 0 4px 16px rgba(0,0,0,0.1); padding: 4px; display: none; z-index: 200; }
    .widget-actions-dropdown.wad-open { display: block; }
    .widget-actions-dropdown button { display: block; width: 100%; text-align: left; padding: 8px 12px; font-family: 'Inter', sans-serif; font-size: 13px; color: #464554; background: none; border: none; border-radius: 6px; cursor: pointer; transition: background 0.1s; }
    .widget-actions-dropdown button:hover { background: #f1f5f9; }
    .dash-customize-active .db-widget .db-card-inner { outline: 2px dashed rgba(81,70,229,0.18) !important; outline-offset: 2px !important; border-radius: 16px !important; }
    .sortable-ghost { opacity: 0.5; }
    .sortable-drag { box-shadow: 0 20px 60px rgba(0,0,0,0.16) !important; transform: scale(1.012) !important; z-index: 9999 !important; }
    .db-widget.widget-hidden { display: none !important; }
    #customize-hint-bar { background: linear-gradient(135deg,#eeeefd,#e6eeff); border: 1px solid rgba(81,70,229,0.22); border-radius: 12px; padding: 12px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; animation: dbSlideDown 0.22s ease; }
    @keyframes dbSlideDown { from { opacity: 0; transform: translateY(-6px); } to { opacity: 1; transform: translateY(0); } }
    #manage-widgets-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.38); z-index: 1040; backdrop-filter: blur(2px); }
    #manage-widgets-panel { position: fixed; top: 0; right: -360px; width: 340px; height: 100vh; background: #fff; z-index: 1050; box-shadow: -4px 0 32px rgba(0,0,0,0.14); transition: right 0.26s cubic-bezier(0.4,0,0.2,1); overflow-y: auto; }
    #manage-widgets-panel.panel-open { right: 0; }
    #reset-modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.42); z-index: 1060; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(2px); }
    #reset-modal { background: #fff; border-radius: 16px; padding: 28px; max-width: 380px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.2); }
    .wg-toggle { position: relative; display: inline-block; width: 40px; height: 22px; flex-shrink: 0; }
    .wg-toggle input { opacity: 0; width: 0; height: 0; }
    .wg-toggle-track { position: absolute; inset: 0; background: #c7c4d7; border-radius: 11px; cursor: pointer; transition: background 0.2s; }
    .wg-toggle input:checked + .wg-toggle-track { background: #5146e5; }
    .wg-toggle-track::after { content: ''; position: absolute; left: 3px; top: 3px; width: 16px; height: 16px; background: #fff; border-radius: 50%; transition: transform 0.2s; }
    .wg-toggle input:checked + .wg-toggle-track::after { transform: translateX(18px); }
    #dashboard-widgets-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; margin-bottom: 28px; align-items: start; }
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

    {{-- ===================== PHP DATA CALCULATIONS ===================== --}}
    @php
        $store_id_data = $store_id;
        
        // Dynamic calculations for KPI comparison
        $currentWeekSales = $orders->filter(function($o) {
            return $o->created_at >= now()->subDays(7);
        })->sum('price');
        
        $previousWeekSales = $orders->filter(function($o) {
            return $o->created_at >= now()->subDays(14) && $o->created_at < now()->subDays(7);
        })->sum('price');
        
        $salesGrowth = $previousWeekSales > 0 
            ? (($currentWeekSales - $previousWeekSales) / $previousWeekSales) * 100 
            : ($currentWeekSales > 0 ? 100 : 0);

        $currentWeekOrders = $orders->filter(function($o) {
            return $o->created_at >= now()->subDays(7);
        })->count();
        
        $previousWeekOrders = $orders->filter(function($o) {
            return $o->created_at >= now()->subDays(14) && $o->created_at < now()->subDays(7);
        })->count();
        
        $ordersGrowth = $previousWeekOrders > 0 
            ? (($currentWeekOrders - $previousWeekOrders) / $previousWeekOrders) * 100 
            : ($currentWeekOrders > 0 ? 100 : 0);

        // AOV
        $currentAOV = $totle_order > 0 ? $totle_sale / $totle_order : 0;
        
        $currentWeekAOV = $currentWeekOrders > 0 ? $currentWeekSales / $currentWeekOrders : 0;
        $previousWeekAOV = $previousWeekOrders > 0 ? $previousWeekSales / $previousWeekOrders : 0;
        
        $aovGrowth = $previousWeekAOV > 0 
            ? (($currentWeekAOV - $previousWeekAOV) / $previousWeekAOV) * 100 
            : ($currentWeekAOV > 0 ? 100 : 0);

        // Visitor Sessions & Conversion
        $visitorCount = \DB::table('visitor')->where('slug', $store_id_data->slug)->count();
        $conversionRate = $visitorCount > 0 ? ($totle_order / $visitorCount) * 100 : 0;

        // Order status counts
        $completedOrdersCount = $orders->filter(function($o) {
            return in_array(strtolower($o->status), ['delivered', 'completed', 'approved']);
        })->count();
        
        $pendingOrdersCount = $orders->filter(function($o) {
            return strtolower($o->status) == 'pending';
        })->count();
        
        $cancelledOrdersCount = $orders->filter(function($o) {
            return in_array(strtolower($o->status), ['cancelled', 'canceled', 'rejected']);
        })->count();

        $completedOrdersPercent = $totle_order > 0 ? ($completedOrdersCount / $totle_order) * 100 : 0;
        $pendingOrdersPercent = $totle_order > 0 ? ($pendingOrdersCount / $totle_order) * 100 : 0;
        $cancelledOrdersPercent = $totle_order > 0 ? ($cancelledOrdersCount / $totle_order) * 100 : 0;

        // Low stock count
        $lowStockCount = \App\Models\Product::where('store_id', \Auth::user()->current_store)
            ->where('quantity', '<=', 3)
            ->count();
    @endphp

    {{-- ===================== DASHBOARD HEADER ===================== --}}
    <div style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 28px;">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div>
                <h1 style="font-family: 'Geist', sans-serif; font-size: 1.75rem; font-weight: 600; color: #0b1c30; margin: 0; line-height: 1.2; letter-spacing: -0.04em;">
                    <span id="greetings">{{ __('Good morning') }}</span>, {{ \Auth::user()->name }}
                </h1>
                <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586; margin: 4px 0 0;">
                    {{ __("Here's what's happening with your store today.") }}
                </p>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                {{-- Date Selector placeholder --}}
                <div style="position: relative;">
                    <span class="material-symbols-outlined" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); font-size: 16px; color: #a0a0b0; pointer-events: none;">calendar_today</span>
                    <select disabled style="padding: 8px 32px 8px 34px; border: 1px solid rgba(199,196,215,0.4); border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 13px; color: #464554; background: #fff; appearance: none; outline: none; cursor: not-allowed; width: 140px;">
                        <option>{{ __('Lifetime') }}</option>
                    </select>
                    <span class="material-symbols-outlined" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); font-size: 16px; color: #a0a0b0; pointer-events: none;">expand_more</span>
                </div>
                {{-- Refresh Button --}}
                <button type="button" onclick="window.location.reload();"
                        style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #e5eeff; color: #4648d4; border: none; border-radius: 8px; cursor: pointer; transition: all 0.2s;"
                        onmouseover="this.style.background='#dce9ff'; this.style.transform='rotate(45deg)';" onmouseout="this.style.background='#e5eeff'; this.style.transform='none';">
                    <span class="material-symbols-outlined" style="font-size: 20px;">refresh</span>
                </button>

                {{-- Customize Button --}}
                <button id="btn-customize-dashboard" type="button" onclick="dbEnterCustomize()"
                        style="display: inline-flex; align-items: center; gap: 6px; padding: 0 14px; height: 36px; background: #fff; color: #464554; border: 1px solid rgba(199,196,215,0.5); border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;"
                        onmouseover="this.style.borderColor='#5146e5'; this.style.color='#5146e5'; this.style.background='#f5f3ff';" onmouseout="this.style.borderColor='rgba(199,196,215,0.5)'; this.style.color='#464554'; this.style.background='#fff';">
                    <span class="material-symbols-outlined" style="font-size: 16px;">tune</span>
                    {{ __('Customize') }}
                </button>

                {{-- Done Button (hidden until customize mode) --}}
                <button id="btn-done-customize" type="button" onclick="dbExitCustomize()"
                        style="display: none; align-items: center; gap: 6px; padding: 0 14px; height: 36px; background: #5146e5; color: #fff; border: none; border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s;"
                        onmouseover="this.style.background='#3f36c8';" onmouseout="this.style.background='#5146e5';">
                    <span class="material-symbols-outlined" style="font-size: 16px;">check</span>
                    {{ __('Done') }}
                </button>
            </div>
        </div>
    </div>

    {{-- ===================== CUSTOMIZE HINT BAR ===================== --}}
    <div id="customize-hint-bar" style="display:none;">
        <div style="display: flex; align-items: center; gap: 8px;">
            <span class="material-symbols-outlined" style="font-size: 18px; color: #5146e5;">drag_indicator</span>
            <span style="font-family: 'Inter', sans-serif; font-size: 13px; color: #3a3060; font-weight: 500;">{{ __('Drag and drop widgets to arrange your dashboard.') }}</span>
        </div>
        <div style="display: flex; align-items: center; gap: 8px;">
            <button type="button" onclick="dbOpenManagePanel()"
                    style="display: inline-flex; align-items: center; gap: 5px; padding: 0 12px; height: 30px; background: rgba(81,70,229,0.1); color: #5146e5; border: 1px solid rgba(81,70,229,0.25); border-radius: 6px; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.15s;"
                    onmouseover="this.style.background='rgba(81,70,229,0.18)';" onmouseout="this.style.background='rgba(81,70,229,0.1)';">
                <span class="material-symbols-outlined" style="font-size: 14px;">widgets</span>
                {{ __('Manage Widgets') }}
            </button>
            <button type="button" onclick="dbOpenResetModal()"
                    style="display: inline-flex; align-items: center; gap: 5px; padding: 0 12px; height: 30px; background: transparent; color: #767586; border: 1px solid rgba(199,196,215,0.5); border-radius: 6px; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; cursor: pointer; transition: all 0.15s;"
                    onmouseover="this.style.background='#f1f5f9'; this.style.color='#464554';" onmouseout="this.style.background='transparent'; this.style.color='#767586';">
                <span class="material-symbols-outlined" style="font-size: 14px;">restart_alt</span>
                {{ __('Reset to Default') }}
            </button>
        </div>
    </div>

    {{-- ===================== MANAGE WIDGETS PANEL ===================== --}}
    <div id="manage-widgets-overlay" style="display:none;" onclick="dbCloseManagePanel()"></div>
    <div id="manage-widgets-panel">
        <div style="padding: 20px 24px; border-bottom: 1px solid rgba(199,196,215,0.15); display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; background: #fff; z-index: 1;">
            <div>
                <h3 style="font-family: 'Geist', sans-serif; font-size: 16px; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('Dashboard Widgets') }}</h3>
                <p style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586; margin: 3px 0 0;">{{ __('Show or hide widgets') }}</p>
            </div>
            <button onclick="dbCloseManagePanel()" style="width: 32px; height: 32px; border: 1px solid rgba(199,196,215,0.4); border-radius: 8px; background: #f8fafc; cursor: pointer; display: flex; align-items: center; justify-content: center; color: #767586; font-size: 16px; transition: all 0.15s;" onmouseover="this.style.background='#f1f5f9';" onmouseout="this.style.background='#f8fafc';">&#x2715;</button>
        </div>
        <div style="padding: 16px 24px; display: flex; flex-direction: column; gap: 4px;" id="manage-widget-list">
            @php
            $dbWidgets = [
                ['id'=>'kpi-row','label'=>__('KPI Cards'),'icon'=>'bar_chart'],
                ['id'=>'sales-overview','label'=>__('Sales Overview'),'icon'=>'show_chart'],
                ['id'=>'order-activity','label'=>__('Order Activity'),'icon'=>'donut_small'],
                ['id'=>'store-activity','label'=>__('Store Activity'),'icon'=>'store'],
                ['id'=>'store-link','label'=>__('Your Store'),'icon'=>'open_in_new'],
                ['id'=>'recent-orders','label'=>__('Recent Orders'),'icon'=>'receipt_long'],
                ['id'=>'quick-actions','label'=>__('Quick Actions'),'icon'=>'flash_on'],
            ];
            @endphp
            @foreach($dbWidgets as $dbw)
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; border-radius: 10px; background: #fafafa; border: 1px solid rgba(199,196,215,0.15);">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #eff0fe; color: #4648d4; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined" style="font-size: 16px;">{{ $dbw['icon'] }}</span>
                    </div>
                    <span style="font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500; color: #0b1c30;">{{ $dbw['label'] }}</span>
                </div>
                <label class="wg-toggle">
                    <input type="checkbox" id="wg-toggle-{{ $dbw['id'] }}" checked onchange="dbToggleWidget('{{ $dbw['id'] }}', this.checked)">
                    <span class="wg-toggle-track"></span>
                </label>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ===================== RESET CONFIRMATION MODAL ===================== --}}
    <div id="reset-modal-overlay" style="display:none;">
        <div id="reset-modal">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                <div style="width: 40px; height: 40px; border-radius: 10px; background: #fff3e0; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <span class="material-symbols-outlined" style="font-size: 22px; color: #904900;">restart_alt</span>
                </div>
                <div>
                    <h3 style="font-family: 'Geist', sans-serif; font-size: 16px; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('Reset dashboard layout?') }}</h3>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586; margin: 4px 0 0;">{{ __('This will restore the default widget arrangement.') }}</p>
                </div>
            </div>
            <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 20px;">
                <button onclick="dbCloseResetModal()" style="padding: 0 20px; height: 38px; background: #f1f5f9; color: #464554; border: 1px solid rgba(199,196,215,0.4); border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.15s;" onmouseover="this.style.background='#e2e8f0';" onmouseout="this.style.background='#f1f5f9';">{{ __('Cancel') }}</button>
                <button onclick="dbResetDashboard()" style="padding: 0 20px; height: 38px; background: #ba1a1a; color: #fff; border: none; border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.15s;" onmouseover="this.style.background='#9b1212';" onmouseout="this.style.background='#ba1a1a';">{{ __('Reset') }}</button>
            </div>
        </div>
    </div>

    {{-- ===================== WIDGETS GRID ===================== --}}
    <div id="dashboard-widgets-grid">

    {{-- ======== WIDGET: KPI CARDS ======== --}}
    <div class="db-widget" data-widget-id="kpi-row" style="grid-column: span 3;">
        <div class="widget-controls">
            <div class="widget-drag-handle" title="{{ __('Drag to reorder') }}"><span class="material-symbols-outlined" style="font-size: 16px;">drag_indicator</span></div>
            <div style="position: relative;">
                <button class="widget-actions-btn" onclick="dbWidgetMenu(this)" title="{{ __('Widget options') }}"><span class="material-symbols-outlined" style="font-size: 16px;">more_vert</span></button>
                <div class="widget-actions-dropdown">
                    <button onclick="dbHideWidget('kpi-row')"><span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle; margin-right: 6px;">visibility_off</span>{{ __('Hide widget') }}</button>
                </div>
            </div>
        </div>
        <div class="db-card-inner">
    {{-- ===================== KPI ROW ===================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" style="margin-bottom: 0;">

        {{-- Total Sales Card --}}
        <div class="dashboard-card" style="border: 1px solid rgba(199,196,215,0.2); border-radius: 16px; padding: 24px; display: flex; flex-direction: column; background: #fff; box-shadow: 0 1px 8px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px;">
                <span style="font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500; color: #767586;">{{ __('Total Sales') }}</span>
                <div style="width: 36px; height: 36px; border-radius: 8px; background: #eff0fe; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="font-size: 18px; color: #4648d4;">payments</span>
                </div>
            </div>
            <h3 style="font-family: 'Geist', sans-serif; font-size: 1.75rem; font-weight: 700; color: #0b1c30; margin: 0 0 6px; line-height: 1.1;">
                {{ \App\Models\Utility::priceFormat($totle_sale) }}
            </h3>
            <div style="display: flex; align-items: center; gap: 6px;">
                @if($salesGrowth >= 0)
                    <span style="color: #1a7431; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 2px;">
                        <span class="material-symbols-outlined" style="font-size: 14px;">arrow_upward</span>
                        +{{ number_format($salesGrowth, 1) }}%
                    </span>
                @else
                    <span style="color: #ba1a1a; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 2px;">
                        <span class="material-symbols-outlined" style="font-size: 14px;">arrow_downward</span>
                        {{ number_format($salesGrowth, 1) }}%
                    </span>
                @endif
                <span style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586;">{{ __('vs last week') }}</span>
            </div>
        </div>

        {{-- Total Orders Card --}}
        <div class="dashboard-card" style="border: 1px solid rgba(199,196,215,0.2); border-radius: 16px; padding: 24px; display: flex; flex-direction: column; background: #fff; box-shadow: 0 1px 8px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px;">
                <span style="font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500; color: #767586;">{{ __('Total Orders') }}</span>
                <div style="width: 36px; height: 36px; border-radius: 8px; background: #e8f5e9; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="font-size: 18px; color: #1a7431;">shopping_bag</span>
                </div>
            </div>
            <h3 style="font-family: 'Geist', sans-serif; font-size: 1.75rem; font-weight: 700; color: #0b1c30; margin: 0 0 6px; line-height: 1.1;">
                {{ $totle_order }}
            </h3>
            <div style="display: flex; align-items: center; gap: 6px;">
                @if($ordersGrowth >= 0)
                    <span style="color: #1a7431; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 2px;">
                        <span class="material-symbols-outlined" style="font-size: 14px;">arrow_upward</span>
                        +{{ number_format($ordersGrowth, 1) }}%
                    </span>
                @else
                    <span style="color: #ba1a1a; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 2px;">
                        <span class="material-symbols-outlined" style="font-size: 14px;">arrow_downward</span>
                        {{ number_format($ordersGrowth, 1) }}%
                    </span>
                @endif
                <span style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586;">{{ __('vs last week') }}</span>
            </div>
        </div>

        {{-- AOV Card --}}
        <div class="dashboard-card" style="border: 1px solid rgba(199,196,215,0.2); border-radius: 16px; padding: 24px; display: flex; flex-direction: column; background: #fff; box-shadow: 0 1px 8px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px;">
                <span style="font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500; color: #767586;">{{ __('Average Order Value') }}</span>
                <div style="width: 36px; height: 36px; border-radius: 8px; background: #fff3e0; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="font-size: 18px; color: #904900;">account_balance_wallet</span>
                </div>
            </div>
            <h3 style="font-family: 'Geist', sans-serif; font-size: 1.75rem; font-weight: 700; color: #0b1c30; margin: 0 0 6px; line-height: 1.1;">
                {{ \App\Models\Utility::priceFormat($currentAOV) }}
            </h3>
            <div style="display: flex; align-items: center; gap: 6px;">
                @if($aovGrowth >= 0)
                    <span style="color: #1a7431; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 2px;">
                        <span class="material-symbols-outlined" style="font-size: 14px;">arrow_upward</span>
                        +{{ number_format($aovGrowth, 1) }}%
                    </span>
                @else
                    <span style="color: #ba1a1a; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 2px;">
                        <span class="material-symbols-outlined" style="font-size: 14px;">arrow_downward</span>
                        {{ number_format($aovGrowth, 1) }}%
                    </span>
                @endif
                <span style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586;">{{ __('vs last week') }}</span>
            </div>
        </div>

        {{-- Conversion Rate Card --}}
        <div class="dashboard-card" style="border: 1px solid rgba(199,196,215,0.2); border-radius: 16px; padding: 24px; display: flex; flex-direction: column; background: #fff; box-shadow: 0 1px 8px rgba(0,0,0,0.02);">
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 12px;">
                <span style="font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500; color: #767586;">{{ __('Conversion Rate') }}</span>
                <div style="width: 36px; height: 36px; border-radius: 8px; background: #e0f2f1; display: flex; align-items: center; justify-content: center;">
                    <span class="material-symbols-outlined" style="font-size: 18px; color: #00796b;">query_stats</span>
                </div>
            </div>
            <h3 style="font-family: 'Geist', sans-serif; font-size: 1.75rem; font-weight: 700; color: #0b1c30; margin: 0 0 6px; line-height: 1.1;">
                {{ number_format($conversionRate, 2) }}%
            </h3>
            <div style="display: flex; align-items: center; gap: 6px;">
                <span style="font-family: 'Inter', sans-serif; font-size: 12px; color: #00796b; font-weight: 600;">
                    {{ number_format($visitorCount) }} {{ __('sessions') }}
                </span>
            </div>
        </div>

    </div>{{-- /KPI grid --}}
    </div>{{-- /db-card-inner kpi-row --}}
    </div>{{-- /db-widget kpi-row --}}

    {{-- ======== WIDGET: SALES OVERVIEW ======== --}}
    <div class="db-widget" data-widget-id="sales-overview" style="grid-column: span 2;">
        <div class="widget-controls">
            <div class="widget-drag-handle" title="{{ __('Drag to reorder') }}"><span class="material-symbols-outlined" style="font-size: 16px;">drag_indicator</span></div>
            <div style="position: relative;">
                <button class="widget-actions-btn" onclick="dbWidgetMenu(this)"><span class="material-symbols-outlined" style="font-size: 16px;">more_vert</span></button>
                <div class="widget-actions-dropdown">
                    <button onclick="dbHideWidget('sales-overview')"><span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle; margin-right: 6px;">visibility_off</span>{{ __('Hide widget') }}</button>
                </div>
            </div>
        </div>
        <div class="db-card-inner" style="border: 1px solid rgba(199,196,215,0.2); border-radius: 16px; background: #fff; box-shadow: 0 1px 8px rgba(0,0,0,0.02); display: flex; flex-direction: column;">
            {{-- Header --}}
            <div style="padding: 20px 24px; border-bottom: 1px solid rgba(199,196,215,0.15); display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <h2 style="font-family: 'Geist', sans-serif; font-size: 15px; font-weight: 600; color: #0b1c30; margin: 0; letter-spacing: -0.01em;">
                        {{ __('Sales Overview') }}
                    </h2>
                </div>
                <div style="background: #f1f5f9; border-radius: 6px; padding: 2px; display: inline-flex; gap: 2px;">
                    <button type="button" style="border: none; padding: 4px 10px; background: #fff; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #4648d4; border-radius: 4px; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">7 {{ __('Days') }}</button>
                    <button type="button" disabled style="border: none; padding: 4px 10px; background: transparent; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 500; color: #767586; cursor: not-allowed;">30 {{ __('Days') }}</button>
                </div>
            </div>
            {{-- Graph Area --}}
            <div style="padding: 24px; flex-grow: 1;">
                <div style="display: flex; align-items: baseline; gap: 8px; margin-bottom: 16px;">
                    <span style="font-family: 'Geist', sans-serif; font-size: 1.75rem; font-weight: 700; color: #0b1c30;">
                        {{ \App\Models\Utility::priceFormat($currentWeekSales) }}
                    </span>
                    @if($salesGrowth >= 0)
                        <span style="color: #1a7431; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 2px;">
                            <span class="material-symbols-outlined" style="font-size: 14px;">arrow_upward</span>
                            +{{ number_format($salesGrowth, 1) }}%
                        </span>
                    @else
                        <span style="color: #ba1a1a; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; gap: 2px;">
                            <span class="material-symbols-outlined" style="font-size: 14px;">arrow_downward</span>
                            {{ number_format($salesGrowth, 1) }}%
                        </span>
                    @endif
                </div>
                {{-- ApexCharts Mount --}}
                <div id="sales-overview-chart" style="min-height: 240px; width: 100%;"></div>
            </div>
            {{-- Card Footer --}}
            <div style="padding: 16px 24px; border-top: 1px solid rgba(199,196,215,0.15); text-align: center;">
                <a href="{{ route('storeanalytic') }}" style="font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; color: #5146E5; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;"
                   onmouseover="this.style.color='#3c34ba'" onmouseout="this.style.color='#5146E5'">
                    {{ __('View detailed analytics') }}
                    <span class="material-symbols-outlined" style="font-size: 16px;">arrow_forward</span>
                </a>
            </div>
        </div>
    </div>{{-- /db-widget sales-overview --}}

    {{-- ======== WIDGET: ORDER ACTIVITY ======== --}}
    <div class="db-widget" data-widget-id="order-activity" style="grid-column: span 1;">
        <div class="widget-controls">
            <div class="widget-drag-handle" title="{{ __('Drag to reorder') }}"><span class="material-symbols-outlined" style="font-size: 16px;">drag_indicator</span></div>
            <div style="position: relative;">
                <button class="widget-actions-btn" onclick="dbWidgetMenu(this)"><span class="material-symbols-outlined" style="font-size: 16px;">more_vert</span></button>
                <div class="widget-actions-dropdown">
                    <button onclick="dbHideWidget('order-activity')"><span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle; margin-right: 6px;">visibility_off</span>{{ __('Hide widget') }}</button>
                </div>
            </div>
        </div>
        <div class="db-card-inner" style="border: 1px solid rgba(199,196,215,0.2); border-radius: 16px; background: #fff; box-shadow: 0 1px 8px rgba(0,0,0,0.02); display: flex; flex-direction: column;">
            {{-- Header --}}
            <div style="padding: 20px 24px; border-bottom: 1px solid rgba(199,196,215,0.15); display: flex; align-items: center; justify-content: space-between;">
                <h2 style="font-family: 'Geist', sans-serif; font-size: 15px; font-weight: 600; color: #0b1c30; margin: 0; letter-spacing: -0.01em;">{{ __('Order Activity') }}</h2>
                <span style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586; font-weight: 500;">{{ __('Distribution') }}</span>
            </div>
            {{-- Content --}}
            <div style="padding: 24px; flex-grow: 1; display: flex; flex-direction: column;">
                <div style="display: flex; height: 10px; border-radius: 5px; overflow: hidden; background: #f1f5f9; margin-bottom: 24px; width: 100%;">
                    @if($totle_order > 0)
                        <div style="width: {{ $completedOrdersPercent }}%; background: #10b981;" title="Completed"></div>
                        <div style="width: {{ $pendingOrdersPercent }}%; background: #f59e0b;" title="Pending"></div>
                        <div style="width: {{ $cancelledOrdersPercent }}%; background: #ef4444;" title="Cancelled"></div>
                    @else
                        <div style="width: 100%; background: #e2e8f0;" title="No orders"></div>
                    @endif
                </div>
                <div style="display: flex; flex-direction: column; gap: 16px; flex-grow: 1; justify-content: center;">
                    <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px;">
                        <span style="font-family: 'Inter', sans-serif; font-size: 13px; color: #464554; font-weight: 600;">{{ __('Total Orders') }}</span>
                        <span style="font-family: 'Geist', sans-serif; font-size: 14px; font-weight: 700; color: #0b1c30;">{{ $totle_order }}</span>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #10b981; display: inline-block;"></span>
                            <span style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586;">{{ __('Completed') }}</span>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 600; color: #0b1c30; display: block;">{{ $completedOrdersCount }}</span>
                            <span style="font-family: 'Inter', sans-serif; font-size: 11px; color: #767586; display: block;">{{ number_format($completedOrdersPercent, 1) }}%</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #f59e0b; display: inline-block;"></span>
                            <span style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586;">{{ __('Pending') }}</span>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 600; color: #0b1c30; display: block;">{{ $pendingOrdersCount }}</span>
                            <span style="font-family: 'Inter', sans-serif; font-size: 11px; color: #767586; display: block;">{{ number_format($pendingOrdersPercent, 1) }}%</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="width: 8px; height: 8px; border-radius: 50%; background: #ef4444; display: inline-block;"></span>
                            <span style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586;">{{ __('Cancelled') }}</span>
                        </div>
                        <div style="text-align: right;">
                            <span style="font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 600; color: #0b1c30; display: block;">{{ $cancelledOrdersCount }}</span>
                            <span style="font-family: 'Inter', sans-serif; font-size: 11px; color: #767586; display: block;">{{ number_format($cancelledOrdersPercent, 1) }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>{{-- /db-widget order-activity --}}


    {{-- ======== WIDGET: STORE ACTIVITY ======== --}}
    <div class="db-widget" data-widget-id="store-activity" style="grid-column: span 2;">
        <div class="widget-controls">
            <div class="widget-drag-handle" title="{{ __('Drag to reorder') }}"><span class="material-symbols-outlined" style="font-size: 16px;">drag_indicator</span></div>
            <div style="position: relative;">
                <button class="widget-actions-btn" onclick="dbWidgetMenu(this)"><span class="material-symbols-outlined" style="font-size: 16px;">more_vert</span></button>
                <div class="widget-actions-dropdown">
                    <button onclick="dbHideWidget('store-activity')"><span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle; margin-right: 6px;">visibility_off</span>{{ __('Hide widget') }}</button>
                </div>
            </div>
        </div>
        <div class="db-card-inner" style="border: 1px solid rgba(199,196,215,0.2); border-radius: 16px; background: #fff; box-shadow: 0 1px 8px rgba(0,0,0,0.02); display: flex; flex-direction: column;">
            
            {{-- Header --}}
            <div style="padding: 20px 24px; border-bottom: 1px solid rgba(199,196,215,0.15);">
                <h2 style="font-family: 'Geist', sans-serif; font-size: 15px; font-weight: 600; color: #0b1c30; margin: 0; letter-spacing: -0.01em;">
                    {{ __('Store Activity') }}
                </h2>
            </div>

            {{-- Activity items list --}}
            <div style="display: flex; flex-direction: column; width: 100%;">
                
                {{-- Pending Orders --}}
                <a href="{{ route('orders.index') }}" class="status-row-item" style="display: flex; align-items: center; justify-content: space-between; padding: 16px 24px; text-decoration: none; border-bottom: 1px solid rgba(199, 196, 215, 0.1);">
                    <div style="display: flex; align-items: center;">
                        <div class="status-icon-box" style="background: rgba(79, 70, 229, 0.08); color: #4f46e5; margin-right: 16px; width: 36px; height: 36px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center;">
                            <span class="material-symbols-outlined" style="font-size: 18px;">shopping_bag</span>
                        </div>
                        <div>
                            <span style="font-family: 'Inter', sans-serif; font-size: 14px; text-decoration: none; color: #0b1c30; font-weight: 600; display: block;">{{ __('Pending Orders') }}</span>
                            <span style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586; display: block; margin-top: 1px;">{{ $pendingOrdersCount }} {{ __('orders awaiting processing') }}</span>
                        </div>
                    </div>
                    <span class="material-symbols-outlined" style="font-size: 18px; color: #a0a0b0;">chevron_right</span>
                </a>

                {{-- Shipped / Delivered Orders --}}
                <a href="{{ route('orders.index') }}" class="status-row-item" style="display: flex; align-items: center; justify-content: space-between; padding: 16px 24px; text-decoration: none; border-bottom: 1px solid rgba(199, 196, 215, 0.1);">
                    <div style="display: flex; align-items: center;">
                        <div class="status-icon-box" style="background: rgba(16, 185, 129, 0.08); color: #10b981; margin-right: 16px; width: 36px; height: 36px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center;">
                            <span class="material-symbols-outlined" style="font-size: 18px;">local_shipping</span>
                        </div>
                        <div>
                            <span style="font-family: 'Inter', sans-serif; font-size: 14px; text-decoration: none; color: #0b1c30; font-weight: 600; display: block;">{{ __('Delivered Orders') }}</span>
                            <span style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586; display: block; margin-top: 1px;">{{ $completedOrdersCount }} {{ __('orders completed/delivered') }}</span>
                        </div>
                    </div>
                    <span class="material-symbols-outlined" style="font-size: 18px; color: #a0a0b0;">chevron_right</span>
                </a>

                {{-- Low Stock Products --}}
                <a href="{{ route('product.index') }}" class="status-row-item" style="display: flex; align-items: center; justify-content: space-between; padding: 16px 24px; text-decoration: none;">
                    <div style="display: flex; align-items: center;">
                        <div class="status-icon-box" style="background: rgba(245, 158, 11, 0.08); color: #f59e0b; margin-right: 16px; width: 36px; height: 36px; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center;">
                            <span class="material-symbols-outlined" style="font-size: 18px;">warning</span>
                        </div>
                        <div>
                            <span style="font-family: 'Inter', sans-serif; font-size: 14px; text-decoration: none; color: #0b1c30; font-weight: 600; display: block;">{{ __('Low Stock Products') }}</span>
                            <span style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586; display: block; margin-top: 1px;">
                                @if($lowStockCount > 0)
                                    <span style="color: #f59e0b; font-weight: 600;">{{ $lowStockCount }} {{ __('products need attention') }}</span>
                                @else
                                    {{ __('All product stocks are healthy') }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <span class="material-symbols-outlined" style="font-size: 18px; color: #a0a0b0;">chevron_right</span>
                </a>

            </div>

        </div>
    </div>{{-- /db-widget store-activity --}}

    {{-- ======== WIDGET: STORE LINK ======== --}}
    <div class="db-widget" data-widget-id="store-link" style="grid-column: span 1;">
        <div class="widget-controls">
            <div class="widget-drag-handle" title="{{ __('Drag to reorder') }}"><span class="material-symbols-outlined" style="font-size: 16px;">drag_indicator</span></div>
            <div style="position: relative;">
                <button class="widget-actions-btn" onclick="dbWidgetMenu(this)"><span class="material-symbols-outlined" style="font-size: 16px;">more_vert</span></button>
                <div class="widget-actions-dropdown">
                    <button onclick="dbHideWidget('store-link')"><span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle; margin-right: 6px;">visibility_off</span>{{ __('Hide widget') }}</button>
                </div>
            </div>
        </div>
        <div class="db-card-inner" style="border: 1px solid rgba(199,196,215,0.2); border-radius: 16px; background: #fff; box-shadow: 0 1px 8px rgba(0,0,0,0.02); display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
            
            {{-- Content --}}
            <div style="padding: 24px; flex-grow: 1;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px;">
                    <span style="font-family: 'Geist', sans-serif; font-size: 15px; font-weight: 600; color: #0b1c30;">{{ __('Your Store') }}</span>
                    <span style="display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 12px; background: #e8f5e9; color: #1a7431; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600;">
                        <span style="width: 5px; height: 5px; border-radius: 50%; background: #1a7431;"></span>
                        {{ __('Live') }}
                    </span>
                </div>
                <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586; margin: 0 0 16px;">
                    {{ __('Your online storefront is ready.') }}
                </p>
                
                {{-- Store Link Box --}}
                <div style="background: #f8fafc; border: 1px solid rgba(199, 196, 215, 0.25); border-radius: 8px; padding: 8px 12px; display: flex; align-items: center; justify-content: space-between; gap: 8px; width: 100%;">
                    <a href="{{ $store_id['store_url'] ?? '' }}" target="_blank" style="color: #4648d4; font-weight: 600; font-size: 13px; font-family: 'Inter', sans-serif; text-decoration: none; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 170px;">
                        {{ str_replace(['http://', 'https://'], '', $store_id['store_url'] ?? 'mydukaan.io/virrat') }}
                    </a>
                    <button class="btn-copy-link cp_link" data-link="{{ $store_id['store_url'] ?? '' }}" style="background: #ffffff; border: 1px solid rgba(199,196,215,0.4); color: #464554; border-radius: 6px; padding: 4px 10px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#eff0fe'; this.style.color='#4648d4'; this.style.borderColor='#4648d4';" onmouseout="this.style.background='#ffffff'; this.style.color='#464554'; this.style.borderColor='rgba(199,196,215,0.4)';">
                        {{ __('Copy') }}
                    </button>
                </div>
            </div>

            {{-- Footer link --}}
            <div style="padding: 16px 24px; border-top: 1px solid rgba(199,196,215,0.15); background: #fafafa; text-align: center; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px;">
                <a href="{{ $store_id['store_url'] ?? '' }}" target="_blank" style="font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; color: #5146E5; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;"
                   onmouseover="this.style.color='#3c34ba'" onmouseout="this.style.color='#5146E5'">
                    {{ __('Open store') }}
                    <span class="material-symbols-outlined" style="font-size: 16px;">open_in_new</span>
                </a>
            </div>

        </div>
    </div>{{-- /db-widget store-link --}}

    {{-- ===================== RECENT ORDERS TABLE ===================== --}}
    {{-- ======== WIDGET: RECENT ORDERS ======== --}}
    <div class="db-widget" data-widget-id="recent-orders" style="grid-column: span 3;">
        <div class="widget-controls">
            <div class="widget-drag-handle" title="{{ __('Drag to reorder') }}"><span class="material-symbols-outlined" style="font-size: 16px;">drag_indicator</span></div>
            <div style="position: relative;">
                <button class="widget-actions-btn" onclick="dbWidgetMenu(this)"><span class="material-symbols-outlined" style="font-size: 16px;">more_vert</span></button>
                <div class="widget-actions-dropdown">
                    <button onclick="dbHideWidget('recent-orders')"><span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle; margin-right: 6px;">visibility_off</span>{{ __('Hide widget') }}</button>
                </div>
            </div>
        </div>
        <div class="db-card-inner" style="border: 1px solid rgba(199,196,215,0.2); border-radius: 16px; background: #fff; box-shadow: 0 1px 8px rgba(0,0,0,0.02); overflow: hidden;">
            
            {{-- Card Header --}}
            <div style="padding: 18px 24px; border-bottom: 1px solid rgba(199,196,215,0.15); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                <h2 style="font-family: 'Geist', sans-serif; font-size: 15px; font-weight: 600; color: #0b1c30; margin: 0; letter-spacing: -0.01em;">
                    {{ __('Recent Orders') }}
                </h2>
                <a href="{{ route('orders.index') }}" style="font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; color: #5146E5; text-decoration: none; display: inline-flex; align-items: center; gap: 2px;"
                   onmouseover="this.style.color='#3c34ba'" onmouseout="this.style.color='#5146E5'">
                    {{ __('View all') }}
                    <span class="material-symbols-outlined" style="font-size: 16px;">arrow_forward</span>
                </a>
            </div>

            {{-- Table Content --}}
            @if($new_orders->isEmpty())
                <div style="text-align: center; padding: 48px 24px;">
                    <span class="material-symbols-outlined" style="font-size: 40px; color: #c7c4d7; display: block; margin-bottom: 12px;">shopping_bag</span>
                    <p style="font-family: 'Inter', sans-serif; font-size: 14px; color: #767586; margin: 0;">{{ __('No orders placed yet.') }}</p>
                </div>
            @else
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; min-width: 640px;">
                        <thead>
                            <tr style="border-bottom: 1px solid rgba(199,196,215,0.2);">
                                <th style="padding: 12px 24px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #767586; text-transform: uppercase; letter-spacing: 0.07em; text-align: left; background: #fafafa;">{{ __('Order') }}</th>
                                <th style="padding: 12px 24px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #767586; text-transform: uppercase; letter-spacing: 0.07em; text-align: left; background: #fafafa;">{{ __('Customer') }}</th>
                                <th style="padding: 12px 24px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #767586; text-transform: uppercase; letter-spacing: 0.07em; text-align: center; background: #fafafa;">{{ __('Items') }}</th>
                                <th style="padding: 12px 24px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #767586; text-transform: uppercase; letter-spacing: 0.07em; text-align: right; background: #fafafa;">{{ __('Amount') }}</th>
                                <th style="padding: 12px 24px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #767586; text-transform: uppercase; letter-spacing: 0.07em; text-align: left; background: #fafafa;">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($new_orders as $order)
                                @php
                                    $productsJson = json_decode($order->product, true);
                                    $itemsCount = is_array($productsJson) ? count($productsJson) : 0;
                                    
                                    // Initials for Avatar Fallback
                                    $custName = !empty($order->name) && $order->name !== 'walk-in-customer' ? $order->name : __('Walk-in Customer');
                                    $words = explode(' ', trim($custName));
                                    $initials = '';
                                    foreach ($words as $w) {
                                        $initials .= strtoupper(substr($w, 0, 1));
                                    }
                                    $initials = substr($initials, 0, 2);
                                    if(empty($initials)) {
                                        $initials = 'WC';
                                    }
                                    
                                    $bgColors = ['#eff0fe', '#e8f5e9', '#fff3e0', '#efebe9', '#f3e5f5'];
                                    $textColors = ['#4648d4', '#1a7431', '#904900', '#4e342e', '#6a1b9a'];
                                    $colorIndex = $order->id % count($bgColors);
                                    $bgColor = $bgColors[$colorIndex];
                                    $textColor = $textColors[$colorIndex];
                                @endphp
                                <tr style="border-bottom: 1px solid rgba(199,196,215,0.12); transition: background 0.15s;"
                                    onmouseover="this.style.background='#fafbff'" onmouseout="this.style.background='transparent'">
                                    
                                    {{-- Order ID --}}
                                    <td style="padding: 16px 24px; font-family: monospace; font-size: 13px; font-weight: 600; color: #4648d4; vertical-align: middle;">
                                        #{{ $order->order_id }}
                                    </td>

                                    {{-- Customer details --}}
                                    <td style="padding: 16px 24px; vertical-align: middle;">
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <div style="width: 32px; height: 32px; border-radius: 50%; background: {{ $bgColor }}; color: {{ $textColor }}; display: flex; align-items: center; justify-content: center; font-family: 'Geist', sans-serif; font-size: 11px; font-weight: 600; flex-shrink: 0; border: 1px solid rgba(199,196,215,0.15);">
                                                {{ $initials }}
                                            </div>
                                            <div>
                                                <p style="font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; color: #0b1c30; margin: 0;">{{ $custName }}</p>
                                                <p style="font-family: 'Inter', sans-serif; font-size: 11px; color: #767586; margin: 1px 0 0;">{{ $order->email ?: __('No email') }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Item count --}}
                                    <td style="padding: 16px 24px; text-align: center; vertical-align: middle; font-family: 'Inter', sans-serif; font-size: 13px; color: #464554;">
                                        {{ $itemsCount }} {{ $itemsCount === 1 ? __('item') : __('items') }}
                                    </td>

                                    {{-- Amount --}}
                                    <td style="padding: 16px 24px; text-align: right; vertical-align: middle; font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 600; color: #0b1c30;">
                                        {{ \App\Models\Utility::priceFormat($order->price) }}
                                    </td>

                                    {{-- Status --}}
                                    <td style="padding: 16px 24px; vertical-align: middle;">
                                        @if(in_array(strtolower($order->status), ['delivered', 'completed', 'approved']))
                                            <span style="display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; background: #e8f5e9; color: #1a7431; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 500;">
                                                <span style="width: 5px; height: 5px; border-radius: 50%; background: #1a7431;"></span>
                                                {{ __('Completed') }}
                                            </span>
                                        @elseif(strtolower($order->status) == 'pending')
                                            <span style="display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; background: #fff3e0; color: #904900; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 500;">
                                                <span style="width: 5px; height: 5px; border-radius: 50%; background: #904900;"></span>
                                                {{ __('Pending') }}
                                            </span>
                                        @else
                                            <span style="display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; background: #feeceb; color: #c01d14; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 500;">
                                                <span style="width: 5px; height: 5px; border-radius: 50%; background: #c01d14;"></span>
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>{{-- /db-widget recent-orders --}}

    {{-- ======== WIDGET: QUICK ACTIONS ======== --}}
    <div class="db-widget" data-widget-id="quick-actions" style="grid-column: span 3;">
        <div class="widget-controls">
            <div class="widget-drag-handle" title="{{ __('Drag to reorder') }}"><span class="material-symbols-outlined" style="font-size: 16px;">drag_indicator</span></div>
            <div style="position: relative;">
                <button class="widget-actions-btn" onclick="dbWidgetMenu(this)"><span class="material-symbols-outlined" style="font-size: 16px;">more_vert</span></button>
                <div class="widget-actions-dropdown">
                    <button onclick="dbHideWidget('quick-actions')"><span class="material-symbols-outlined" style="font-size: 14px; vertical-align: middle; margin-right: 6px;">visibility_off</span>{{ __('Hide widget') }}</button>
                </div>
            </div>
        </div>
        <div class="db-card-inner">
            <h2 style="font-family: 'Geist', sans-serif; font-size: 16px; font-weight: 600; color: #0b1c30; margin: 0 0 16px; letter-spacing: -0.02em;">
                {{ __('Quick Actions') }}
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                
                {{-- Create Order --}}
                <a href="{{ route('pos.index') }}" class="group" style="text-decoration: none; border: 1px solid rgba(199,196,215,0.25); border-radius: 12px; background: #fff; padding: 18px; display: flex; flex-direction: column; gap: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.01); transition: all 0.2s;"
                   onmouseover="this.style.borderColor='#4648d4'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='rgba(199,196,215,0.25)'; this.style.transform='none';">
                    <div style="width: 36px; height: 36px; border-radius: 8px; background: #eff0fe; color: #4648d4; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                        <span class="material-symbols-outlined" style="font-size: 18px;">point_of_sale</span>
                    </div>
                    <div>
                        <h3 style="font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 600; color: #0b1c30; margin: 0 0 2px; display: flex; align-items: center; gap: 4px;">
                            {{ __('Create Order') }}
                            <span class="material-symbols-outlined" style="font-size: 14px; opacity: 0; transition: all 0.2s; transform: translateX(-4px);" class="group-hover:opacity-100 group-hover:transform-none">arrow_forward</span>
                        </h3>
                        <p style="font-family: 'Inter', sans-serif; font-size: 11px; color: #767586; margin: 0; line-height: 1.3;">{{ __('Start a new POS order') }}</p>
                    </div>
                </a>

                {{-- Add Product --}}
                <a href="{{ route('product.create') }}" class="group" style="text-decoration: none; border: 1px solid rgba(199,196,215,0.25); border-radius: 12px; background: #fff; padding: 18px; display: flex; flex-direction: column; gap: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.01); transition: all 0.2s;"
                   onmouseover="this.style.borderColor='#4648d4'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='rgba(199,196,215,0.25)'; this.style.transform='none';">
                    <div style="width: 36px; height: 36px; border-radius: 8px; background: #e8f5e9; color: #1a7431; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                        <span class="material-symbols-outlined" style="font-size: 18px;">add_box</span>
                    </div>
                    <div>
                        <h3 style="font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 600; color: #0b1c30; margin: 0 0 2px; display: flex; align-items: center; gap: 4px;">
                            {{ __('Add Product') }}
                            <span class="material-symbols-outlined" style="font-size: 14px; opacity: 0; transition: all 0.2s; transform: translateX(-4px);" class="group-hover:opacity-100 group-hover:transform-none">arrow_forward</span>
                        </h3>
                        <p style="font-family: 'Inter', sans-serif; font-size: 11px; color: #767586; margin: 0; line-height: 1.3;">{{ __('Add a new product') }}</p>
                    </div>
                </a>

                {{-- Add Customer --}}
                <a href="{{ route('customer.index') }}" class="group" style="text-decoration: none; border: 1px solid rgba(199,196,215,0.25); border-radius: 12px; background: #fff; padding: 18px; display: flex; flex-direction: column; gap: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.01); transition: all 0.2s;"
                   onmouseover="this.style.borderColor='#4648d4'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='rgba(199,196,215,0.25)'; this.style.transform='none';">
                    <div style="width: 36px; height: 36px; border-radius: 8px; background: #fff3e0; color: #904900; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                        <span class="material-symbols-outlined" style="font-size: 18px;">person_add</span>
                    </div>
                    <div>
                        <h3 style="font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 600; color: #0b1c30; margin: 0 0 2px; display: flex; align-items: center; gap: 4px;">
                            {{ __('Add Customer') }}
                            <span class="material-symbols-outlined" style="font-size: 14px; opacity: 0; transition: all 0.2s; transform: translateX(-4px);" class="group-hover:opacity-100 group-hover:transform-none">arrow_forward</span>
                        </h3>
                        <p style="font-family: 'Inter', sans-serif; font-size: 11px; color: #767586; margin: 0; line-height: 1.3;">{{ __('Create customer') }}</p>
                    </div>
                </a>

                {{-- View Orders --}}
                <a href="{{ route('orders.index') }}" class="group" style="text-decoration: none; border: 1px solid rgba(199,196,215,0.25); border-radius: 12px; background: #fff; padding: 18px; display: flex; flex-direction: column; gap: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.01); transition: all 0.2s;"
                   onmouseover="this.style.borderColor='#4648d4'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='rgba(199,196,215,0.25)'; this.style.transform='none';">
                    <div style="width: 36px; height: 36px; border-radius: 8px; background: #e0f2f1; color: #00796b; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                        <span class="material-symbols-outlined" style="font-size: 18px;">receipt_long</span>
                    </div>
                    <div>
                        <h3 style="font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 600; color: #0b1c30; margin: 0 0 2px; display: flex; align-items: center; gap: 4px;">
                            {{ __('View Orders') }}
                            <span class="material-symbols-outlined" style="font-size: 14px; opacity: 0; transition: all 0.2s; transform: translateX(-4px);" class="group-hover:opacity-100 group-hover:transform-none">arrow_forward</span>
                        </h3>
                        <p style="font-family: 'Inter', sans-serif; font-size: 11px; color: #767586; margin: 0; line-height: 1.3;">{{ __('Manage recent orders') }}</p>
                    </div>
                </a>

                {{-- Manage Inventory --}}
                <a href="{{ route('product.index') }}" class="group" style="text-decoration: none; border: 1px solid rgba(199,196,215,0.25); border-radius: 12px; background: #fff; padding: 18px; display: flex; flex-direction: column; gap: 12px; box-shadow: 0 1px 4px rgba(0,0,0,0.01); transition: all 0.2s;"
                   onmouseover="this.style.borderColor='#4648d4'; this.style.transform='translateY(-2px)';" onmouseout="this.style.borderColor='rgba(199,196,215,0.25)'; this.style.transform='none';">
                    <div style="width: 36px; height: 36px; border-radius: 8px; background: #efebe9; color: #4e342e; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
                        <span class="material-symbols-outlined" style="font-size: 18px;">inventory_2</span>
                    </div>
                    <div>
                        <h3 style="font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 600; color: #0b1c30; margin: 0 0 2px; display: flex; align-items: center; gap: 4px;">
                            {{ __('Inventory') }}
                            <span class="material-symbols-outlined" style="font-size: 14px; opacity: 0; transition: all 0.2s; transform: translateX(-4px);" class="group-hover:opacity-100 group-hover:transform-none">arrow_forward</span>
                        </h3>
                        <p style="font-family: 'Inter', sans-serif; font-size: 11px; color: #767586; margin: 0; line-height: 1.3;">{{ __('View products and stock') }}</p>
                    </div>
                </a>

            </div>
        </div>
    </div>{{-- /db-widget quick-actions --}}

    </div>{{-- /dashboard-widgets-grid --}}

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
    {{-- Dynamically load SortableJS from CDN --}}
    <script>
        if (typeof Sortable === 'undefined') {
            let script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js';
            document.head.appendChild(script);
        }
    </script>

    <script>
        // Apply persisted dashboard layout immediately on load
        (function() {
            let layoutStr = localStorage.getItem('virrat_dashboard_layout');
            if (!layoutStr) return;
            try {
                let layout = JSON.parse(layoutStr);
                let grid = document.getElementById('dashboard-widgets-grid');
                if (grid) {
                    // Reorder widgets
                    if (layout.widgetOrder && layout.widgetOrder.length) {
                        let widgetsMap = {};
                        grid.querySelectorAll('.db-widget').forEach(w => {
                            widgetsMap[w.getAttribute('data-widget-id')] = w;
                        });
                        layout.widgetOrder.forEach(id => {
                            if (widgetsMap[id]) {
                                grid.appendChild(widgetsMap[id]);
                            }
                        });
                    }
                    // Hide widgets
                    if (layout.hiddenWidgets) {
                        layout.hiddenWidgets.forEach(id => {
                            let w = grid.querySelector(`[data-widget-id="${id}"]`);
                            if (w) {
                                w.classList.add('widget-hidden');
                            }
                            let cb = document.getElementById(`wg-toggle-${id}`);
                            if (cb) {
                                cb.checked = false;
                            }
                        });
                    }
                }
            } catch (e) {
                console.error('Error applying layout on load', e);
            }
        })();

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

        // Sales Overview Chart
        (function () {
            // Safety: Destroy existing instance if present to avoid duplicate canvas renders
            if (window.salesOverviewChart) {
                try {
                    window.salesOverviewChart.destroy();
                } catch(e) {}
            }

            var options = {
                chart: {
                    height: 240,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                    sparkline: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: "{{ __('Sales') }}",
                    data: {!! json_encode($saleData['data']) !!}
                }],
                xaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    categories: {!! json_encode($saleData['label']) !!},
                    labels: {
                        style: {
                            colors: '#767586',
                            fontSize: '11px',
                            fontFamily: 'Inter, sans-serif'
                        }
                    }
                },
                colors: ['#5146e5'],
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
                    tickAmount: 4,
                    labels: {
                        style: {
                            colors: '#767586',
                            fontSize: '11px',
                            fontFamily: 'Inter, sans-serif'
                        }
                    }
                }
            };
            var chartEl = document.querySelector("#sales-overview-chart");
            if (chartEl) {
                window.salesOverviewChart = new ApexCharts(chartEl, options);
                window.salesOverviewChart.render();
            }
        })();

        // social sharing
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

        // Dashboard customization functions
        let sortableInstance = null;

        function dbEnterCustomize() {
            document.body.classList.add('dash-customize-active');
            document.getElementById('customize-hint-bar').style.display = 'flex';
            document.getElementById('btn-customize-dashboard').style.display = 'none';
            document.getElementById('btn-done-customize').style.display = 'inline-flex';
            
            let el = document.getElementById('dashboard-widgets-grid');
            if (el && typeof Sortable !== 'undefined') {
                sortableInstance = new Sortable(el, {
                    handle: '.widget-drag-handle',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    dragClass: 'sortable-drag'
                });
            }
        }

        function dbExitCustomize() {
            document.body.classList.remove('dash-customize-active');
            document.getElementById('customize-hint-bar').style.display = 'none';
            document.getElementById('btn-customize-dashboard').style.display = 'inline-flex';
            document.getElementById('btn-done-customize').style.display = 'none';
            
            if (sortableInstance) {
                sortableInstance.destroy();
                sortableInstance = null;
            }
            dbSaveLayout();
        }

        function dbSaveLayout() {
            let grid = document.getElementById('dashboard-widgets-grid');
            if (!grid) return;
            let widgets = grid.querySelectorAll('.db-widget');
            let order = [];
            widgets.forEach(w => {
                order.push(w.getAttribute('data-widget-id'));
            });
            let hidden = [];
            widgets.forEach(w => {
                if (w.classList.contains('widget-hidden')) {
                    hidden.push(w.getAttribute('data-widget-id'));
                }
            });
            let layout = {
                widgetOrder: order,
                hiddenWidgets: hidden,
                version: 1
            };
            localStorage.setItem('virrat_dashboard_layout', JSON.stringify(layout));
            show_toastr('Success', '{{ __("Dashboard layout saved successfully") }}', 'success');
        }

        function dbToggleWidget(id, show) {
            let w = document.querySelector(`[data-widget-id="${id}"]`);
            if (w) {
                if (show) {
                    w.classList.remove('widget-hidden');
                } else {
                    w.classList.add('widget-hidden');
                }
            }
        }

        function dbHideWidget(id) {
            let w = document.querySelector(`[data-widget-id="${id}"]`);
            if (w) {
                w.classList.add('widget-hidden');
                let cb = document.getElementById(`wg-toggle-${id}`);
                if (cb) {
                    cb.checked = false;
                }
            }
            document.querySelectorAll('.widget-actions-dropdown').forEach(d => {
                d.classList.remove('wad-open');
            });
        }

        function dbWidgetMenu(btn) {
            let dropdown = btn.nextElementSibling;
            document.querySelectorAll('.widget-actions-dropdown').forEach(d => {
                if (d !== dropdown) d.classList.remove('wad-open');
            });
            if (dropdown) {
                dropdown.classList.toggle('wad-open');
            }
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.widget-actions-btn')) {
                document.querySelectorAll('.widget-actions-dropdown').forEach(d => {
                    d.classList.remove('wad-open');
                });
            }
        });

        function dbOpenResetModal() {
            document.getElementById('reset-modal-overlay').style.display = 'flex';
        }

        function dbCloseResetModal() {
            document.getElementById('reset-modal-overlay').style.display = 'none';
        }

        function dbResetDashboard() {
            localStorage.removeItem('virrat_dashboard_layout');
            dbCloseResetModal();
            window.location.reload();
        }

        function dbOpenManagePanel() {
            document.getElementById('manage-widgets-overlay').style.display = 'block';
            document.getElementById('manage-widgets-panel').classList.add('panel-open');
        }

        function dbCloseManagePanel() {
            document.getElementById('manage-widgets-overlay').style.display = 'none';
            document.getElementById('manage-widgets-panel').classList.remove('panel-open');
        }
    </script>
@endif
@endpush
