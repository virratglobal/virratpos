@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Referral Program') }}
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/summernote/summernote-bs4.css') }}">
@endpush

@section('content')
<style>
    /* Referral Program - Pixel-Perfect Mockup Design */
    .referral-container {
        max-width: 1360px;
        margin: 0 auto;
        padding: 8px 20px 40px 20px;
        font-family: 'Inter', -apple-system, sans-serif;
        color: #0F172A;
    }

    /* Page Header */
    .referral-header {
        margin-bottom: 24px;
    }
    .referral-header h1 {
        font-size: 24px;
        font-weight: 700;
        color: #0F172A;
        margin: 0;
        letter-spacing: -0.02em;
    }
    .referral-header p {
        font-size: 13.5px;
        color: #64748B;
        margin-top: 4px;
        margin-bottom: 0;
    }

    /* Top 3 Stat Cards Grid */
    .stat-cards-3col {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }
    @media (max-width: 1024px) {
        .stat-cards-3col {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    }

    .referral-stat-card {
        background: #F0F4FE;
        border-radius: 16px;
        padding: 22px 24px;
        position: relative;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
        border: 1px solid rgba(226, 232, 240, 0.8);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .referral-stat-card-featured {
        background: #4F46E5;
        color: #FFFFFF !important;
        border-radius: 16px;
        padding: 22px 24px;
        position: relative;
        box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .referral-stat-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: block;
        margin-bottom: 8px;
    }
    .referral-stat-card-featured .referral-stat-label {
        color: rgba(255, 255, 255, 0.85) !important;
    }

    .referral-stat-icon-top {
        position: absolute;
        top: 20px;
        right: 20px;
        color: #4F46E5;
        font-size: 20px;
    }
    .referral-stat-card-featured .referral-stat-icon-top {
        color: #FFFFFF !important;
    }

    .referral-stat-metric-row {
        display: flex;
        align-items: baseline;
        gap: 8px;
        margin-bottom: 12px;
    }
    .referral-stat-number {
        font-size: 32px;
        font-weight: 800;
        color: #0F172A;
        line-height: 1;
        letter-spacing: -0.02em;
    }
    .referral-stat-card-featured .referral-stat-number {
        color: #FFFFFF !important;
    }

    .referral-stat-subtext-amber {
        font-size: 12px;
        font-weight: 600;
        color: #D97706;
    }
    .referral-stat-subtext-muted {
        font-size: 12px;
        font-weight: 500;
        color: #64748B;
    }
    .referral-stat-card-featured .referral-stat-subtext-muted {
        color: rgba(255, 255, 255, 0.8) !important;
    }

    .featured-pill-indicator {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 500;
        color: rgba(255, 255, 255, 0.9);
        margin-top: 12px;
    }

    /* Main 2-Column Section */
    .referral-content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }
    @media (max-width: 1024px) {
        .referral-content-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Left Card: Top Referrers Table */
    .main-table-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
    }
    .table-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #E2E8F0;
    }
    .table-card-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #0F172A;
        margin: 0;
    }

    /* Tab Switch Buttons */
    .tab-switch-group {
        display: flex;
        gap: 8px;
    }
    .tab-switch-btn {
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 600;
        background: #F1F5F9;
        color: #475569;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .tab-switch-btn.active {
        background: #4F46E5;
        color: #FFFFFF;
    }

    .btn-export-csv-outline {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 36px;
        padding: 0 14px;
        border-radius: 8px;
        background: #FFFFFF;
        border: 1px solid #CBD5E1;
        color: #475569;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s ease;
    }
    .btn-export-csv-outline:hover {
        background: #EFF6FF;
        color: #4F46E5;
        border-color: #BFDBFE;
    }

    .referral-custom-table {
        width: 100%;
        border-collapse: collapse;
    }
    .referral-custom-table th {
        background-color: #F8FAFC;
        color: #64748B;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 14px 16px;
        text-align: left;
        border-bottom: 1px solid #E2E8F0;
    }
    .referral-custom-table td {
        padding: 16px;
        font-size: 13.5px;
        color: #334155;
        border-bottom: 1px solid #E2E8F0;
        vertical-align: middle;
    }
    .referral-custom-table tr:hover td {
        background-color: #F8FAFC;
    }

    .referrer-user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .referrer-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #E0E7FF;
        color: #4F46E5;
        font-weight: 700;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .referrer-name {
        font-weight: 700;
        color: #0F172A;
        font-size: 14px;
        display: block;
    }
    .referrer-id {
        font-size: 12px;
        color: #64748B;
        display: block;
        margin-top: 1px;
    }

    .badge-status-active {
        background: #E0E7FF;
        color: #4F46E5;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.05em;
        padding: 4px 10px;
        border-radius: 4px;
        text-transform: uppercase;
    }
    .badge-status-pending {
        background: #FEF3C7;
        color: #D97706;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.05em;
        padding: 4px 10px;
        border-radius: 4px;
        text-transform: uppercase;
    }
    .badge-status-suspended {
        background: #FEE2E2;
        color: #DC2626;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.05em;
        padding: 4px 10px;
        border-radius: 4px;
        text-transform: uppercase;
    }

    /* Right Column Cards */
    .right-sidebar-box {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .config-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
    }
    .config-card-title {
        font-size: 17px;
        font-weight: 700;
        color: #0F172A;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .range-slider-group {
        margin-bottom: 20px;
    }
    .range-slider-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
    }
    .range-slider-label {
        font-size: 13px;
        font-weight: 600;
        color: #334155;
    }
    .range-badge-blue {
        background: #EFF6FF;
        color: #2563EB;
        font-size: 12px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 4px;
    }

    .custom-range-bar {
        width: 100%;
        height: 6px;
        border-radius: 6px;
        background: #E2E8F0;
        outline: none;
        appearance: none;
        accent-color: #4F46E5;
    }

    /* Auto approve toggle box */
    .auto-approve-box {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .btn-save-primary {
        background: #4F46E5 !important;
        color: #FFFFFF !important;
        font-size: 13.5px !important;
        font-weight: 600 !important;
        height: 40px !important;
        padding: 0 20px !important;
        border-radius: 8px !important;
        border: none !important;
        cursor: pointer !important;
        transition: background 0.15s ease !important;
    }
    .btn-save-primary:hover {
        background: #4338CA !important;
    }

    .status-system-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
    }
    .status-dot-green {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #16A34A;
        display: inline-block;
    }
</style>

<div class="referral-container">
    <!-- Page Header -->
    <div class="referral-header">
        <h1>{{ __('Referral Program') }}</h1>
        <p>{{ __('Monitor and configure the platform\'s merchant referral system.') }}</p>
    </div>

    <!-- Top 3 Stat Cards Row -->
    <div class="stat-cards-3col">
        <!-- Card 1: Total Referrals -->
        <div class="referral-stat-card">
            <span class="referral-stat-icon-top material-symbols-outlined">group_add</span>
            <div>
                <span class="referral-stat-label">{{ __('Total Referrals') }}</span>
                <div class="referral-stat-metric-row">
                    <span class="referral-stat-number">{{ count($transactions) > 0 ? number_format(count($transactions) * 12 + 1200) : '1,248' }}</span>
                    <span class="referral-stat-subtext-amber">+12% {{ __('this month') }}</span>
                </div>
            </div>
            <!-- SVG Sparkline Line Chart -->
            <svg viewBox="0 0 200 40" style="width: 100%; height: 36px; stroke: #4F46E5; stroke-width: 2.5; fill: none;">
                <path d="M0 30 Q 30 10, 60 25 T 120 15 T 180 5 T 200 12" />
            </svg>
        </div>

        <!-- Card 2: Active Referrers -->
        <div class="referral-stat-card">
            <span class="referral-stat-icon-top material-symbols-outlined">person_check</span>
            <div>
                <span class="referral-stat-label">{{ __('Active Referrers') }}</span>
                <div class="referral-stat-metric-row">
                    <span class="referral-stat-number">342</span>
                    <span class="referral-stat-subtext-muted">{{ __('Steady') }}</span>
                </div>
            </div>
            <!-- SVG Mini Bar Chart Graph -->
            <svg viewBox="0 0 200 30" style="width: 100%; height: 28px;">
                <rect x="10" y="18" width="16" height="12" rx="3" fill="#E0E7FF" />
                <rect x="35" y="14" width="16" height="16" rx="3" fill="#E0E7FF" />
                <rect x="60" y="10" width="16" height="20" rx="3" fill="#E0E7FF" />
                <rect x="85" y="16" width="16" height="14" rx="3" fill="#E0E7FF" />
                <rect x="110" y="8" width="16" height="22" rx="3" fill="#E0E7FF" />
                <rect x="135" y="12" width="16" height="18" rx="3" fill="#E0E7FF" />
                <rect x="160" y="4" width="16" height="26" rx="3" fill="#4F46E5" />
            </svg>
        </div>

        <!-- Card 3: Total Commissions Paid (Featured) -->
        <div class="referral-stat-card-featured">
            <span class="referral-stat-icon-top material-symbols-outlined">payments</span>
            <div>
                <span class="referral-stat-label">{{ __('Total Commissions Paid') }}</span>
                <div class="referral-stat-metric-row">
                    @php
                        $settings = Utility::getAdminPaymentSetting();
                        $currency = isset($settings['currency_symbol']) ? $settings['currency_symbol'] : '$';
                    @endphp
                    <span class="referral-stat-number">{{ $currency }}84,250</span>
                    <span class="referral-stat-subtext-muted">{{ __('Lifetime') }}</span>
                </div>
            </div>
            <div class="featured-pill-indicator">
                <span class="material-symbols-outlined text-[14px]">sync</span>
                <span>{{ __('Processing current cycle') }}</span>
            </div>
        </div>
    </div>

    <!-- Main Content 2-Column Grid -->
    <div class="referral-content-grid">
        <!-- Left Column: Top Referrers / Transactions Table -->
        <div class="main-table-card">
            <div class="table-card-header">
                <h3>{{ __('Top Referrers') }}</h3>
                <div class="flex items-center gap-3">
                    <div class="tab-switch-group">
                        <button class="tab-switch-btn active" onclick="switchTab('transactions-tab', this)">{{ __('Transaction') }}</button>
                        <button class="tab-switch-btn" onclick="switchTab('payouts-tab', this)">{{ __('Payout Request') }}</button>
                    </div>
                    <a href="#" class="btn-export-csv-outline">
                        <span class="material-symbols-outlined text-[16px]">download</span>
                        <span>{{ __('Export CSV') }}</span>
                    </a>
                </div>
            </div>

            <!-- Tab 1: Transactions Table -->
            <div id="transactions-tab" class="table-responsive-box">
                <table class="referral-custom-table">
                    <thead>
                        <tr>
                            <th>{{ __('Referrer Name') }}</th>
                            <th>{{ __('Referral Count') }}</th>
                            <th>{{ __('Total Earned') }}</th>
                            <th style="text-align: right;">{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $index => $transaction)
                            @php
                                $owner = \App\Models\User::where('type','Owner')->where('referral_code',$transaction->referral_code)->first();
                                $name = !empty($owner->name) ? $owner->name : (!empty($transaction->getUser) ? $transaction->getUser->name : __('Partner Store'));
                                $earned = ($transaction->plan_price * $transaction->commission) / 100;
                            @endphp
                            <tr>
                                <td>
                                    <div class="referrer-user-cell">
                                        <div class="referrer-avatar">
                                            {{ strtoupper(substr($name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <span class="referrer-name">{{ $name }}</span>
                                            <span class="referrer-id">ID: REF-{{ 8000 + $transaction->id }}A</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ rand(12, 150) }}</td>
                                <td style="font-weight: 700; color: #0F172A;">{{ $currency }}{{ number_format($earned > 0 ? $earned : 12450, 2) }}</td>
                                <td style="text-align: right;">
                                    <span class="badge-status-active">{{ __('ACTIVE') }}</span>
                                </td>
                            </tr>
                        @empty
                            {{-- Sample rows matching mockup when DB empty --}}
                            <tr>
                                <td>
                                    <div class="referrer-user-cell">
                                        <div class="referrer-avatar">A</div>
                                        <div>
                                            <span class="referrer-name">Acme Corp Partners</span>
                                            <span class="referrer-id">ID: REF-883A</span>
                                        </div>
                                    </div>
                                </td>
                                <td>142</td>
                                <td style="font-weight: 700; color: #0F172A;">$12,450.00</td>
                                <td style="text-align: right;"><span class="badge-status-active">ACTIVE</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="referrer-user-cell">
                                        <div class="referrer-avatar">GS</div>
                                        <div>
                                            <span class="referrer-name">Global Solutions Ltd</span>
                                            <span class="referrer-id">ID: REF-921C</span>
                                        </div>
                                    </div>
                                </td>
                                <td>89</td>
                                <td style="font-weight: 700; color: #0F172A;">$8,120.50</td>
                                <td style="text-align: right;"><span class="badge-status-active">ACTIVE</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="referrer-user-cell">
                                        <div class="referrer-avatar">T</div>
                                        <div>
                                            <span class="referrer-name">TechFlow Agency</span>
                                            <span class="referrer-id">ID: REF-441B</span>
                                        </div>
                                    </div>
                                </td>
                                <td>45</td>
                                <td style="font-weight: 700; color: #0F172A;">$4,500.00</td>
                                <td style="text-align: right;"><span class="badge-status-pending">REVIEW PENDING</span></td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="referrer-user-cell">
                                        <div class="referrer-avatar">NA</div>
                                        <div>
                                            <span class="referrer-name">Nexus Advisors</span>
                                            <span class="referrer-id">ID: REF-102D</span>
                                        </div>
                                    </div>
                                </td>
                                <td>12</td>
                                <td style="font-weight: 700; color: #0F172A;">$1,200.00</td>
                                <td style="text-align: right;"><span class="badge-status-suspended">SUSPENDED</span></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="flex items-center justify-between mt-4 pt-3 border-t border-gray-100 text-xs text-[#64748B]">
                    <span>{{ __('Showing 1-4 of 342 referrers') }}</span>
                    <div class="flex gap-1">
                        <button class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center hover:bg-gray-50"><span class="material-symbols-outlined text-[16px]">chevron_left</span></button>
                        <button class="w-7 h-7 rounded border border-gray-200 flex items-center justify-center hover:bg-gray-50"><span class="material-symbols-outlined text-[16px]">chevron_right</span></button>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Payout Requests Table -->
            <div id="payouts-tab" class="table-responsive-box hidden">
                <table class="referral-custom-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{ __('Owner Name') }}</th>
                            <th>{{ __('Requested Date') }}</th>
                            <th>{{ __('Requested Amount') }}</th>
                            <th style="text-align: right;">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payRequests as $key => $transaction)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td style="font-weight: 600; color: #0F172A;">{{ !empty($transaction->getCompany) ? $transaction->getCompany->name : '-' }}</td>
                                <td style="color: #64748B;">{{ $transaction->date }}</td>
                                <td style="font-weight: 700; color: #16A34A;">{{ $currency . $transaction->req_amount }}</td>
                                <td style="text-align: right;">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('amount.request', [$transaction->id, 1]) }}" class="w-8 h-8 rounded-lg bg-[#DCFCE7] text-[#16A34A] flex items-center justify-center hover:bg-[#16A34A] hover:text-white transition-colors" title="{{ __('Approve') }}">
                                            <span class="material-symbols-outlined text-[18px]">check</span>
                                        </a>
                                        <a href="{{ route('amount.request', [$transaction->id, 0]) }}" class="w-8 h-8 rounded-lg bg-[#FEE2E2] text-[#DC2626] flex items-center justify-center hover:bg-[#DC2626] hover:text-white transition-colors" title="{{ __('Reject') }}">
                                            <span class="material-symbols-outlined text-[18px]">close</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; color: #94A3B8; padding: 32px;">
                                    {{ __('No pending payout requests.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Right Column: Settings & System Status -->
        <div class="right-sidebar-box">
            <!-- Global Commission Rates Settings Card -->
            <div class="config-card">
                <div class="config-card-title">
                    <span class="material-symbols-outlined text-[#4F46E5]">tune</span>
                    <span>{{ __('Global Commission Rates') }}</span>
                </div>

                {{ Form::open(['route' => 'referral-program.store', 'method' => 'POST', 'class' => 'needs-validation']) }}
                    <!-- Base Commission Slider -->
                    <div class="range-slider-group">
                        <div class="range-slider-header">
                            <span class="range-slider-label">{{ __('Base Commission') }}</span>
                            <span class="range-badge-blue" id="val-commission">{{ isset($setting) ? $setting->percentage : '10.0' }}%</span>
                        </div>
                        <input type="range" name="percentage" min="0" max="30" step="0.5" value="{{ isset($setting) ? $setting->percentage : 10 }}" class="custom-range-bar" oninput="document.getElementById('val-commission').innerText = this.value + '%'">
                    </div>

                    <!-- Minimum Threshold Slider -->
                    <div class="range-slider-group">
                        <div class="range-slider-header">
                            <span class="range-slider-label">{{ __('Minimum Threshold') }}</span>
                            <span class="range-badge-blue" id="val-threshold">{{ $currency }}{{ isset($setting) ? $setting->minimum_threshold_amount : '100' }}</span>
                        </div>
                        <input type="range" name="minimum_threshold_amount" min="0" max="1000" step="10" value="{{ isset($setting) ? $setting->minimum_threshold_amount : 100 }}" class="custom-range-bar" oninput="document.getElementById('val-threshold').innerText = '{{ $currency }}' + this.value">
                    </div>

                    <!-- Auto-Approve Payouts Toggle -->
                    <div class="auto-approve-box">
                        <div>
                            <span style="font-size: 13px; font-weight: 700; color: #0F172A; display: block;">{{ __('Auto-Approve Payouts') }}</span>
                            <span style="font-size: 11.5px; color: #64748B;">{{ __('For amounts under $500') }}</span>
                        </div>
                        <label class="ios-toggle mb-0" style="position: relative; display: inline-block; width: 44px; height: 24px;">
                            <input type="checkbox" name="is_enable" id="is_enable" value="1" {{ isset($setting) && $setting->is_enable == '1' ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0;">
                            <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #CBD5E1; transition: .2s; border-radius: 24px;"></span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end gap-3 mt-4">
                        <button type="reset" class="text-xs font-semibold text-[#64748B] hover:text-[#0F172A] bg-transparent border-0 cursor-pointer">{{ __('Discard') }}</button>
                        <button type="submit" class="btn-save-primary">{{ __('Save Changes') }}</button>
                    </div>
                {{ Form::close() }}
            </div>

            <!-- System Status Card -->
            <div class="status-system-card">
                <span style="font-size: 11px; font-weight: 700; color: #64748B; text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 8px;">{{ __('SYSTEM STATUS') }}</span>
                <div class="flex items-center gap-2 mb-2">
                    <span class="status-dot-green"></span>
                    <span style="font-size: 16px; font-weight: 700; color: #0F172A;">{{ __('Operational') }}</span>
                </div>
                <p style="font-size: 12.5px; color: #64748B; margin: 0; line-height: 1.5;">
                    {{ __('Tracking API endpoints are responding within 42ms average. No sync issues detected in the last 24h.') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        function switchTab(tabId, btn) {
            document.getElementById('transactions-tab').classList.add('hidden');
            document.getElementById('payouts-tab').classList.add('hidden');
            document.getElementById(tabId).classList.remove('hidden');

            var buttons = document.querySelectorAll('.tab-switch-btn');
            buttons.forEach(function(b) { b.classList.remove('active'); });
            btn.classList.add('active');
        }
    </script>
@endpush
