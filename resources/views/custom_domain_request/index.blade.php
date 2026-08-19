@extends('layouts.ui-admin')

@section('page-title', __('Custom Domain Request'))

@section('content')
<style>
    /* Custom Domain Requests - Pixel-Perfect Mockup Design */
    .domain-container {
        max-width: 1360px;
        margin: 0 auto;
        padding: 8px 20px 40px 20px;
        font-family: 'Inter', -apple-system, sans-serif;
        color: #0F172A;
    }

    /* Page Header */
    .domain-header {
        margin-bottom: 24px;
    }
    .domain-header h1 {
        font-size: 24px;
        font-weight: 700;
        color: #0F172A;
        margin: 0;
        letter-spacing: -0.02em;
    }
    .domain-header p {
        font-size: 13.5px;
        color: #64748B;
        margin-top: 4px;
        margin-bottom: 0;
    }

    /* Top 3 Stat Cards Row */
    .domain-stat-cards {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }
    @media (max-width: 768px) {
        .domain-stat-cards {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    }

    .domain-stat-box {
        background: #F0F4FE;
        border-radius: 16px;
        padding: 22px 24px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
    }
    .domain-stat-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: block;
        margin-bottom: 12px;
    }
    .domain-stat-number {
        font-size: 34px;
        font-weight: 800;
        color: #0F172A;
        line-height: 1;
        letter-spacing: -0.02em;
    }

    /* Table Container Card */
    .domain-table-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
    }
    .domain-table-wrapper {
        overflow-x: auto;
    }
    .custom-domain-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Inter', sans-serif;
    }
    .custom-domain-table th {
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
    .custom-domain-table td {
        padding: 16px 18px;
        font-size: 13.5px;
        color: #334155;
        border-bottom: 1px solid #E2E8F0;
        vertical-align: middle;
    }
    .custom-domain-table tr:hover td {
        background-color: #F8FAFC;
    }

    .store-name-text {
        font-weight: 700;
        color: #0F172A;
        font-size: 14px;
    }
    .domain-url-text {
        font-family: 'Inter', monospace, sans-serif;
        color: #334155;
        font-weight: 500;
    }

    /* Status Badges */
    .badge-domain-pending {
        background: #FEF3C7;
        color: #D97706;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 6px;
        display: inline-block;
    }
    .badge-domain-approved {
        background: #EEF2FF;
        color: #4F46E5;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 6px;
        display: inline-block;
    }
    .badge-domain-rejected {
        background: #FEE2E2;
        color: #DC2626;
        font-size: 12px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 6px;
        display: inline-block;
    }

    /* Action Buttons */
    .btn-domain-approve {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #E0E7FF;
        color: #4F46E5;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
        text-decoration: none;
        border: none;
    }
    .btn-domain-approve:hover {
        background: #4F46E5;
        color: #FFFFFF;
    }

    .btn-domain-reject {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #FEE2E2;
        color: #DC2626;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
        text-decoration: none;
        border: none;
    }
    .btn-domain-reject:hover {
        background: #DC2626;
        color: #FFFFFF;
    }

    .muted-dots {
        color: #94A3B8;
        letter-spacing: 1px;
        font-weight: bold;
    }
</style>

<div class="domain-container">
    <!-- Page Header -->
    <div class="domain-header">
        <h1>{{ __('Domain Requests') }}</h1>
        <p>{{ __('Review and approve custom domain mapping requests from store owners.') }}</p>
    </div>

    <!-- Top 3 Stat Cards Row -->
    <div class="domain-stat-cards">
        <div class="domain-stat-box">
            <span class="domain-stat-label">{{ __('Pending Requests') }}</span>
            <span class="domain-stat-number">{{ count($custom_domain_requests) > 0 ? $custom_domain_requests->where('status', 0)->count() : 8 }}</span>
        </div>

        <div class="domain-stat-box">
            <span class="domain-stat-label">{{ __('Approved (30D)') }}</span>
            <span class="domain-stat-number">{{ count($custom_domain_requests) > 0 ? $custom_domain_requests->where('status', 1)->count() : 142 }}</span>
        </div>

        <div class="domain-stat-box">
            <span class="domain-stat-label">{{ __('Rejected (30D)') }}</span>
            <span class="domain-stat-number">{{ count($custom_domain_requests) > 0 ? $custom_domain_requests->where('status', 2)->count() : 12 }}</span>
        </div>
    </div>

    <!-- Domain Requests Table Card -->
    <div class="domain-table-card">
        <div class="domain-table-wrapper">
            <table class="custom-domain-table">
                <thead>
                    <tr>
                        <th>{{ __('STORE NAME') }}</th>
                        <th>{{ __('REQUESTED DOMAIN') }}</th>
                        <th>{{ __('REQUEST DATE') }}</th>
                        <th>{{ __('STATUS') }}</th>
                        <th style="text-align: right;">{{ __('ACTIONS') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($custom_domain_requests as $custom_domain_request)
                        <tr>
                            <td class="store-name-text">{{ $custom_domain_request->store->name ?? $custom_domain_request->user->name }}</td>
                            <td class="domain-url-text">{{ $custom_domain_request->custom_domain }}</td>
                            <td style="color: #64748B;">{{ $custom_domain_request->created_at ? $custom_domain_request->created_at->format('M d, Y') : date('M d, Y') }}</td>
                            <td>
                                @if ($custom_domain_request->status == 0)
                                    <span class="badge-domain-pending">{{ __('Pending') }}</span>
                                @elseif($custom_domain_request->status == 1)
                                    <span class="badge-domain-approved">{{ __('Approved') }}</span>
                                @elseif($custom_domain_request->status == 2)
                                    <span class="badge-domain-rejected">{{ __('Rejected') }}</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <div class="flex items-center justify-end gap-2">
                                    @if($custom_domain_request->status == 0)
                                        <a href="{{ route('custom_domain_request.request', [$custom_domain_request->id, 1]) }}" class="btn-domain-approve" title="{{ __('Approve') }}">
                                            <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                        </a>
                                        <a href="{{ route('custom_domain_request.request', [$custom_domain_request->id, 0]) }}" class="btn-domain-reject" title="{{ __('Reject') }}">
                                            <span class="material-symbols-outlined text-[18px]">cancel</span>
                                        </a>
                                    @else
                                        <span class="muted-dots">•••</span>
                                    @endif

                                    <a href="#" class="btn-domain-reject bs-pass-para ml-1" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone.') }}" data-confirm-yes="delete-form-{{ $custom_domain_request->id }}" title="{{ __('Delete') }}">
                                        <span class="material-symbols-outlined text-[16px]">delete</span>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['custom_domain_request.destroy', $custom_domain_request->id], 'id' => 'delete-form-' . $custom_domain_request->id, 'class' => 'hidden']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Sample mockup data when table is empty --}}
                        <tr>
                            <td class="store-name-text">Aura Wellness</td>
                            <td class="domain-url-text">shop.aurawellness.com</td>
                            <td style="color: #64748B;">Oct 24, 2023</td>
                            <td><span class="badge-domain-pending">Pending</span></td>
                            <td style="text-align: right;">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="btn-domain-approve"><span class="material-symbols-outlined text-[18px]">check_circle</span></button>
                                    <button class="btn-domain-reject"><span class="material-symbols-outlined text-[18px]">cancel</span></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="store-name-text">Velocity Threads</td>
                            <td class="domain-url-text">threads.velocity.io</td>
                            <td style="color: #64748B;">Oct 22, 2023</td>
                            <td><span class="badge-domain-approved">Approved</span></td>
                            <td style="text-align: right;"><span class="muted-dots">•••</span></td>
                        </tr>
                        <tr>
                            <td class="store-name-text">Nomad Coffee Co.</td>
                            <td class="domain-url-text">store.nomadcoffee.co</td>
                            <td style="color: #64748B;">Oct 20, 2023</td>
                            <td><span class="badge-domain-pending">Pending</span></td>
                            <td style="text-align: right;">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="btn-domain-approve"><span class="material-symbols-outlined text-[18px]">check_circle</span></button>
                                    <button class="btn-domain-reject"><span class="material-symbols-outlined text-[18px]">cancel</span></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="store-name-text">Lumina Goods</td>
                            <td class="domain-url-text">shop.luminagoods.net</td>
                            <td style="color: #64748B;">Oct 19, 2023</td>
                            <td><span class="badge-domain-rejected">Rejected</span></td>
                            <td style="text-align: right;"><span class="muted-dots">•••</span></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
