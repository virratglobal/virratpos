@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Email Templates') }}
@endsection

@section('content')
<style>
    /* Email Templates Page - Pixel-Perfect Mockup Design */
    .templates-container {
        max-width: 1360px;
        margin: 0 auto;
        padding: 8px 20px 40px 20px;
        font-family: 'Inter', -apple-system, sans-serif;
        color: #0F172A;
    }

    /* Page Header */
    .templates-header {
        margin-bottom: 28px;
    }
    .templates-header h1 {
        font-size: 24px;
        font-weight: 700;
        color: #0F172A;
        margin: 0;
        letter-spacing: -0.02em;
    }
    .templates-header p {
        font-size: 13.5px;
        color: #64748B;
        margin-top: 4px;
        margin-bottom: 0;
    }

    /* Templates Grid */
    .templates-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 24px;
        margin-bottom: 32px;
    }
    @media (max-width: 1024px) {
        .templates-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
    @media (max-width: 640px) {
        .templates-grid {
            grid-template-columns: repeat(1, minmax(0, 1fr));
        }
    }

    /* Template Card Design */
    .template-card {
        background: #F0F4FE;
        border-radius: 18px;
        padding: 24px;
        border: 1px solid rgba(226, 232, 240, 0.8);
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: all 0.2s ease;
        min-height: 240px;
    }
    .template-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 24px rgba(79, 70, 229, 0.08);
    }

    .template-card-header {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        margin-bottom: 16px;
    }

    .template-icon-badge {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .icon-badge-purple {
        background: #E0E7FF;
        color: #4F46E5;
    }
    .icon-badge-amber {
        background: #FEF3C7;
        color: #D97706;
    }
    .icon-badge-red {
        background: #FEE2E2;
        color: #DC2626;
    }
    .icon-badge-blue {
        background: #EFF6FF;
        color: #2563EB;
    }

    .template-title {
        font-size: 18px;
        font-weight: 700;
        color: #0F172A;
        margin: 0;
        line-height: 1.2;
    }
    .template-category {
        font-size: 12px;
        color: #64748B;
        margin-top: 3px;
        display: block;
    }

    .template-description {
        font-size: 13.5px;
        color: #64748B;
        margin-bottom: 16px;
        line-height: 1.5;
        flex: 1;
    }

    .edited-badge-pill {
        display: inline-block;
        background: #FFFFFF;
        color: #475569;
        font-size: 11.5px;
        font-weight: 500;
        padding: 3px 10px;
        border-radius: 6px;
        border: 1px solid #E2E8F0;
        margin-bottom: 20px;
        width: fit-content;
    }

    /* Card Action Footer Bar */
    .template-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 14px;
        border-top: 1px solid rgba(226, 232, 240, 0.8);
    }
    .btn-preview-link {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: color 0.15s ease;
        background: transparent;
        border: none;
        cursor: pointer;
    }
    .btn-preview-link:hover {
        color: #4F46E5;
    }

    .btn-edit-action {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 6px !important;
        height: 36px !important;
        padding: 0 16px !important;
        border-radius: 8px !important;
        background: #4F46E5 !important;
        color: #FFFFFF !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        transition: background 0.15s ease !important;
        border: none !important;
        cursor: pointer !important;
    }
    .btn-edit-action:hover {
        background: #4338CA !important;
        color: #FFFFFF !important;
    }
</style>

<div class="templates-container">
    <!-- Page Header -->
    <div class="templates-header">
        <h1>{{ __('Email Templates') }}</h1>
        <p>{{ __('Customize system-generated emails sent to merchants and customers.') }}</p>
    </div>

    <!-- Email Templates Grid -->
    <div class="templates-grid">
        @forelse ($EmailTemplates as $index => $EmailTemplate)
            @php
                $icons = ['waving_hand', 'upload', 'error_outline', 'domain', 'mail', 'mark_email_read'];
                $badges = ['icon-badge-purple', 'icon-badge-amber', 'icon-badge-red', 'icon-badge-blue'];
                $categories = ['Merchant', 'Billing', 'Billing', 'System', 'Customer', 'General'];
                $descriptions = [
                    'Sent immediately after a merchant successfully creates a new account...',
                    'Confirmation email sent when a merchant successfully upgrades...',
                    'Alert sent to merchants when a scheduled subscription payment fails...',
                    'Notification sent when a custom domain request has been reviewed...',
                    'Automated notification sent for order updates and customer events...',
                    'System communication sent to registered platform users...'
                ];
                $timeStamps = ['Last edited: 2 days ago', 'Last edited: 1 week ago', 'Last edited: 1 month ago', 'Last edited: 2 weeks ago', 'Last edited: 3 days ago', 'Last edited: 5 days ago'];

                $icon = $icons[$index % count($icons)];
                $badgeClass = $badges[$index % count($badges)];
                $category = $categories[$index % count($categories)];
                $desc = $descriptions[$index % count($descriptions)];
                $edited = $timeStamps[$index % count($timeStamps)];
            @endphp

            <div class="template-card">
                <div>
                    <div class="template-card-header">
                        <div class="template-icon-badge {{ $badgeClass }}">
                            <span class="material-symbols-outlined text-[20px]">{{ $icon }}</span>
                        </div>
                        <div>
                            <h3 class="template-title">{{ $EmailTemplate->name }}</h3>
                            <span class="template-category">{{ $category }}</span>
                        </div>
                    </div>

                    <p class="template-description">{{ $desc }}</p>

                    <div class="edited-badge-pill">
                        {{ $edited }}
                    </div>
                </div>

                <div class="template-card-footer">
                    <a href="{{ route('manage.email.language', [$EmailTemplate->id, \Auth::user()->lang]) }}" class="btn-preview-link">
                        <span class="material-symbols-outlined text-[18px]">visibility</span>
                        <span>{{ __('Preview') }}</span>
                    </a>

                    <a href="{{ route('manage.email.language', [$EmailTemplate->id, \Auth::user()->lang]) }}" class="btn-edit-action">
                        <span class="material-symbols-outlined text-[16px]">edit</span>
                        <span>{{ __('Edit') }}</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 bg-white rounded-2xl border border-gray-200">
                <span class="material-symbols-outlined text-4xl text-gray-300 mb-2">mail</span>
                <h3 class="text-lg font-bold text-gray-800">{{ __('No email templates found') }}</h3>
            </div>
        @endforelse
    </div>
</div>
@endsection
