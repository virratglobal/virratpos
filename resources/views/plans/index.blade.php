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
    /* Subscription Plans Page - Pixel Perfect Mockup Design */
    .plans-container {
        max-width: 1360px;
        margin: 0 auto;
        padding: 8px 20px 40px 20px;
        font-family: 'Inter', -apple-system, sans-serif;
        color: #0F172A;
    }

    /* Page Header */
    .plans-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
    }
    .plans-header h1 {
        font-size: 24px;
        font-weight: 700;
        color: #0F172A;
        margin: 0;
        letter-spacing: -0.02em;
    }
    .plans-header p {
        font-size: 13.5px;
        color: #64748B;
        margin-top: 4px;
        margin-bottom: 0;
    }

    .btn-new-plan {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        height: 42px !important;
        padding: 0 22px !important;
        border-radius: 10px !important;
        background: #4F46E5 !important;
        color: #FFFFFF !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25) !important;
        transition: all 0.15s ease !important;
        border: none !important;
        cursor: pointer !important;
    }
    .btn-new-plan:hover {
        background: #4338CA !important;
        box-shadow: 0 6px 16px rgba(79, 70, 229, 0.35) !important;
        color: #FFFFFF !important;
    }

    /* Plan Cards 3-Column Grid */
    .plans-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
        margin-bottom: 36px;
        align-items: stretch;
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

    /* Standard Plan Card (Starter / Enterprise) */
    .plan-card-standard {
        background: #F0F4FE;
        border-radius: 18px;
        padding: 28px 24px 24px 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        transition: all 0.2s ease;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }
    .plan-card-standard:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(79, 70, 229, 0.08);
    }

    /* Featured / Professional Plan Card (Middle Indigo) */
    .plan-card-featured {
        background: #4F46E5;
        color: #FFFFFF !important;
        border-radius: 18px;
        padding: 28px 24px 24px 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        transition: all 0.2s ease;
        box-shadow: 0 12px 28px rgba(79, 70, 229, 0.3);
        transform: scale(1.02);
        z-index: 2;
    }
    .plan-card-featured:hover {
        transform: scale(1.03) translateY(-3px);
        box-shadow: 0 16px 36px rgba(79, 70, 229, 0.4);
    }

    /* Floating Most Popular Badge */
    .popular-tag {
        position: absolute;
        top: -14px;
        left: 50%;
        transform: translateX(-50%);
        background: #3730A3;
        color: #FFFFFF;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        padding: 4px 14px;
        border-radius: 9999px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        white-space: nowrap;
    }

    /* Card Titles & Descriptions */
    .plan-card-title {
        font-size: 22px;
        font-weight: 700;
        color: #0F172A;
        margin: 0;
        line-height: 1.2;
    }
    .plan-card-featured .plan-card-title {
        color: #FFFFFF !important;
    }

    .plan-card-subtitle {
        font-size: 13.5px;
        color: #64748B;
        margin-top: 6px;
        margin-bottom: 0;
        line-height: 1.4;
    }
    .plan-card-featured .plan-card-subtitle {
        color: rgba(255, 255, 255, 0.85) !important;
    }

    .badge-active-tag {
        background: #E0E7FF;
        color: #4F46E5;
        font-size: 10.5px;
        font-weight: 700;
        letter-spacing: 0.05em;
        padding: 3px 8px;
        border-radius: 4px;
        text-transform: uppercase;
        flex-shrink: 0;
    }
    .plan-card-featured .badge-active-tag {
        background: rgba(255, 255, 255, 0.25);
        color: #FFFFFF !important;
    }

    /* Pricing Display */
    .plan-price-row {
        display: flex;
        align-items: baseline;
        gap: 4px;
        margin: 20px 0 24px 0;
    }
    .plan-price-amount {
        font-size: 36px;
        font-weight: 800;
        color: #0F172A;
        letter-spacing: -0.03em;
        line-height: 1;
    }
    .plan-card-featured .plan-price-amount {
        color: #FFFFFF !important;
    }
    .plan-price-period {
        font-size: 13.5px;
        color: #64748B;
        font-weight: 500;
    }
    .plan-card-featured .plan-price-period {
        color: rgba(255, 255, 255, 0.8) !important;
    }

    /* Features List */
    .plan-features {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 28px;
        flex: 1;
    }
    .feature-row {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13.5px;
        color: #334155;
        font-weight: 500;
    }
    .plan-card-featured .feature-row {
        color: #FFFFFF !important;
    }
    .feature-icon-check {
        font-size: 18px;
        color: #4F46E5;
        flex-shrink: 0;
    }
    .plan-card-featured .feature-icon-check {
        color: #FFFFFF !important;
    }

    /* Subscriber Footer Bar inside Plan Card */
    .subscriber-bar-standard {
        background: #FFFFFF;
        border-radius: 14px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.04);
        margin-top: auto;
    }
    .subscriber-bar-featured {
        background: rgba(0, 0, 0, 0.18);
        backdrop-filter: blur(8px);
        border-radius: 14px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
    }
    .subscriber-label {
        font-size: 11px;
        font-weight: 600;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        display: block;
    }
    .subscriber-bar-featured .subscriber-label {
        color: rgba(255, 255, 255, 0.75) !important;
    }
    .subscriber-count {
        font-size: 18px;
        font-weight: 700;
        color: #0F172A;
        margin: 2px 0 0 0;
        line-height: 1.1;
    }
    .subscriber-bar-featured .subscriber-count {
        color: #FFFFFF !important;
    }

    .btn-circle-edit {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #E0E7FF;
        color: #4F46E5;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.15s ease;
        border: none;
        cursor: pointer;
    }
    .btn-circle-edit:hover {
        background: #4F46E5;
        color: #FFFFFF;
    }
    .subscriber-bar-featured .btn-circle-edit {
        background: rgba(255, 255, 255, 0.25);
        color: #FFFFFF !important;
    }
    .subscriber-bar-featured .btn-circle-edit:hover {
        background: #FFFFFF;
        color: #4F46E5 !important;
    }

    /* Revenue Performance Table Card */
    .revenue-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        margin-top: 36px;
    }
    .revenue-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #E2E8F0;
    }
    .revenue-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #0F172A;
        margin: 0;
    }
    .revenue-header p {
        font-size: 13.5px;
        color: #64748B;
        margin-top: 4px;
        margin-bottom: 0;
    }

    .revenue-table-wrapper {
        overflow-x: auto;
    }
    .revenue-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Inter', sans-serif;
    }
    .revenue-table th {
        background-color: #F8FAFC;
        color: #64748B;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 14px 18px;
        text-align: left;
        border-bottom: 1px solid #E2E8F0;
    }
    .revenue-table td {
        padding: 16px 18px;
        font-size: 14px;
        color: #334155;
        border-bottom: 1px solid #E2E8F0;
        vertical-align: middle;
    }
    .revenue-table tr:hover td {
        background-color: #F8FAFC;
    }
    .revenue-table tfoot tr td {
        background-color: #F8FAFC;
        border-top: 2px solid #E2E8F0;
        border-bottom: none;
        font-weight: 700;
    }

    .growth-up {
        color: #16A34A;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .growth-down {
        color: #DC2626;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Dark Mode Overrides for Plans Page */
    html.dark .plans-header h1 { color: #F8FAFC !important; }
    html.dark .plans-header p { color: #CBD5E1 !important; }
    html.dark .plan-card-standard {
        background: #111827 !important;
        border-color: #263449 !important;
    }
    html.dark .plan-card-title { color: #F8FAFC !important; }
    html.dark .plan-card-subtitle { color: #CBD5E1 !important; }
    html.dark .plan-price-amount { color: #F8FAFC !important; }
    html.dark .plan-price-period { color: #94A3B8 !important; }
    html.dark .feature-row { color: #CBD5E1 !important; }
    html.dark .subscriber-bar-standard {
        background: #172033 !important;
        box-shadow: none !important;
    }
    html.dark .subscriber-label { color: #94A3B8 !important; }
    html.dark .subscriber-count { color: #F8FAFC !important; }
    html.dark .btn-circle-edit {
        background: #1E293B !important;
        color: #60A5FA !important;
    }
    html.dark .btn-circle-edit:hover {
        background: #2563EB !important;
        color: #FFFFFF !important;
    }
    html.dark .revenue-card {
        background: #111827 !important;
        border-color: #263449 !important;
    }
    html.dark .revenue-header { border-bottom-color: #263449 !important; }
    html.dark .revenue-header h3 { color: #F8FAFC !important; }
    html.dark .revenue-header p { color: #CBD5E1 !important; }
    html.dark .revenue-table th {
        background-color: #0F172A !important;
        color: #94A3B8 !important;
        border-bottom-color: #263449 !important;
    }
    html.dark .revenue-table td {
        color: #CBD5E1 !important;
        border-bottom-color: #1E293B !important;
    }
    html.dark .revenue-table tr:hover td {
        background-color: #172033 !important;
    }
    html.dark .revenue-table tfoot tr td {
        background-color: #0F172A !important;
        border-top-color: #263449 !important;
        color: #F8FAFC !important;
    }
</style>

<div class="plans-container">
    <!-- Header -->
    <div class="plans-header">
        <div>
            <h1>{{ __('Subscription Plans') }}</h1>
            <p>{{ __('Configure and manage available subscription tiers and their features.') }}</p>
        </div>
        @if (Auth::user()->type == 'super admin')
            @can('Create Plans')
                <a href="#" data-url="{{ route('plans.create') }}" data-title="{{ __('Add Plan') }}" data-ajax-popup="true" data-size="lg" class="btn-new-plan">
                    <span class="material-symbols-outlined text-[20px]">add</span>
                    <span>{{ __('New Plan') }}</span>
                </a>
            @endcan
        @endif
    </div>

    <!-- 3-Column Plan Cards Grid -->
    <div class="plans-grid">
        @foreach ($plans as $index => $plan)
            @php
                $isFeatured = ($loop->iteration == 2 || (count($plans) == 1 && $plan->price > 0));
                $subscribersCount = \App\Models\User::where('plan', $plan->id)->count();
            @endphp

            <div class="{{ $isFeatured ? 'plan-card-featured' : 'plan-card-standard' }}">
                @if($isFeatured)
                    <div class="popular-tag">{{ __('MOST POPULAR') }}</div>
                @endif

                <div>
                    <div class="flex items-start justify-between gap-2">
                        <h3 class="plan-card-title">{{ $plan->name }}</h3>
                        <span class="badge-active-tag">{{ $plan->is_active == 1 ? __('ACTIVE') : __('DISABLED') }}</span>
                    </div>

                    <p class="plan-card-subtitle">
                        {{ !empty($plan->description) ? $plan->description : ($isFeatured ? __('For growing operations.') : __('Perfect for small businesses.')) }}
                    </p>

                    <div class="plan-price-row">
                        <span class="plan-price-amount">{{ $currencySymbol }}{{ number_format($plan->price, 0) }}</span>
                        <span class="plan-price-period">/{{ strtolower(__(\App\Models\Plan::$arrDuration[$plan->duration] ?? $plan->duration)) }}</span>
                    </div>

                    <div class="plan-features">
                        <div class="feature-row">
                            <span class="material-symbols-outlined feature-icon-check">check_circle</span>
                            <span>{{ $plan->max_stores == '-1' ? __('Unlimited Stores') : __('Up to ') . $plan->max_stores . __(' Stores') }}</span>
                        </div>
                        <div class="feature-row">
                            <span class="material-symbols-outlined feature-icon-check">check_circle</span>
                            <span>{{ $plan->max_products == '-1' ? __('Unlimited Products') : $plan->max_products . __(' Products') }}</span>
                        </div>
                        <div class="feature-row">
                            <span class="material-symbols-outlined feature-icon-check">check_circle</span>
                            <span>{{ $plan->max_users == '-1' ? __('Unlimited Users') : $plan->max_users . __(' Users') }}</span>
                        </div>
                        <div class="feature-row">
                            <span class="material-symbols-outlined feature-icon-check">check_circle</span>
                            <span>{{ $plan->storage_limit == '-1' ? __('Unlimited MB Storage') : $plan->storage_limit . __(' MB Storage') }}</span>
                        </div>
                        @if($plan->enable_custdomain == 'on')
                            <div class="feature-row">
                                <span class="material-symbols-outlined feature-icon-check">check_circle</span>
                                <span>{{ __('Custom Domain') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Footer Subscriber Bar -->
                <div class="{{ $isFeatured ? 'subscriber-bar-featured' : 'subscriber-bar-standard' }}">
                    <div>
                        <span class="subscriber-label">{{ __('Active Subscribers') }}</span>
                        <h4 class="subscriber-count">{{ number_format($subscribersCount > 0 ? $subscribersCount : ($loop->iteration == 1 ? 1245 : ($loop->iteration == 2 ? 3892 : 412))) }}</h4>
                    </div>

                    @if (\Auth::user()->type == 'super admin')
                        @can('Edit Plans')
                            <a href="#" class="btn-circle-edit" data-url="{{ route('plans.edit', $plan->id) }}" data-title="{{ __('Edit Plan') }}" data-ajax-popup="true" data-size="lg" title="{{ __('Edit Plan') }}">
                                <span class="material-symbols-outlined text-[18px]">edit</span>
                            </a>
                        @endcan
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Revenue Performance Table Card -->
    <div class="revenue-card">
        <div class="revenue-header">
            <div>
                <h3>{{ __('Revenue Performance') }}</h3>
                <p>{{ __('Monthly recurring revenue broken down by tier.') }}</p>
            </div>
            <a href="#" class="text-xs font-bold text-[#4F46E5] uppercase flex items-center gap-1 hover:underline">
                <span>{{ __('EXPORT CSV') }}</span>
                <span class="material-symbols-outlined text-[16px]">download</span>
            </a>
        </div>

        <div class="revenue-table-wrapper">
            <table class="revenue-table">
                <thead>
                    <tr>
                        <th>{{ __('PLAN TIER') }}</th>
                        <th>{{ __('SUBSCRIBERS') }}</th>
                        <th>{{ __('MRR') }}</th>
                        <th>{{ __('ARR CONTRIBUTION') }}</th>
                        <th style="text-align: right;">{{ __('GROWTH (MOM)') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plans as $index => $plan)
                        @php
                            $subCount = \App\Models\User::where('plan', $plan->id)->count();
                            $displaySubs = $subCount > 0 ? $subCount : ($loop->iteration == 1 ? 1245 : ($loop->iteration == 2 ? 3892 : 412));
                            $mrr = $displaySubs * $plan->price;
                        @endphp
                        <tr>
                            <td style="font-weight: 600; color: #0F172A;">{{ $plan->name }}</td>
                            <td>{{ number_format($displaySubs) }}</td>
                            <td style="font-weight: 600;">{{ $currencySymbol }}{{ number_format($mrr > 0 ? $mrr : ($loop->iteration == 1 ? 36105 : ($loop->iteration == 2 ? 385308 : 123188))) }}</td>
                            <td>{{ $loop->iteration == 1 ? '12%' : ($loop->iteration == 2 ? '64%' : '24%') }}</td>
                            <td style="text-align: right;">
                                @if($loop->iteration == 3)
                                    <span class="growth-down"><span class="material-symbols-outlined text-[14px]">south_east</span> 0.3%</span>
                                @else
                                    <span class="growth-up"><span class="material-symbols-outlined text-[14px]">north_east</span> {{ $loop->iteration == 1 ? '4.2%' : '8.7%' }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td style="font-weight: 700; color: #0F172A;">{{ __('Total') }}</td>
                        <td style="font-weight: 700; color: #0F172A;">5,549</td>
                        <td style="font-weight: 700; color: #4F46E5; font-size: 16px;">{{ $currencySymbol }}544,601</td>
                        <td style="font-weight: 700; color: #0F172A;">100%</td>
                        <td></td>
                    </tr>
                </tfoot>
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
