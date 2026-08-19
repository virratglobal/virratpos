@extends('layouts.ui-admin')

@section('page-title', __('Subscription Plans'))

@php
    $dir = asset(Storage::url('uploads/plan'));
    $settings = Utility::settings();
    $totalPlans = count($plans);
    $activePlans = $plans->where('is_active', 1)->count();
    $totalSubscribers = \App\Models\User::where('type', 'owner')->where('plan', '!=', 1)->count();
    $totalRevenue = $orders->where('payment_status', 'succeeded')->sum('price');
    $currencySymbol = isset($admin_payments_setting['currency_symbol']) ? $admin_payments_setting['currency_symbol'] : '$';
@endphp

@section('content')
<style>
    /* VirratPOS Subscription Plans Design System - Blue & White */
    .plans-page-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 8px 16px 32px 16px;
        font-family: 'Inter', sans-serif;
        color: #0F172A;
    }

    .plans-header {
        margin-bottom: 24px;
    }
    .plans-header h1 {
        font-family: 'Inter', sans-serif;
        font-size: 24px;
        font-weight: 700;
        color: #0F172A;
        margin: 0;
        letter-spacing: -0.01em;
    }
    .plans-header p {
        font-size: 14px;
        color: #64748B;
        margin-top: 4px;
        margin-bottom: 0;
        font-weight: 400;
    }

    /* Page Action Button */
    .btn-create-plan {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        height: 42px !important;
        padding: 0 20px !important;
        border-radius: 8px !important;
        background-color: #2563EB !important;
        color: #FFFFFF !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        transition: background-color 0.15s ease-in-out !important;
        border: none !important;
        cursor: pointer !important;
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2) !important;
    }
    .btn-create-plan:hover {
        background-color: #1D4ED8 !important;
        color: #FFFFFF !important;
    }

    /* Stat Cards Row */
    .stat-card-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }
    @media (max-width: 1024px) {
        .stat-card-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (max-width: 640px) {
        .stat-card-grid {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    }

    .stat-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }
    .stat-icon-badge {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        background-color: #EFF6FF;
        color: #2563EB;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
    .stat-label {
        font-size: 13px;
        font-weight: 500;
        color: #64748B;
        display: block;
    }
    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: #0F172A;
        margin: 2px 0 0 0;
        line-height: 1.2;
    }

    /* Empty State */
    .empty-state-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        padding: 56px 24px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        margin-bottom: 32px;
    }
    .empty-icon-badge {
        width: 64px;
        height: 64px;
        border-radius: 16px;
        background: #EFF6FF;
        color: #2563EB;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Plan Cards Responsive Grid */
    .plans-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
        margin-bottom: 36px;
    }
    @media (max-width: 1024px) {
        .plans-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (max-width: 640px) {
        .plans-grid {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    }

    /* Plan Card Design */
    .plan-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        display: flex;
        flex-direction: column;
        height: 100%;
        transition: all 0.2s ease-in-out;
        position: relative;
    }
    .plan-card:hover {
        border-color: #BFDBFE;
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.08);
        transform: translateY(-2px);
    }
    .plan-card-active {
        border: 2px solid #2563EB !important;
    }

    .plan-card-header {
        margin-bottom: 16px;
    }
    .plan-name {
        font-size: 19px;
        font-weight: 700;
        color: #0F172A;
        margin: 0;
        line-height: 1.3;
    }
    .plan-description {
        font-size: 13.5px;
        color: #64748B;
        margin-top: 6px;
        margin-bottom: 0;
        line-height: 1.5;
    }
    .plan-badge-active {
        background: #EFF6FF;
        color: #2563EB;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
        flex-shrink: 0;
    }
    .plan-badge-default {
        background: #F1F5F9;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
        flex-shrink: 0;
    }

    /* Price Section */
    .plan-price-wrapper {
        display: flex;
        align-items: baseline;
        gap: 6px;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #F1F5F9;
    }
    .plan-price {
        font-size: 34px;
        font-weight: 700;
        color: #0F172A;
        letter-spacing: -0.02em;
        line-height: 1;
    }
    .plan-duration {
        font-size: 13.5px;
        color: #64748B;
        font-weight: 500;
    }

    /* Features List */
    .plan-features-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 24px;
        flex: 1;
    }
    .feature-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13.5px;
        color: #334155;
        font-weight: 500;
    }

    /* Plan Actions Footer */
    .plan-card-footer {
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid #F1F5F9;
    }
    .btn-edit-plan {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        height: 40px !important;
        padding: 0 16px !important;
        border-radius: 8px !important;
        background-color: #2563EB !important;
        color: #FFFFFF !important;
        font-size: 13.5px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        transition: background-color 0.15s ease !important;
        border: none !important;
        cursor: pointer !important;
    }
    .btn-edit-plan:hover {
        background-color: #1D4ED8 !important;
        color: #FFFFFF !important;
    }
    .btn-icon-danger {
        width: 40px !important;
        height: 40px !important;
        border-radius: 8px !important;
        background: #FEE2E2 !important;
        color: #DC2626 !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: all 0.15s ease !important;
        border: none !important;
        cursor: pointer !important;
        text-decoration: none !important;
        flex-shrink: 0 !important;
    }
    .btn-icon-danger:hover {
        background: #DC2626 !important;
        color: #FFFFFF !important;
    }
    .btn-primary-blue {
        height: 40px;
        background-color: #2563EB;
        color: #FFFFFF;
        font-size: 13.5px;
        font-weight: 600;
        border-radius: 8px;
        border: none;
        transition: background 0.15s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }
    .btn-primary-blue:hover {
        background-color: #1D4ED8;
        color: #FFFFFF;
    }
    .btn-secondary-outline {
        height: 40px;
        background-color: #FFFFFF;
        border: 1px solid #CBD5E1;
        color: #334155;
        font-size: 13.5px;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.15s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }
    .btn-secondary-outline:hover {
        background-color: #F8FAFC;
        color: #0F172A;
    }
    .btn-danger-red {
        height: 40px;
        background-color: #DC2626;
        color: #FFFFFF;
        font-size: 13.5px;
        font-weight: 600;
        border-radius: 8px;
        border: none;
        transition: background 0.15s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }
    .btn-danger-red:hover {
        background-color: #B91C1C;
        color: #FFFFFF;
    }

    /* iOS Style Toggles */
    .ios-toggle {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
        flex-shrink: 0;
    }
    .ios-toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .ios-toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0; left: 0; right: 0; bottom: 0;
        background-color: #CBD5E1;
        transition: .2s;
        border-radius: 24px;
    }
    .ios-toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .2s;
        border-radius: 50%;
        box-shadow: 0 1px 3px rgba(0,0,0,0.15);
    }
    .ios-toggle input:checked + .ios-toggle-slider {
        background-color: #2563EB;
    }
    .ios-toggle input:checked + .ios-toggle-slider:before {
        transform: translateX(20px);
    }

    /* Order History Card & Table */
    .order-history-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        padding: 24px;
        margin-top: 36px;
    }
    .order-history-header {
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #E2E8F0;
    }
    .order-history-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #0F172A;
        margin: 0;
    }
    .order-history-header p {
        font-size: 13.5px;
        color: #64748B;
        margin-top: 4px;
        margin-bottom: 0;
    }

    .custom-admin-table-container {
        overflow-x: auto;
    }
    .custom-admin-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Inter', sans-serif;
    }
    .custom-admin-table th {
        background-color: #F8FAFC;
        color: #64748B;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 12px 16px;
        text-align: left;
        border-bottom: 1px solid #E2E8F0;
    }
    .custom-admin-table td {
        padding: 14px 16px;
        font-size: 13.5px;
        color: #334155;
        border-bottom: 1px solid #E2E8F0;
        vertical-align: middle;
    }
    .custom-admin-table tr:hover td {
        background-color: #F8FAFC;
    }

    /* Status Badges */
    .badge-status-succeeded {
        background-color: #DCFCE7;
        color: #16A34A;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
    }
    .badge-status-pending {
        background-color: #FEF3C7;
        color: #D97706;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
    }
    .badge-status-failed {
        background-color: #FEE2E2;
        color: #DC2626;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
    }

    .btn-table-action {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background-color: #FFFFFF;
        border: 1px solid #E2E8F0;
        color: #475569;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
        text-decoration: none;
    }
    .btn-table-action:hover {
        background-color: #EFF6FF;
        color: #2563EB;
        border-color: #BFDBFE;
    }
    .btn-table-action-danger {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background-color: #FEE2E2;
        border: none;
        color: #DC2626;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
        text-decoration: none;
        cursor: pointer;
    }
    .btn-table-action-danger:hover {
        background-color: #DC2626;
        color: #FFFFFF;
    }
</style>

<div class="plans-page-container">
    <!-- Header -->
    <div class="plans-header flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1>{{ __('Subscription Plans') }}</h1>
            <p>{{ __('Configure and manage available subscription tiers and their features.') }}</p>
        </div>
        @if (Auth::user()->type == 'super admin')
            @can('Create Plans')
                <a href="#" data-url="{{ route('plans.create') }}" data-title="{{ __('Add Plan') }}" data-ajax-popup="true" data-size="lg" class="btn-create-plan">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    <span>{{ __('New Plan') }}</span>
                </a>
            @endcan
        @endif
    </div>

    <!-- Summary Statistics Row -->
    <div class="stat-card-grid">
        <div class="stat-card">
            <div class="stat-icon-badge">
                <span class="material-symbols-outlined">layers</span>
            </div>
            <div>
                <span class="stat-label">{{ __('Total Plans') }}</span>
                <h3 class="stat-value">{{ $totalPlans }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-badge">
                <span class="material-symbols-outlined">check_circle</span>
            </div>
            <div>
                <span class="stat-label">{{ __('Active Plans') }}</span>
                <h3 class="stat-value">{{ $activePlans }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-badge">
                <span class="material-symbols-outlined">group</span>
            </div>
            <div>
                <span class="stat-label">{{ __('Subscribers') }}</span>
                <h3 class="stat-value">{{ $totalSubscribers }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon-badge">
                <span class="material-symbols-outlined">payments</span>
            </div>
            <div>
                <span class="stat-label">{{ __('Monthly Revenue') }}</span>
                <h3 class="stat-value">{{ $currencySymbol }}{{ number_format($totalRevenue, 2) }}</h3>
            </div>
        </div>
    </div>

    <!-- Plans Grid -->
    @if ($plans->isEmpty())
        <div class="empty-state-card">
            <div class="empty-icon-badge">
                <span class="material-symbols-outlined text-[32px]">workspace_premium</span>
            </div>
            <h3 class="text-lg font-bold text-[#0F172A] mt-4">{{ __('No subscription plans yet') }}</h3>
            <p class="text-sm text-[#64748B] mt-1 mb-5">{{ __('Create your first plan to start managing subscriptions.') }}</p>
            @if (Auth::user()->type == 'super admin')
                @can('Create Plans')
                    <a href="#" data-url="{{ route('plans.create') }}" data-title="{{ __('Add Plan') }}" data-ajax-popup="true" data-size="lg" class="btn-create-plan">
                        <span class="material-symbols-outlined text-[20px]">add</span>
                        <span>{{ __('Create New Plan') }}</span>
                    </a>
                @endcan
            @endif
        </div>
    @else
        <div class="plans-grid">
            @foreach ($plans as $plan)
                @php
                    $isActiveUserPlan = (\Auth::user()->type !== 'super admin' && \Auth::user()->plan == $plan->id);
                    $isDefaultPlan = ($plan->id == 1 || $plan->price <= 0);
                @endphp
                <div class="plan-card {{ ($isActiveUserPlan || $plan->is_active == 1) ? 'plan-card-active' : '' }}">
                    <div class="plan-card-header flex items-start justify-between gap-3">
                        <div>
                            <h3 class="plan-name">{{ $plan->name }}</h3>
                            @if ($plan->description)
                                <p class="plan-description">{{ $plan->description }}</p>
                            @else
                                <p class="plan-description">{{ __('For companies that need a robust full-featured solution.') }}</p>
                            @endif
                        </div>
                        @if ($isActiveUserPlan)
                            <span class="plan-badge-active">{{ __('Active') }}</span>
                        @elseif ($isDefaultPlan)
                            <span class="plan-badge-default">{{ __('Default') }}</span>
                        @elseif ($plan->is_active == 1)
                            <span class="plan-badge-active">{{ __('Active') }}</span>
                        @endif
                    </div>

                    <div class="plan-price-wrapper">
                        <span class="plan-price">{{ $currencySymbol }}{{ $plan->price }}</span>
                        <span class="plan-duration">/ {{ __(\App\Models\Plan::$arrDuration[$plan->duration] ?? $plan->duration) }}</span>
                    </div>

                    <div class="plan-features-list">
                        <div class="feature-item">
                            <span class="material-symbols-outlined text-[18px] text-[#2563EB]">check_circle</span>
                            <span>{{ $plan->max_stores == '-1' ? __('Unlimited') : $plan->max_stores }} {{ __('Stores') }}</span>
                        </div>
                        <div class="feature-item">
                            <span class="material-symbols-outlined text-[18px] text-[#2563EB]">check_circle</span>
                            <span>{{ $plan->max_products == '-1' ? __('Unlimited') : $plan->max_products }} {{ __('Products') }}</span>
                        </div>
                        <div class="feature-item">
                            <span class="material-symbols-outlined text-[18px] text-[#2563EB]">check_circle</span>
                            <span>{{ $plan->max_users == '-1' ? __('Unlimited') : $plan->max_users }} {{ __('Users') }}</span>
                        </div>
                        <div class="feature-item">
                            <span class="material-symbols-outlined text-[18px] text-[#2563EB]">check_circle</span>
                            <span>{{ $plan->storage_limit == '-1' ? __('Unlimited') : $plan->storage_limit }} {{ __('MB Storage') }}</span>
                        </div>
                        @if($plan->enable_custdomain == 'on')
                            <div class="feature-item">
                                <span class="material-symbols-outlined text-[18px] text-[#2563EB]">check_circle</span>
                                <span>{{ __('Custom Domain') }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="plan-card-footer">
                        @if (\Auth::user()->type == 'super admin')
                            <div class="flex items-center justify-between gap-3 w-full">
                                @can('Edit Plans')
                                    <a href="#" class="btn-edit-plan flex-1" data-url="{{ route('plans.edit', $plan->id) }}" data-title="{{ __('Edit Plan') }}" data-ajax-popup="true" data-size="lg">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                        <span>{{ __('Edit Plan') }}</span>
                                    </a>
                                @endcan

                                <label class="ios-toggle mb-0" title="{{ __('Enable/Disable Plan') }}">
                                    <input type="checkbox" class="is_active" data-id="{{ $plan->id }}" {{ $plan->is_active == 1 ? 'checked' : '' }} value="{{ $plan->is_active }}">
                                    <span class="ios-toggle-slider"></span>
                                </label>

                                @if($plan->id != 1)
                                    <a href="#" class="btn-icon-danger bs-pass-para" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone.') }}" data-confirm-yes="delete-form-plan-{{ $plan->id }}" title="{{ __('Delete Plan') }}">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['plans.destroy', $plan->id], 'id' => 'delete-form-plan-' . $plan->id, 'class' => 'hidden']) !!}
                                    {!! Form::close() !!}
                                @endif
                            </div>
                        @else
                            @if($plan->price <= 0)
                                <div class="w-full text-center text-sm font-semibold text-[#64748B] py-2">{{ __('Lifetime / Free') }}</div>
                            @elseif(\Auth::user()->trial_plan == $plan->id && \Auth::user()->trial_expire_date && date('Y-m-d') < \Auth::user()->trial_expire_date)
                                <div class="w-full text-center text-sm font-semibold py-2 rounded-lg bg-[#FEF3C7] text-[#D97706]">{{ __('Trial Expires: ') }} {{ \Auth::user()->dateFormat(\Auth::user()->trial_expire_date) }}</div>
                            @elseif (\Auth::user()->plan == $plan->id && date('Y-m-d') < \Auth::user()->plan_expire_date && \Auth::user()->is_trial_done != 1)
                                <div class="w-full text-center text-sm font-semibold py-2 rounded-lg bg-[#EFF6FF] text-[#2563EB]">{{ __('Renews: ') }} {{ \App\Models\Utility::dateFormat(\Auth::user()->plan_expire_date) }}</div>
                            @elseif(\Auth::user()->plan == $plan->id && !empty(\Auth::user()->plan_expire_date) && \Auth::user()->plan_expire_date < date('Y-m-d'))
                                <div class="w-full text-center text-sm font-semibold py-2 rounded-lg bg-[#FEE2E2] text-[#DC2626]">{{ __('Expired') }}</div>
                            @elseif(\Auth::user()->plan == $plan->id && $plan->duration == 'Lifetime')
                                <div class="w-full text-center text-sm font-semibold py-2 rounded-lg bg-[#EFF6FF] text-[#2563EB]">{{ __('Lifetime') }}</div>
                            @else
                                <div class="flex space-x-2 w-full">
                                    @if ($plan->price > 0 && \Auth::user()->trial_plan == 0 && \Auth::user()->plan != $plan->id && $plan->trial != 'off' && $plan->trial_days != 0)
                                        <a href="{{ route('plan.trial', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}" class="flex-1">
                                            <button class="btn-secondary-outline w-full">{{ __('Free Trial') }}</button>
                                        </a>
                                    @endif
                                    <a href="{{ route('stripe', \Illuminate\Support\Facades\Crypt::encrypt($plan->id)) }}" class="flex-1">
                                        <button class="btn-primary-blue w-full">{{ __('Subscribe') }}</button>
                                    </a>
                                </div>
                            @endif
                            @if (\Auth::user()->plan != $plan->id && $plan->id != 1)
                                <div class="mt-2 w-full">
                                    @if (\Auth::user()->requested_plan != $plan->id)
                                        <a href="{{ route('send.request',[\Illuminate\Support\Facades\Crypt::encrypt($plan->id)]) }}" data-title="{{ __('Send Request') }}">
                                            <button class="btn-secondary-outline w-full">{{ __('Request Plan') }}</button>
                                        </a>
                                    @else
                                        <a href="{{ route('request.cancel',\Auth::user()->id) }}" data-title="{{ __('Cancel Request') }}">
                                            <button class="btn-danger-red w-full">{{ __('Cancel Request') }}</button>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Order History Table Card -->
    <div class="order-history-card">
        <div class="order-history-header">
            <h3>{{ __('Order History') }}</h3>
            <p>{{ __('Recent subscription transactions and upgrades.') }}</p>
        </div>

        <div class="custom-admin-table-container">
            <table class="custom-admin-table">
                <thead>
                    <tr>
                        <th>{{ __('Order Id') }}</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Plan') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Payment Type') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Invoice') }}</th>
                        @if(\Auth::user()->type == 'super admin')
                            <th style="text-align: right;">{{ __('Action') }}</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if(count($orders) > 0)
                        @foreach ($orders as $order)
                            <tr>
                                <td style="font-weight: 600; color: #0F172A;">{{ $order->order_id }}</td>
                                <td style="color: #64748B;">{{ $order->created_at->format('d M Y') }}</td>
                                <td style="font-weight: 600; color: #0F172A;">{{ $order->user_name }}</td>
                                <td style="color: #334155;">{{ $order->plan_name }}</td>
                                <td style="font-weight: 700; color: #0F172A;">{{ $currencySymbol }}{{ number_format($order->price, 2) }}</td>
                                <td style="color: #64748B;">{{ $order->payment_type }}</td>
                                <td>
                                    @if ($order->payment_status == 'succeeded')
                                        <span class="badge-status-succeeded">{{ __('Successful') }}</span>
                                    @elseif ($order->payment_status == 'pending')
                                        <span class="badge-status-pending">{{ __('Pending') }}</span>
                                    @else
                                        <span class="badge-status-failed">{{ ucfirst($order->payment_status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($order->receipt != 'free coupon' && $order->payment_type == 'STRIPE')
                                        <a href="{{ $order->receipt }}" title="{{ __('Invoice') }}" target="_blank" class="btn-table-action">
                                            <span class="material-symbols-outlined text-[18px]">description</span>
                                        </a>
                                    @elseif ($order->payment_type == 'Bank Transfer')
                                        <a href="{{ \App\Models\Utility::get_file($order->receipt) }}" title="{{ __('Invoice') }}" target="_blank" download class="btn-table-action">
                                            <span class="material-symbols-outlined text-[18px]">description</span>
                                        </a>
                                    @elseif($order->receipt == 'free coupon')
                                        <span class="text-xs text-[#64748B]">{{ __('100% discount') }}</span>
                                    @elseif($order->payment_type == 'Manually')
                                        <span class="text-xs text-[#64748B]">{{ __('Manual Upgrade') }}</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                @if(\Auth::user()->type == 'super admin')
                                    <td style="text-align: right;">
                                        <div class="flex items-center justify-end gap-2">
                                            @if($order->payment_status == 'pending' && $order->payment_type == 'Bank Transfer')
                                                <a href="#" class="btn-table-action" data-url="{{ route('bank_transfer.show',$order->id) }}" data-ajax-popup="true" data-size="lg" title="{{ __('Payment Status') }}">
                                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                                </a>
                                            @endif

                                            @php $user = \App\Models\User::find($order->user_id); @endphp
                                            @if($user && isset($userOrders))
                                                @foreach($userOrders as $userOrder)
                                                    @if ($user->plan == $order->plan_id && $order->order_id == $userOrder->order_id && $order->is_refund == 0 && $user->plan != 1)
                                                        <a href="{{ route('order.refund' , [$order->id , $order->user_id])}}" class="btn-table-action" title="{{ __('Refund') }}">
                                                            <span class="material-symbols-outlined text-[18px]">undo</span>
                                                        </a>
                                                    @endif
                                                @endforeach
                                            @endif

                                            <a href="#" class="btn-table-action-danger bs-pass-para" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone.') }}" data-confirm-yes="delete-form-{{ $order->id }}" title="{{ __('Delete Order') }}">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['planorder.destroy', $order->id], 'id' => 'delete-form-' . $order->id, 'class' => 'hidden']) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="{{ \Auth::user()->type == 'super admin' ? 9 : 8 }}" style="text-align: center; color: #94A3B8; padding: 32px;">
                                {{ __('No order transactions recorded yet.') }}
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).on("change", ".is_active", function() {
            var id = $(this).attr('data-id');
            var is_active = ($(this).is(':checked')) ? 1 : 0;
            $.ajax({
                url: '{{ route('plan.enable') }}',
                type: 'POST',
                data: {
                    "is_active": is_active,
                    "id": id,
                    "_token": "{{ csrf_token() }}",
                },
                success: function(data) {
                    if (data.success) {
                        show_toastr('Success', data.success, 'success');
                    } else {
                        show_toastr('Error', data.error, 'error');
                    }
                }
            });
        });
    </script>
@endpush
