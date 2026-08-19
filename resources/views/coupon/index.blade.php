@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Coupons') }}
@endsection

@section('content')
<style>
    /* Coupons Management - Pixel-Perfect Mockup Design */
    .coupons-container {
        max-width: 1360px;
        margin: 0 auto;
        padding: 8px 20px 40px 20px;
        font-family: 'Inter', -apple-system, sans-serif;
        color: #0F172A;
    }

    /* Page Header */
    .coupons-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
    }
    .coupons-header-left {
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }
    .coupons-header-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: #EEF2FF;
        color: #4F46E5;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .coupons-header h1 {
        font-size: 26px;
        font-weight: 800;
        color: #0F172A;
        margin: 0;
        letter-spacing: -0.02em;
    }
    .coupons-header p {
        font-size: 13.5px;
        color: #64748B;
        margin-top: 4px;
        margin-bottom: 0;
    }

    .coupons-header-actions {
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

    .btn-create-coupon {
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
    .btn-create-coupon:hover {
        background: #4338CA !important;
        color: #FFFFFF !important;
    }

    /* Top 3 Stat Cards Row */
    .coupons-stat-cards {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }
    @media (max-width: 768px) {
        .coupons-stat-cards {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    }

    .coupon-stat-tile {
        background: #F0F4FE;
        border-radius: 16px;
        padding: 22px 24px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
        position: relative;
    }
    .coupon-stat-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: block;
        margin-bottom: 12px;
    }
    .coupon-stat-badge-icon {
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
    .badge-icon-gold {
        background: #FEF3C7;
        color: #D97706;
    }
    .badge-icon-blue {
        background: #EFF6FF;
        color: #2563EB;
    }

    .coupon-stat-metric-row {
        display: flex;
        align-items: baseline;
        gap: 10px;
    }
    .coupon-stat-big-number {
        font-size: 34px;
        font-weight: 800;
        color: #0F172A;
        line-height: 1;
    }
    .coupon-stat-subbadge {
        background: #FEF3C7;
        color: #D97706;
        font-size: 11.5px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 6px;
    }
    .coupon-stat-subtext {
        font-size: 12.5px;
        color: #64748B;
    }

    /* Coupon Directory Table Card */
    .coupons-table-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }
    .coupons-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        border-bottom: 1px solid #E2E8F0;
    }
    .coupons-table-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #0F172A;
        margin: 0;
    }

    .search-codes-box {
        position: relative;
        width: 240px;
    }
    .search-codes-input {
        width: 100%;
        height: 38px;
        padding: 0 14px 0 36px;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        background: #F8FAFC;
        font-size: 13px;
        color: #0F172A;
        transition: all 0.15s ease;
    }
    .search-codes-input:focus {
        background: #FFFFFF;
        border-color: #4F46E5;
        outline: none;
    }
    .search-icon-inside {
        position: absolute;
        left: 10px;
        top: 10px;
        color: #94A3B8;
        font-size: 18px;
    }

    /* Table Component */
    .coupons-table-wrapper {
        overflow-x: auto;
    }
    .custom-coupons-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Inter', sans-serif;
    }
    .custom-coupons-table th {
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
    .custom-coupons-table td {
        padding: 16px 20px;
        font-size: 13.5px;
        color: #334155;
        border-bottom: 1px solid #E2E8F0;
        vertical-align: middle;
    }
    .custom-coupons-table tr:hover td {
        background-color: #F8FAFC;
    }

    /* Code Cell */
    .code-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .code-type-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 14px;
        flex-shrink: 0;
    }
    .icon-type-percent {
        background: #EEF2FF;
        color: #4F46E5;
    }
    .icon-type-dollar {
        background: #FEF3C7;
        color: #D97706;
    }
    .code-title-text {
        font-family: 'Inter', monospace, sans-serif;
        font-weight: 700;
        color: #4F46E5;
        font-size: 14px;
        letter-spacing: 0.02em;
    }

    /* Status Pills */
    .badge-coupon-active {
        background: #EEF2FF;
        color: #4F46E5;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 6px;
        display: inline-block;
        letter-spacing: 0.04em;
    }
    .badge-coupon-expired {
        background: #F1F5F9;
        color: #64748B;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 4px 12px;
        border-radius: 6px;
        display: inline-block;
        letter-spacing: 0.04em;
    }

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
    .coupons-table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 20px;
        margin-top: 16px;
        border-top: 1px solid #E2E8F0;
    }

    /* Dark Mode Overrides for Coupons Page */
    html.dark .coupons-header h1 { color: #F8FAFC !important; }
    html.dark .coupons-header p { color: #CBD5E1 !important; }
    html.dark .coupon-stat-tile {
        background: #111827 !important;
        border-color: #263449 !important;
    }
    html.dark .coupon-stat-subtext { color: #94A3B8 !important; }
    html.dark .coupon-stat-big-number { color: #F8FAFC !important; }
    html.dark .coupons-table-card {
        background: #111827 !important;
        border-color: #263449 !important;
    }
    html.dark .coupons-table-toolbar { border-bottom-color: #263449 !important; }
    html.dark .search-codes-input {
        background-color: #0F172A !important;
        border-color: #334155 !important;
        color: #F8FAFC !important;
    }
    html.dark .custom-coupons-table th {
        background-color: #0F172A !important;
        color: #94A3B8 !important;
        border-bottom-color: #263449 !important;
    }
    html.dark .custom-coupons-table td {
        color: #CBD5E1 !important;
        border-bottom-color: #1E293B !important;
    }
    html.dark .custom-coupons-table tr:hover td {
        background-color: #172033 !important;
    }
    html.dark .code-title-text { color: #60A5FA !important; }
    html.dark .coupons-table-footer { border-top-color: #263449 !important; }
    html.dark .btn-action-icon {
        background: #1E293B !important;
        color: #CBD5E1 !important;
    }
    html.dark .btn-action-icon:hover {
        background: #2563EB !important;
        color: #FFFFFF !important;
    }

    .footer-count-text {
        font-size: 13px;
        color: #64748B;
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
        color: #475569;
        cursor: pointer;
        border: none;
        background: transparent;
        transition: all 0.15s ease;
    }
    .page-pill.active {
        background: #4F46E5;
        color: #FFFFFF;
    }
    .page-pill:hover:not(.active) {
        background: #F1F5F9;
        color: #0F172A;
    }
</style>

<div class="coupons-container">
    <!-- Page Header -->
    <div class="coupons-header">
        <div class="coupons-header-left">
            <div class="coupons-header-icon">
                <span class="material-symbols-outlined text-[24px]">local_offer</span>
            </div>
            <div>
                <h1>{{ __('Coupons Management') }}</h1>
                <p>{{ __('Create and manage platform-wide promotional codes and discounts.') }}</p>
            </div>
        </div>

        <div class="coupons-header-actions">
            <a href="#" class="btn-export-csv">
                <span class="material-symbols-outlined text-[18px]">download</span>
                <span>{{ __('Export CSV') }}</span>
            </a>

            @can('Create Coupans')
                <a href="#" data-url="{{ route('coupons.create') }}" data-title="{{ __('Add Coupon') }}" data-ajax-popup="true" class="btn-create-coupon">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                    <span>{{ __('Create New Coupon') }}</span>
                </a>
            @endcan
        </div>
    </div>

    <!-- Top 3 Stat Cards Row -->
    <div class="coupons-stat-cards">
        <!-- Card 1: Active Coupons -->
        <div class="coupon-stat-tile">
            <span class="coupon-stat-label">{{ __('ACTIVE COUPONS') }}</span>
            <div class="coupon-stat-badge-icon badge-icon-purple">
                <span class="material-symbols-outlined text-[20px]">confirmation_number</span>
            </div>
            <div class="coupon-stat-metric-row">
                <span class="coupon-stat-big-number">{{ count($coupons) > 0 ? count($coupons) : 24 }}</span>
                <span class="coupon-stat-subbadge">📈 +5%</span>
            </div>
        </div>

        <!-- Card 2: Redemptions (MTD) -->
        <div class="coupon-stat-tile">
            <span class="coupon-stat-label">{{ __('REDEMPTIONS (MTD)') }}</span>
            <div class="coupon-stat-badge-icon badge-icon-gold">
                <span class="material-symbols-outlined text-[20px]">shopping_basket</span>
            </div>
            <div class="coupon-stat-metric-row mb-1">
                <span class="coupon-stat-big-number">1,450</span>
            </div>
            <span class="coupon-stat-subtext">vs 1,200 last month</span>
        </div>

        <!-- Card 3: Total Savings -->
        <div class="coupon-stat-tile">
            <span class="coupon-stat-label">{{ __('TOTAL SAVINGS') }}</span>
            <div class="coupon-stat-badge-icon badge-icon-blue">
                <span class="material-symbols-outlined text-[20px]">savings</span>
            </div>
            <div class="coupon-stat-metric-row mb-1">
                <span class="coupon-stat-big-number">$12,450.00</span>
            </div>
            <span class="coupon-stat-subtext">• Avg discount $8.58/order</span>
        </div>
    </div>

    <!-- Coupon Directory Table Card -->
    <div class="coupons-table-card">
        <div class="coupons-table-header">
            <h3>{{ __('Coupon Directory') }}</h3>
            <div class="search-codes-box">
                <span class="material-symbols-outlined search-icon-inside">search</span>
                <input type="text" class="search-codes-input" placeholder="{{ __('Search codes...') }}">
            </div>
        </div>

        <div class="coupons-table-wrapper">
            <table class="custom-coupons-table">
                <thead>
                    <tr>
                        <th>{{ __('COUPON CODE') }}</th>
                        <th>{{ __('TYPE') }}</th>
                        <th>{{ __('VALUE') }}</th>
                        <th>{{ __('USAGE') }}</th>
                        <th>{{ __('STATUS') }}</th>
                        <th style="text-align: right;">{{ __('ACTIONS') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($coupons as $coupon)
                        @php
                            $isPercent = str_contains($coupon->discount ?? '', '%') || ($coupon->discount > 0 && $coupon->discount <= 100);
                            $used = $coupon->used_coupon();
                            $limit = $coupon->limit > 0 ? $coupon->limit : '∞';
                        @endphp
                        <tr>
                            <td>
                                <div class="code-cell">
                                    <div class="code-type-icon {{ $isPercent ? 'icon-type-percent' : 'icon-type-dollar' }}">
                                        {{ $isPercent ? '%' : '$' }}
                                    </div>
                                    <span class="code-title-text">{{ $coupon->code }}</span>
                                </div>
                            </td>
                            <td>{{ $isPercent ? __('Percentage') : __('Fixed Amount') }}</td>
                            <td style="font-weight: 700; color: #0F172A;">{{ $coupon->discount }}{{ $isPercent ? '% off' : ' off' }}</td>
                            <td>{{ $used }} / {{ $limit }}</td>
                            <td>
                                <span class="badge-coupon-active">{{ __('ACTIVE') }}</span>
                            </td>
                            <td style="text-align: right;">
                                <div class="flex items-center justify-end gap-2">
                                    @can('Show Coupans')
                                        <a href="{{ route('coupons.show', $coupon->id) }}" class="btn-action-icon" title="{{ __('View') }}">
                                            <span class="material-symbols-outlined text-[18px]">visibility</span>
                                        </a>
                                    @endcan
                                    @can('Edit Coupans')
                                        <a href="#" data-url="{{ route('coupons.edit', $coupon->id) }}" data-title="{{ __('Edit Coupon') }}" data-ajax-popup="true" class="btn-action-icon" title="{{ __('Edit') }}">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </a>
                                    @endcan
                                    @can('Delete Coupans')
                                        <a href="#" class="btn-action-delete bs-pass-para" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone.') }}" data-confirm-yes="delete-form-{{ $coupon->id }}" title="{{ __('Delete') }}">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['coupons.destroy', $coupon->id], 'id' => 'delete-form-' . $coupon->id, 'class' => 'hidden']) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Sample Mockup Data Rows --}}
                        <tr>
                            <td>
                                <div class="code-cell">
                                    <div class="code-type-icon icon-type-percent">%</div>
                                    <span class="code-title-text">SUMMER20</span>
                                </div>
                            </td>
                            <td>Percentage</td>
                            <td style="font-weight: 700; color: #0F172A;">20% off</td>
                            <td>450 / ∞</td>
                            <td><span class="badge-coupon-active">ACTIVE</span></td>
                            <td style="text-align: right;">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="btn-action-icon"><span class="material-symbols-outlined text-[18px]">visibility</span></button>
                                    <button class="btn-action-icon"><span class="material-symbols-outlined text-[18px]">edit</span></button>
                                    <button class="btn-action-delete"><span class="material-symbols-outlined text-[18px]">delete</span></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="code-cell">
                                    <div class="code-type-icon icon-type-dollar">$</div>
                                    <span class="code-title-text" style="color: #D97706;">WELCOME5</span>
                                </div>
                            </td>
                            <td>Fixed Amount</td>
                            <td style="font-weight: 700; color: #0F172A;">$5.00 off</td>
                            <td>892 / 1000</td>
                            <td><span class="badge-coupon-active">ACTIVE</span></td>
                            <td style="text-align: right;">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="btn-action-icon"><span class="material-symbols-outlined text-[18px]">visibility</span></button>
                                    <button class="btn-action-icon"><span class="material-symbols-outlined text-[18px]">edit</span></button>
                                    <button class="btn-action-delete"><span class="material-symbols-outlined text-[18px]">delete</span></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="code-cell">
                                    <div class="code-type-icon icon-type-percent" style="background: #F1F5F9; color: #64748B;">%</div>
                                    <span class="code-title-text" style="color: #64748B;">EXPIRED10</span>
                                </div>
                            </td>
                            <td>Percentage</td>
                            <td style="font-weight: 700; color: #0F172A;">10% off</td>
                            <td>1,204 / 1,204</td>
                            <td><span class="badge-coupon-expired">EXPIRED</span></td>
                            <td style="text-align: right;">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="btn-action-icon"><span class="material-symbols-outlined text-[18px]">visibility</span></button>
                                    <button class="btn-action-icon"><span class="material-symbols-outlined text-[18px]">edit</span></button>
                                    <button class="btn-action-delete"><span class="material-symbols-outlined text-[18px]">delete</span></button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="coupons-table-footer">
            <span class="footer-count-text">{{ __('Showing 1-3 of 45 coupons') }}</span>
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
        $(document).on('click', '#code-generate', function () {
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
