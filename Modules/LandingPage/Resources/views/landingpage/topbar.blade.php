@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Landing Page') }}
@endsection

@php
    $logo = \App\Models\Utility::get_file('uploads/logo');
    $settings = \Modules\LandingPage\Entities\LandingPageSetting::settings();
    $site_settings = Utility::settings();
@endphp

@section('content')
<style>
    /* Landing Page Configuration - Pixel-Perfect Mockup Design */
    .landing-container {
        max-width: 1360px;
        margin: 0 auto;
        padding: 8px 20px 40px 20px;
        font-family: 'Inter', -apple-system, sans-serif;
        color: #0F172A;
    }

    /* Top Page Header */
    .landing-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 28px;
        position: relative;
    }
    .landing-header-title-box {
        position: relative;
        padding-left: 20px;
    }
    .landing-header-title-box::before {
        content: '';
        position: absolute;
        left: 0;
        top: 4px;
        bottom: 4px;
        width: 5px;
        background: #4F46E5;
        border-radius: 4px;
    }
    .landing-tag-number {
        font-size: 11px;
        font-weight: 700;
        color: #4F46E5;
        letter-spacing: 0.1em;
        display: block;
        margin-bottom: 2px;
    }
    .landing-header-title-box h1 {
        font-size: 26px;
        font-weight: 800;
        color: #0F172A;
        margin: 0;
        letter-spacing: -0.02em;
        text-transform: uppercase;
        line-height: 1.15;
    }
    .landing-header-title-box p {
        font-size: 13.5px;
        color: #64748B;
        margin-top: 6px;
        margin-bottom: 0;
        max-width: 620px;
        line-height: 1.5;
    }

    .landing-header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .btn-discard-changes {
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
    .btn-discard-changes:hover {
        background: #DBEAFE;
        color: #1D4ED8;
    }

    .btn-publish-build {
        height: 42px;
        padding: 0 22px;
        border-radius: 10px;
        background: #4F46E5;
        color: #FFFFFF;
        font-size: 13.5px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.25);
        transition: background 0.15s ease;
    }
    .btn-publish-build:hover {
        background: #4338CA;
        color: #FFFFFF;
    }

    /* 2-Column Responsive Layout Grid */
    .landing-layout-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 24px;
    }
    @media (max-width: 1024px) {
        .landing-layout-grid {
            grid-template-columns: 1fr;
        }
    }

    /* White Card Tiles */
    .landing-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.03);
    }
    .landing-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .landing-card-title-group {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }
    .landing-card-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #EEF2FF;
        color: #4F46E5;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .landing-card-title-group h3 {
        font-size: 17px;
        font-weight: 700;
        color: #0F172A;
        margin: 0;
    }
    .landing-card-title-group p {
        font-size: 12.5px;
        color: #64748B;
        margin: 2px 0 0 0;
    }

    /* Form Fields */
    .field-label-group {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 6px;
    }
    .field-label {
        font-size: 11px;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .field-char-count {
        font-size: 11px;
        color: #94A3B8;
    }

    .form-input-white {
        width: 100%;
        height: 44px;
        padding: 0 14px;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        background: #F8FAFC;
        color: #0F172A;
        font-size: 13.5px;
        font-weight: 500;
        transition: all 0.15s ease;
        margin-bottom: 18px;
    }
    .form-input-white:focus {
        background: #FFFFFF;
        border-color: #4F46E5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    .form-textarea-white {
        width: 100%;
        padding: 12px 14px;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        background: #F8FAFC;
        color: #0F172A;
        font-size: 13.5px;
        font-weight: 500;
        line-height: 1.5;
        transition: all 0.15s ease;
        margin-bottom: 18px;
        resize: vertical;
        min-height: 85px;
    }
    .form-textarea-white:focus {
        background: #FFFFFF;
        border-color: #4F46E5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    /* Inner Soft Card Container */
    .inner-soft-tile {
        background: #F0F4FE;
        border-radius: 12px;
        padding: 18px;
        margin-top: 10px;
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }
    @media (max-width: 640px) {
        .inner-soft-tile {
            grid-template-columns: 1fr;
        }
    }

    /* Draggable Item List */
    .repeater-item-box {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 12px;
    }
    .drag-handle-icon {
        color: #94A3B8;
        cursor: grab;
        font-size: 20px;
    }
    .feature-item-badge {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #E0E7FF;
        color: #4F46E5;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .feature-item-badge-gold {
        background: #FEF3C7;
        color: #D97706;
    }

    .btn-add-feature {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #F1F5F9;
        color: #475569;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-add-feature:hover {
        background: #4F46E5;
        color: #FFFFFF;
    }

    /* Right Column Cards */
    .og-image-preview-card {
        width: 100%;
        height: 120px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #E2E8F0;
        background: #F8FAFC;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 8px;
    }
    .og-image-preview-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .toggle-row-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #F1F5F9;
    }
    .toggle-row-item:last-child {
        border-bottom: none;
    }
    .toggle-info h5 {
        font-size: 13.5px;
        font-weight: 600;
        color: #0F172A;
        margin: 0;
    }
    .toggle-info p {
        font-size: 11.5px;
        color: #64748B;
        margin: 2px 0 0 0;
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
        background-color: #4F46E5;
    }
    .ios-toggle input:checked + .ios-toggle-slider:before {
        transform: translateX(20px);
    }
</style>

<div class="landing-container">
    {{ Form::model(null, array('route' => array('landingpage.store'), 'method' => 'POST')) }}
    @csrf

    <!-- Top Page Header -->
    <div class="landing-header">
        <div class="landing-header-title-box">
            <span class="landing-tag-number">01</span>
            <h1>{{ __('LANDING PAGE CONFIGURATION') }}</h1>
            <p>{{ __('Modify the structural content and metadata of the platform\'s primary public-facing entry point. Changes require system recompilation to take effect globally.') }}</p>
        </div>

        <div class="landing-header-actions">
            <button type="reset" class="btn-discard-changes">
                <span class="material-symbols-outlined text-[18px]">sync</span>
                <span>{{ __('Discard Changes') }}</span>
            </button>

            <button type="submit" class="btn-publish-build">
                <span class="material-symbols-outlined text-[18px]">cloud_upload</span>
                <span>{{ __('Publish Build') }}</span>
            </button>
        </div>
    </div>

    <!-- 2-Column Responsive Layout Grid -->
    <div class="landing-layout-grid">
        <!-- Left Main Column (65-70%) -->
        <div>
            <!-- Hero Section Card -->
            <div class="landing-card">
                <div class="landing-card-header">
                    <div class="landing-card-title-group">
                        <div class="landing-card-icon">
                            <span class="material-symbols-outlined">smartphone</span>
                        </div>
                        <div>
                            <h3>{{ __('Hero Section') }}</h3>
                            <p>{{ __('Primary visible elements upon initial page load.') }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="field-label-group">
                        <label class="field-label">{{ __('PRIMARY HEADLINE (H1)') }}</label>
                        <span class="field-char-count">46/60 chars</span>
                    </div>
                    <input type="text" name="home_heading" class="form-input-white" value="{{ $settings['home_heading'] ?? 'Empowering the Next Generation of Commerce' }}" placeholder="{{ __('Enter Primary Headline') }}">

                    <div class="field-label-group">
                        <label class="field-label">{{ __('SUBHEADLINE (H2)') }}</label>
                    </div>
                    <textarea name="topbar_notification_msg" class="form-textarea-white" rows="3" placeholder="{{ __('Enter Subheadline') }}">{{ $settings['topbar_notification_msg'] ?? 'A unified platform designed for scalability, performance, and unparalleled control. Join thousands of enterprises transforming their operations today.' }}</textarea>

                    <!-- Inner Soft Tile Box for Call To Actions -->
                    <div class="inner-soft-tile">
                        <div>
                            <label class="field-label mb-1.5 block">{{ __('PRIMARY CTA LABEL') }}</label>
                            <input type="text" name="home_live_demo_link" class="form-input-white mb-0" value="{{ $settings['home_live_demo_link'] ?? 'Start Free Trial' }}" placeholder="{{ __('Start Free Trial') }}">
                        </div>

                        <div>
                            <label class="field-label mb-1.5 block">{{ __('SECONDARY CTA LABEL') }}</label>
                            <input type="text" name="home_buy_now_link" class="form-input-white mb-0" value="{{ $settings['home_buy_now_link'] ?? 'View Documentation' }}" placeholder="{{ __('View Documentation') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feature Highlights Card -->
            <div class="landing-card">
                <div class="landing-card-header">
                    <div class="landing-card-title-group">
                        <div class="landing-card-icon">
                            <span class="material-symbols-outlined">grid_view</span>
                        </div>
                        <div>
                            <h3>{{ __('Feature Highlights') }}</h3>
                            <p>{{ __('Bento grid configuration for core value propositions.') }}</p>
                        </div>
                    </div>

                    <button type="button" class="btn-add-feature" title="{{ __('Add Feature') }}">
                        <span class="material-symbols-outlined text-[20px]">add</span>
                    </button>
                </div>

                <!-- Feature Items List -->
                <div>
                    <div class="repeater-item-box">
                        <span class="material-symbols-outlined drag-handle-icon">drag_indicator</span>

                        <div class="feature-item-badge">
                            <span class="material-symbols-outlined text-[18px]">speed</span>
                        </div>

                        <div class="flex-1 grid grid-cols-2 gap-3">
                            <div>
                                <label class="field-label block mb-1">{{ __('FEATURE TITLE') }}</label>
                                <input type="text" class="form-input-white mb-0 text-xs font-semibold" value="Lightning Fast Exec" placeholder="{{ __('Feature Title') }}">
                            </div>
                            <div>
                                <label class="field-label block mb-1">{{ __('DESCRIPTION EXCERPT') }}</label>
                                <input type="text" class="form-input-white mb-0 text-xs" value="Sub-millisecond latency..." placeholder="{{ __('Description Excerpt') }}">
                            </div>
                        </div>

                        <button type="button" class="text-red-500 hover:text-red-700 p-1" title="{{ __('Delete') }}">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                    </div>

                    <div class="repeater-item-box">
                        <span class="material-symbols-outlined drag-handle-icon">drag_indicator</span>

                        <div class="feature-item-badge feature-item-badge-gold">
                            <span class="material-symbols-outlined text-[18px]">security</span>
                        </div>

                        <div class="flex-1 grid grid-cols-2 gap-3">
                            <div>
                                <label class="field-label block mb-1">{{ __('FEATURE TITLE') }}</label>
                                <input type="text" class="form-input-white mb-0 text-xs font-semibold" value="Enterprise-grade Security" placeholder="{{ __('Feature Title') }}">
                            </div>
                            <div>
                                <label class="field-label block mb-1">{{ __('DESCRIPTION EXCERPT') }}</label>
                                <input type="text" class="form-input-white mb-0 text-xs" value="End-to-end encryption..." placeholder="{{ __('Description Excerpt') }}">
                            </div>
                        </div>

                        <button type="button" class="text-red-500 hover:text-red-700 p-1" title="{{ __('Delete') }}">
                            <span class="material-symbols-outlined text-[18px]">delete</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column (30-35%) -->
        <div>
            <!-- SEO & Metadata Card -->
            <div class="landing-card">
                <div class="landing-card-header mb-4">
                    <div class="landing-card-title-group">
                        <div class="landing-card-icon">
                            <span class="material-symbols-outlined">search</span>
                        </div>
                        <div>
                            <h3>{{ __('SEO & Metadata') }}</h3>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="field-label block mb-1.5">{{ __('META TITLE') }}</label>
                    <input type="text" name="home_title" class="form-input-white" value="{{ $settings['home_title'] ?? 'PlatformName | Enterprise Commerce' }}" placeholder="{{ __('Meta Title') }}">

                    <label class="field-label block mb-1.5">{{ __('META DESCRIPTION') }}</label>
                    <textarea name="home_offer_text" class="form-textarea-white" rows="3" placeholder="{{ __('Meta Description') }}">{{ $settings['home_offer_text'] ?? 'A comprehensive platform for building, scaling, and managing complex commerce ecosystems. Secure, fast, and reliable.' }}</textarea>

                    <label class="field-label block mb-1.5">{{ __('OPEN GRAPH IMAGE') }}</label>
                    <div class="og-image-preview-card">
                        <img id="image" src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600&auto=format&fit=crop&q=60" alt="OG Banner">
                    </div>
                </div>
            </div>

            <!-- Advanced Settings Card -->
            <div class="landing-card">
                <div class="landing-card-header mb-2">
                    <div class="landing-card-title-group">
                        <div>
                            <h3>{{ __('Advanced Settings') }}</h3>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="toggle-row-item">
                        <div class="toggle-info">
                            <h5>{{ __('Maintenance Mode') }}</h5>
                            <p>{{ __('Redirect public traffic to fallback.') }}</p>
                        </div>
                        <label class="ios-toggle">
                            <input type="checkbox" name="topbar_status" {{ ($settings['topbar_status'] ?? '') == 'on' ? 'checked' : '' }}>
                            <span class="ios-toggle-slider"></span>
                        </label>
                    </div>

                    <div class="toggle-row-item">
                        <div class="toggle-info">
                            <h5>{{ __('A/B Testing') }}</h5>
                            <p>{{ __('Enable dynamic variant routing.') }}</p>
                        </div>
                        <label class="ios-toggle">
                            <input type="checkbox" name="ab_testing" checked>
                            <span class="ios-toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>
@endsection
