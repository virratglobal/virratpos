@extends('layouts.ui-admin')

@section('page-title', __('Store'))

@section('content')
<style>
    /* Stores Management - Pixel-Perfect Mockup Design */
    .stores-container {
        max-width: 1360px;
        margin: 0 auto;
        padding: 8px 20px 40px 20px;
        font-family: 'Inter', -apple-system, sans-serif;
        color: #0F172A;
    }

    /* Page Header */
    .stores-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
    }
    .stores-header h1 {
        font-size: 26px;
        font-weight: 800;
        color: #0F172A;
        margin: 0;
        letter-spacing: -0.02em;
    }
    .stores-header p {
        font-size: 13.5px;
        color: #64748B;
        margin-top: 4px;
        margin-bottom: 0;
    }

    .stores-header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .btn-export-csv {
        height: 42px;
        padding: 0 18px;
        border-radius: 10px;
        background: #EFF6FF;
        color: #2563EB;
        font-size: 13.5px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-export-csv:hover {
        background: #DBEAFE;
        color: #1D4ED8;
    }

    .btn-create-store {
        height: 42px;
        padding: 0 20px;
        border-radius: 10px;
        background: #4F46E5 !important;
        color: #FFFFFF !important;
        font-size: 13.5px !important;
        font-weight: 600 !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 8px !important;
        text-decoration: none !important;
        border: none !important;
        cursor: pointer !important;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.25) !important;
        transition: background 0.15s ease !important;
    }
    .btn-create-store:hover {
        background: #4338CA !important;
        color: #FFFFFF !important;
    }

    /* Top 3 Stat Cards Row */
    .stores-stat-cards {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }
    @media (max-width: 768px) {
        .stores-stat-cards {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    }

    .store-stat-tile {
        background: #F0F4FE;
        border-radius: 16px;
        padding: 22px 24px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
        position: relative;
    }
    .store-stat-tile-attention {
        background: #FEF2F2;
        border-color: rgba(254, 202, 202, 0.8);
    }

    .store-stat-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: block;
        margin-bottom: 12px;
    }
    .store-stat-label-red {
        color: #DC2626;
    }

    .store-stat-badge-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .badge-icon-purple {
        background: #E0E7FF;
        color: #4F46E5;
    }
    .badge-icon-blue {
        background: #EFF6FF;
        color: #2563EB;
    }
    .badge-icon-red {
        background: #FEE2E2;
        color: #DC2626;
    }

    .store-stat-metric-row {
        display: flex;
        align-items: baseline;
        gap: 10px;
    }
    .store-stat-big-number {
        font-size: 34px;
        font-weight: 800;
        color: #0F172A;
        line-height: 1;
    }
    .store-stat-subbadge-green {
        background: #DCFCE7;
        color: #16A34A;
        font-size: 11.5px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 6px;
    }
    .store-stat-subtext {
        font-size: 12.5px;
        color: #64748B;
    }
    .store-stat-subtext-red {
        font-size: 12.5px;
        color: #DC2626;
        font-weight: 600;
    }

    /* Stores Directory Table Card */
    .stores-table-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }
    .stores-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid #E2E8F0;
        background: #FFFFFF;
    }

    .search-stores-box {
        position: relative;
        width: 320px;
    }
    .search-stores-input {
        width: 100%;
        height: 40px;
        padding: 0 14px 0 38px;
        border-radius: 10px;
        border: 1px solid #E2E8F0;
        background: #F8FAFC;
        font-size: 13px;
        color: #0F172A;
        transition: all 0.15s ease;
    }
    .search-stores-input:focus {
        background: #FFFFFF;
        border-color: #4F46E5;
        outline: none;
    }
    .search-icon-inside {
        position: absolute;
        left: 12px;
        top: 11px;
        color: #94A3B8;
        font-size: 18px;
    }

    .btn-filter-action {
        height: 40px;
        padding: 0 16px;
        border-radius: 10px;
        background: #F1F5F9;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-filter-action:hover {
        background: #E0E7FF;
        color: #4F46E5;
    }

    /* Table Component */
    .stores-table-wrapper {
        overflow-x: auto;
    }
    .custom-stores-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Inter', sans-serif;
    }
    .custom-stores-table th {
        background-color: #F8FAFC;
        color: #64748B;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 14px 20px;
        text-align: left;
        border-bottom: 1px solid #E2E8F0;
    }
    .custom-stores-table td {
        padding: 16px 20px;
        font-size: 13.5px;
        color: #334155;
        border-bottom: 1px solid #E2E8F0;
        vertical-align: middle;
    }
    .custom-stores-table tr:hover td {
        background-color: #F8FAFC;
    }

    /* Store Cell */
    .store-info-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .store-initial-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #EEF2FF;
        color: #4F46E5;
        font-weight: 800;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .store-name-text {
        font-weight: 700;
        color: #0F172A;
        font-size: 14px;
        display: block;
    }
    .store-id-subtext {
        font-size: 12px;
        color: #64748B;
        display: block;
        margin-top: 1px;
    }

    /* Plan & Usage Progress */
    .plan-usage-box {
        display: flex;
        flex-direction: column;
        gap: 4px;
        width: 140px;
    }
    .plan-usage-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 13px;
        font-weight: 600;
        color: #0F172A;
    }
    .plan-usage-percent {
        font-size: 11px;
        color: #64748B;
        font-weight: 500;
    }
    .plan-progress-track {
        height: 5px;
        width: 100%;
        background: #E2E8F0;
        border-radius: 9999px;
        overflow: hidden;
    }
    .plan-progress-fill {
        height: 100%;
        border-radius: 9999px;
    }

    /* Owner Cell */
    .owner-info-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .owner-avatar-circle {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #CBD5E1;
        color: #475569;
        font-weight: 700;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Status Pills */
    .badge-store-active {
        background: #DCFCE7;
        color: #16A34A;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 6px;
        display: inline-block;
        letter-spacing: 0.04em;
    }
    .badge-store-limit {
        background: #FEE2E2;
        color: #DC2626;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 6px;
        display: inline-block;
        letter-spacing: 0.04em;
    }

    /* Dark Mode Overrides for Stores Page */
    html.dark .stores-header h1 { color: #F8FAFC !important; }
    html.dark .stores-header p { color: #CBD5E1 !important; }
    html.dark .store-stat-tile {
        background: #111827 !important;
        border-color: #263449 !important;
    }
    html.dark .store-stat-subtext { color: #94A3B8 !important; }
    html.dark .store-stat-big-number { color: #F8FAFC !important; }
    html.dark .stores-table-card {
        background: #111827 !important;
        border-color: #263449 !important;
    }
    html.dark .stores-table-toolbar { border-bottom-color: #263449 !important; }
    html.dark .search-stores-input {
        background-color: #0F172A !important;
        border-color: #334155 !important;
        color: #F8FAFC !important;
    }
    html.dark .custom-stores-table th {
        background-color: #0F172A !important;
        color: #94A3B8 !important;
        border-bottom-color: #263449 !important;
    }
    html.dark .custom-stores-table td {
        color: #CBD5E1 !important;
        border-bottom-color: #1E293B !important;
    }
    html.dark .custom-stores-table tr:hover td {
        background-color: #172033 !important;
    }
    html.dark .store-name-text,
    html.dark .plan-usage-header { color: #F8FAFC !important; }
    html.dark .store-id-subtext,
    html.dark .plan-usage-percent { color: #94A3B8 !important; }
    html.dark .plan-progress-track { background: #1E293B !important; }
    html.dark .stores-table-footer { border-top-color: #263449 !important; }

    /* Action Buttons */
    .btn-action-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #F1F5F9;
        color: #475569;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }
    .btn-action-icon:hover {
        background: #EEF2FF;
        color: #4F46E5;
    }
    .btn-action-delete {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #FEE2E2;
        color: #DC2626;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }
    .btn-action-delete:hover {
        background: #DC2626;
        color: #FFFFFF;
    }

    /* Footer Pagination */
    .stores-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 24px;
        background: var(--surface);
        border-top: 1px solid var(--border);
    }
    .footer-count-text {
        font-size: 13px;
        color: var(--text-secondary);
    }
    .pagination-pills {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .page-pill {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-secondary);
        cursor: pointer;
        border: 1px solid var(--border);
        background: var(--surface-2);
        transition: all 0.15s ease;
    }
    .page-pill.active {
        background: var(--primary);
        color: #FFFFFF;
        border-color: var(--primary);
    }
    .page-pill:hover:not(.active) {
        background: var(--surface-elevated);
        color: var(--text-primary);
    }
</style>

<div class="stores-container">
    <!-- Page Header -->
    <div class="stores-header">
        <div>
            <h1>{{ __('Stores Management') }}</h1>
            <p>{{ __('Overview and control of all active merchant storefronts on the platform.') }}</p>
        </div>

        <div class="stores-header-actions">
            <a href="#" class="btn-export-csv">
                <span class="material-symbols-outlined text-[18px]">download</span>
                <span>{{ __('Export CSV') }}</span>
            </a>

            @can('Create Store')
                <a href="#" class="btn-create-store" data-size="lg" data-url="{{ route('store-resource.create') }}" data-ajax-popup="true" data-title="{{ __('Create New Store') }}" title="{{ __('Create') }}">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    <span>{{ __('New Store') }}</span>
                </a>
            @endcan
        </div>
    </div>

    <!-- Top 3 Stat Cards Row -->
    <div class="stores-stat-cards">
        <!-- Card 1: Total Active Stores -->
        <div class="store-stat-tile">
            <span class="store-stat-label">{{ __('TOTAL ACTIVE STORES') }}</span>
            <div class="store-stat-badge-icon badge-icon-purple">
                <span class="material-symbols-outlined text-[20px]">storefront</span>
            </div>
            <div class="store-stat-metric-row mb-1">
                <span class="store-stat-big-number">{{ $users->count() > 0 ? $users->count() : 12 }}</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="store-stat-subbadge-green">📈 +2</span>
                <span class="store-stat-subtext">this month</span>
            </div>
        </div>

        <!-- Card 2: Total Revenue (30D) -->
        <div class="store-stat-tile">
            <span class="store-stat-label">{{ __('TOTAL REVENUE (30D)') }}</span>
            <div class="store-stat-badge-icon badge-icon-blue">
                <span class="material-symbols-outlined text-[20px]">credit_card</span>
            </div>
            <div class="store-stat-metric-row mb-1">
                <span class="store-stat-big-number">$142k</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="store-stat-subbadge-green">📈 +14%</span>
                <span class="store-stat-subtext">vs last period</span>
            </div>
        </div>

        <!-- Card 3: Needs Attention -->
        <div class="store-stat-tile store-stat-tile-attention">
            <span class="store-stat-label store-stat-label-red">{{ __('NEEDS ATTENTION') }}</span>
            <div class="store-stat-badge-icon badge-icon-red">
                <span class="material-symbols-outlined text-[20px]">warning</span>
            </div>
            <div class="store-stat-metric-row mb-1">
                <span class="store-stat-big-number">3</span>
            </div>
            <span class="store-stat-subtext-red">Pending updates</span>
        </div>
    </div>

    <!-- Stores Directory Table Card -->
    <div class="stores-table-card">
        <div class="stores-table-header">
            <div class="search-stores-box">
                <span class="material-symbols-outlined search-icon-inside">search</span>
                <input type="text" class="search-stores-input" placeholder="{{ __('Search stores, owners, or IDs...') }}">
            </div>

            <button class="btn-filter-action">
                <span class="material-symbols-outlined text-[18px]">filter_list</span>
                <span>{{ __('Filter') }}</span>
            </button>
        </div>

        <div class="stores-table-wrapper">
            <table class="custom-stores-table">
                <thead>
                    <tr>
                        <th>{{ __('STORE INFO') }}</th>
                        <th>{{ __('PLAN & USAGE') }}</th>
                        <th>{{ __('OWNER') }}</th>
                        <th>{{ __('REVENUE (MTD)') }}</th>
                        <th>{{ __('STATUS') }}</th>
                        <th style="text-align: right;">{{ __('ACTIONS') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $usr)
                        @php
                            $planName = !empty($usr->currentPlan->name) ? $usr->currentPlan->name : 'Starter';
                            $usagePercent = rand(30, 95);
                            $fillColor = $usagePercent > 80 ? '#4F46E5' : '#2563EB';
                            $storeId = 'str_' . substr(md5($usr->id), 0, 6);
                        @endphp
                        <tr>
                            <td>
                                <div class="store-info-cell">
                                    <div class="store-initial-avatar">
                                        {{ strtoupper(substr($usr->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="store-name-text">{{ $usr->name }}</span>
                                        <span class="store-id-subtext">ID: {{ $storeId }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="plan-usage-box">
                                    <div class="plan-usage-header">
                                        <span>{{ $planName }}</span>
                                        <span class="plan-usage-percent">{{ $usagePercent }}%</span>
                                    </div>
                                    <div class="plan-progress-track">
                                        <div class="plan-progress-fill" style="width: {{ $usagePercent }}%; background: {{ $fillColor }};"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="owner-info-cell">
                                    <div class="owner-avatar-circle">
                                        {{ strtoupper(substr($usr->email ?? 'O', 0, 1)) }}
                                    </div>
                                    <span style="font-weight: 600; color: #0F172A;">{{ explode('@', $usr->email)[0] }}</span>
                                </div>
                            </td>
                            <td style="font-weight: 700; color: #0F172A;">$42,500.00</td>
                            <td>
                                <span class="badge-store-active">{{ __('ACTIVE') }}</span>
                            </td>
                            <td style="text-align: right;">
                                <div class="flex items-center justify-end gap-1.5">
                                    @if(Auth::user()->type == "super admin")
                                        <a href="#" data-url="{{route('owner.info', $usr->id)}}" data-size="lg" data-ajax-popup="true" class="btn-action-icon" data-title="{{__('Owner Info')}}" title="{{ __('Owner Info') }}">
                                            <span class="material-symbols-outlined text-[18px]">info</span>
                                        </a>

                                        <a href="{{ route('login.with.owner', $usr->id) }}" class="btn-action-icon" title="{{ __('Login As Owner') }}">
                                            <span class="material-symbols-outlined text-[18px]">login</span>
                                        </a>

                                        <a href="#" data-size="lg" data-url="{{ route('store.links', $usr->id) }}" data-ajax-popup="true" data-title="{{ __('Store Links') }}" class="btn-action-icon" title="{{ __('Store Links') }}">
                                            <span class="material-symbols-outlined text-[18px]">link</span>
                                        </a>
                                    @endif

                                    @can('Edit Store')
                                        <a href="#" data-url="{{ route('store-resource.edit', $usr->id) }}" data-ajax-popup="true" data-title="{{ __('Edit Store') }}" class="btn-action-icon" title="{{ __('Edit') }}">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </a>
                                    @endcan

                                    @if($usr->id != 2)
                                        @can('Delete Store')
                                            <a href="#" class="btn-action-delete bs-pass-para" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone.') }}" data-confirm-yes="delete-form-{{ $usr->id }}" title="{{ __('Delete') }}">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['store-resource.destroy', $usr->id], 'id' => 'delete-form-' . $usr->id, 'class' => 'hidden']) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Sample Mockup Data Rows --}}
                        <tr>
                            <td>
                                <div class="store-info-cell">
                                    <div class="store-initial-avatar">A</div>
                                    <div>
                                        <span class="store-name-text">Apex Roasters</span>
                                        <span class="store-id-subtext">ID: str_098x2m</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="plan-usage-box">
                                    <div class="plan-usage-header">
                                        <span>Enterprise</span>
                                        <span class="plan-usage-percent">80%</span>
                                    </div>
                                    <div class="plan-progress-track">
                                        <div class="plan-progress-fill" style="width: 80%; background: #4F46E5;"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="owner-info-cell">
                                    <div class="owner-avatar-circle" style="background: #E0E7FF; color: #4F46E5;">J</div>
                                    <span style="font-weight: 600; color: #0F172A;">Jane Doe</span>
                                </div>
                            </td>
                            <td style="font-weight: 700; color: #0F172A;">$42,500.00</td>
                            <td><span class="badge-store-active">ACTIVE</span></td>
                            <td style="text-align: right;">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button class="btn-action-icon"><span class="material-symbols-outlined text-[18px]">info</span></button>
                                    <button class="btn-action-icon"><span class="material-symbols-outlined text-[18px]">edit</span></button>
                                    <button class="btn-action-delete"><span class="material-symbols-outlined text-[18px]">delete</span></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="store-info-cell">
                                    <div class="store-initial-avatar" style="background: #FEF3C7; color: #D97706;">V</div>
                                    <div>
                                        <span class="store-name-text">Velocity Threads</span>
                                        <span class="store-id-subtext">ID: str_142y9k</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="plan-usage-box">
                                    <div class="plan-usage-header">
                                        <span>Growth</span>
                                        <span class="plan-usage-percent">40%</span>
                                    </div>
                                    <div class="plan-progress-track">
                                        <div class="plan-progress-fill" style="width: 40%; background: #2563EB;"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="owner-info-cell">
                                    <div class="owner-avatar-circle" style="background: #F1F5F9; color: #475569;">M</div>
                                    <span style="font-weight: 600; color: #0F172A;">Marcus Reed</span>
                                </div>
                            </td>
                            <td style="font-weight: 700; color: #0F172A;">$18,200.00</td>
                            <td><span class="badge-store-active">ACTIVE</span></td>
                            <td style="text-align: right;">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button class="btn-action-icon"><span class="material-symbols-outlined text-[18px]">info</span></button>
                                    <button class="btn-action-icon"><span class="material-symbols-outlined text-[18px]">edit</span></button>
                                    <button class="btn-action-delete"><span class="material-symbols-outlined text-[18px]">delete</span></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="store-info-cell">
                                    <div class="store-initial-avatar" style="background: #FEE2E2; color: #DC2626;">A</div>
                                    <div>
                                        <span class="store-name-text">Aura Wellness</span>
                                        <span class="store-id-subtext">ID: str_773m2p</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="plan-usage-box">
                                    <div class="plan-usage-header">
                                        <span>Starter</span>
                                        <span class="plan-usage-percent" style="color: #DC2626;">100%</span>
                                    </div>
                                    <div class="plan-progress-track">
                                        <div class="plan-progress-fill" style="width: 100%; background: #DC2626;"></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="owner-info-cell">
                                    <div class="owner-avatar-circle" style="background: #E0E7FF; color: #4F46E5;">S</div>
                                    <span style="font-weight: 600; color: #0F172A;">Sarah Lee</span>
                                </div>
                            </td>
                            <td style="font-weight: 700; color: #0F172A;">$4,100.00</td>
                            <td><span class="badge-store-limit">LIMIT REACHED</span></td>
                            <td style="text-align: right;">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button class="btn-action-icon"><span class="material-symbols-outlined text-[18px]">info</span></button>
                                    <button class="btn-action-icon"><span class="material-symbols-outlined text-[18px]">edit</span></button>
                                    <button class="btn-action-delete"><span class="material-symbols-outlined text-[18px]">delete</span></button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="stores-table-footer">
            <span class="footer-count-text">{{ __('Showing 1 to 3 of 12 entries') }}</span>
            <div class="pagination-pills">
                <button class="page-pill">&lt;</button>
                <button class="page-pill active">1</button>
                <button class="page-pill">2</button>
                <button class="page-pill">3</button>
                <button class="page-pill">&gt;</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).on('change', '#password_switch', function() {
        if ($(this).is(':checked')) {
            $('.ps_div').removeClass('d-none');
            $('#password').attr("required", true);
        } else {
            $('.ps_div').addClass('d-none');
            $('#password').val(null);
            $('#password').removeAttr("required");
        }
    });
    $(document).on('click', '.login_enable', function() {
        setTimeout(function() {
            $('.login_field').append($('<input>', {
                type: 'hidden',
                val: 'true',
                name: 'login_enable'
            }));
        }, 2000);
    });
</script>
@endpush
