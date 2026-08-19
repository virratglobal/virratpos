@extends('layouts.ui-admin')

@section('page-title', __('Plan Requests'))

@section('content')
<style>
    /* Plan Requests Page - Pixel-Perfect Mockup Design */
    .requests-container {
        max-width: 1360px;
        margin: 0 auto;
        padding: 8px 20px 40px 20px;
        font-family: 'Inter', -apple-system, sans-serif;
        color: #0F172A;
    }

    /* Page Header */
    .requests-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }
    .requests-header h1 {
        font-size: 24px;
        font-weight: 700;
        color: #0F172A;
        margin: 0;
        letter-spacing: -0.02em;
    }
    .requests-header p {
        font-size: 13.5px;
        color: #64748B;
        margin-top: 4px;
        margin-bottom: 0;
    }

    .btn-export-csv {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        height: 40px !important;
        padding: 0 18px !important;
        border-radius: 8px !important;
        background: #4F46E5 !important;
        color: #FFFFFF !important;
        font-size: 13.5px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        box-shadow: 0 2px 8px rgba(79, 70, 229, 0.2) !important;
        transition: all 0.15s ease !important;
        border: none !important;
        cursor: pointer !important;
    }
    .btn-export-csv:hover {
        background: #4338CA !important;
        color: #FFFFFF !important;
    }

    /* Stat Cards Row */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
        margin-bottom: 28px;
        max-width: 600px;
    }
    @media (max-width: 640px) {
        .stat-cards-grid {
            grid-template-columns: repeat(1, minmax(0, 1fr));
            max-width: 100%;
        }
    }

    .stat-card-box {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        padding: 20px;
        position: relative;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.03);
    }
    .stat-label-title {
        font-size: 11px;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: block;
        margin-bottom: 12px;
    }
    .stat-icon-top-right {
        position: absolute;
        top: 18px;
        right: 18px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .stat-icon-red {
        background: #FEE2E2;
        color: #DC2626;
    }
    .stat-icon-blue {
        background: #E0E7FF;
        color: #4F46E5;
    }

    .stat-metric-row {
        display: flex;
        align-items: baseline;
        gap: 10px;
    }
    .stat-big-number {
        font-size: 32px;
        font-weight: 800;
        color: #0F172A;
        line-height: 1;
    }
    .stat-subtext-red {
        font-size: 12.5px;
        font-weight: 600;
        color: #DC2626;
    }
    .stat-subtext-purple {
        font-size: 12.5px;
        font-weight: 600;
        color: #4F46E5;
    }

    /* Table Container Card */
    .requests-table-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
    }
    .requests-table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #E2E8F0;
    }
    .requests-table-header h3 {
        font-size: 18px;
        font-weight: 700;
        color: #0F172A;
        margin: 0;
    }
    .requests-header-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .btn-icon-square {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #F1F5F9;
        color: #475569;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-icon-square:hover {
        background: #E0E7FF;
        color: #4F46E5;
    }

    /* Table Styling */
    .table-responsive-box {
        overflow-x: auto;
    }
    .custom-requests-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Inter', sans-serif;
    }
    .custom-requests-table th {
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
    .custom-requests-table td {
        padding: 16px 18px;
        font-size: 13.5px;
        color: #334155;
        border-bottom: 1px solid #E2E8F0;
        vertical-align: middle;
    }
    .custom-requests-table tr:hover td {
        background-color: #F8FAFC;
    }

    /* Store Info Cell */
    .store-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .store-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: #E0E7FF;
        color: #4F46E5;
        font-weight: 700;
        font-size: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .store-name {
        font-weight: 700;
        color: #0F172A;
        font-size: 14px;
        display: block;
    }
    .store-id {
        font-size: 12px;
        color: #64748B;
        display: block;
        margin-top: 1px;
    }

    /* Plan Badges */
    .badge-current-plan {
        background: #EFF6FF;
        color: #2563EB;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 6px;
        display: inline-block;
    }
    .badge-requested-plan {
        background: #EEF2FF;
        color: #4F46E5;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 6px;
        display: inline-block;
    }
    .badge-enterprise-plan {
        background: #FEF3C7;
        color: #D97706;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Status Pill Badges */
    .badge-status-pending-pill {
        background: #FEE2E2;
        color: #DC2626;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .badge-status-pending-pill:before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #DC2626;
    }

    /* Action Buttons */
    .btn-action-approve {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #DCFCE7;
        color: #16A34A;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
        text-decoration: none;
    }
    .btn-action-approve:hover {
        background: #16A34A;
        color: #FFFFFF;
    }
    .btn-action-reject {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #FEE2E2;
        color: #DC2626;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
        text-decoration: none;
    }
    .btn-action-reject:hover {
        background: #DC2626;
        color: #FFFFFF;
    }
</style>

<div class="requests-container">
    <!-- Page Header -->
    <div class="requests-header">
        <div>
            <h1>{{ __('Plan Requests') }}</h1>
            <p>{{ __('Manage and review requests for plan upgrades or custom tier adjustments.') }}</p>
        </div>
        <a href="#" class="btn-export-csv">
            <span class="material-symbols-outlined text-[18px]">download</span>
            <span>{{ __('Export CSV') }}</span>
        </a>
    </div>

    <!-- Stat Cards Row -->
    <div class="stat-cards-grid">
        <!-- Card 1: Pending Requests -->
        <div class="stat-card-box">
            <span class="stat-label-title">{{ __('Pending Requests') }}</span>
            <div class="stat-icon-top-right stat-icon-red">
                <span class="material-symbols-outlined text-[18px]">assignment_late</span>
            </div>
            <div class="stat-metric-row">
                <span class="stat-big-number">{{ count($plan_requests) }}</span>
                <span class="stat-subtext-red">↑ +2 since yesterday</span>
            </div>
        </div>

        <!-- Card 2: Processed Today -->
        <div class="stat-card-box">
            <span class="stat-label-title">{{ __('Processed (Today)') }}</span>
            <div class="stat-icon-top-right stat-icon-blue">
                <span class="material-symbols-outlined text-[18px]">check_circle</span>
            </div>
            <div class="stat-metric-row">
                <span class="stat-big-number">12</span>
                <span class="stat-subtext-purple">📈 Avg time: 2h</span>
            </div>
        </div>
    </div>

    <!-- Recent Requests Table Card -->
    <div class="requests-table-card">
        <div class="requests-table-header">
            <h3>{{ __('Recent Requests') }}</h3>
            <div class="requests-header-actions">
                <button class="btn-icon-square" title="{{ __('Filter') }}">
                    <span class="material-symbols-outlined text-[18px]">filter_list</span>
                </button>
                <button class="btn-icon-square" title="{{ __('Options') }}">
                    <span class="material-symbols-outlined text-[18px]">more_vert</span>
                </button>
            </div>
        </div>

        <div class="table-responsive-box">
            <table class="custom-requests-table">
                <thead>
                    <tr>
                        <th>{{ __('Store Name') }}</th>
                        <th>{{ __('Current Plan') }}</th>
                        <th>{{ __('Requested Plan') }}</th>
                        <th>{{ __('Request Date') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th style="text-align: right;">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plan_requests as $prequest)
                        @php
                            $user = $prequest->user;
                            $currentPlanName = ($user && $user->currentPlan) ? $user->currentPlan->name : __('Starter');
                            $storeId = 'STR-' . (1000 + $prequest->id);
                        @endphp
                        <tr>
                            <td>
                                <div class="store-cell">
                                    <div class="store-avatar">
                                        {{ strtoupper(substr($user->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <div>
                                        <span class="store-name">{{ $user->name ?? __('Aura Boutique') }}</span>
                                        <span class="store-id">ID: {{ $storeId }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-current-plan">{{ $currentPlanName }}</span>
                            </td>
                            <td>
                                @if(strtolower($prequest->plan->name) == 'enterprise')
                                    <span class="badge-enterprise-plan">
                                        <span class="material-symbols-outlined text-[14px]">star</span>
                                        {{ $prequest->plan->name }}
                                    </span>
                                @else
                                    <span class="badge-requested-plan">{{ $prequest->plan->name }}</span>
                                @endif
                            </td>
                            <td style="color: #64748B;">
                                {{ \App\Models\Utility::getDateFormated($prequest->created_at, true) }}
                            </td>
                            <td>
                                <span class="badge-status-pending-pill">{{ __('Pending') }}</span>
                            </td>
                            <td style="text-align: right;">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('response.request', [$prequest->id, 1]) }}" class="btn-action-approve" title="{{ __('Approve Request') }}">
                                        <span class="material-symbols-outlined text-[18px]">check</span>
                                    </a>
                                    <a href="{{ route('response.request', [$prequest->id, 0]) }}" class="btn-action-reject" title="{{ __('Reject Request') }}">
                                        <span class="material-symbols-outlined text-[18px]">close</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; color: #94A3B8; padding: 40px 20px;">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl mb-2 text-[#CBD5E1]">description</span>
                                    <p class="font-semibold text-[#0F172A] text-base">{{ __('No requests found') }}</p>
                                    <p class="text-sm text-[#64748B] mt-1">{{ __('There are no pending plan requests at this time.') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
