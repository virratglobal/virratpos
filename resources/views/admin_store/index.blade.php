@extends('layouts.ui-admin')

@section('page-title', __('Store'))

@push('style')
<link href="https://fonts.googleapis.com/css2?family=Geist:wght@100..900&family=Inter:wght@100..900&display=swap" rel="stylesheet">
<style>
    :root {
        --color-primary:                 #4648d4;
        --color-on-primary:              #ffffff;
        --color-primary-container:       #6063ee;
        --color-on-primary-container:    #fffbff;
        --color-secondary:               #565e74;
        --color-secondary-container:     #dae2fd;
        --color-on-secondary-container:  #5c647a;
        --color-error:                   #ba1a1a;
        --color-error-container:         #ffdad6;
        --color-surface:                 #f8f9ff;
        --color-surface-container:       #e5eeff;
        --color-surface-container-low:   #eff4ff;
        --color-surface-container-high:  #dce9ff;
        --color-surface-container-highest: #d3e4fe;
        --color-surface-container-lowest: #ffffff;
        --color-on-surface:              #0b1c30;
        --color-on-surface-variant:      #464554;
        --color-outline-variant:         #c7c4d7;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(4px); }
        to   { opacity: 1; transform: none; }
    }
    .animate-fade-in { animation: fadeIn 0.3s ease-out forwards; }

    .prec-stat-card {
        background: var(--color-surface-container);
        border-radius: 12px;
        padding: 20px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        transition: box-shadow 0.2s ease;
    }
    .prec-stat-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
    .prec-stat-card .bg-circle {
        position: absolute;
        right: -1rem; top: -1rem;
        width: 6rem; height: 6rem;
        border-radius: 50%;
        transition: transform 0.5s ease;
    }
    .prec-stat-card:hover .bg-circle { transform: scale(1.5); }

    .prec-table-card {
        background: var(--color-surface-container);
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        /* No overflow:hidden here — lets action dropdowns escape the card boundary */
    }
    .prec-toolbar {
        padding: 12px 20px;
        border-bottom: 1px solid rgba(199,196,215,0.3);
        display: flex; flex-wrap: wrap;
        justify-content: space-between; align-items: center; gap: 16px;
        background: var(--color-surface-container);
    }
    .prec-search-wrap { position: relative; max-width: 360px; flex: 1; }
    .prec-search-wrap .search-icon {
        position: absolute; left: 12px; top: 50%; transform: translateY(-50%);
        color: var(--color-on-surface-variant); font-size: 20px; pointer-events: none;
    }
    .prec-search-wrap input {
        width: 100%; padding: 8px 16px 8px 40px;
        background: var(--color-surface-container-lowest);
        border: 1px solid rgba(199,196,215,0.5); border-radius: 8px;
        font-family: 'Inter', sans-serif; font-size: 13px; color: var(--color-on-surface);
        transition: all 0.2s; outline: none;
    }
    .prec-search-wrap input::placeholder { color: rgba(70,69,84,0.7); }
    .prec-search-wrap input:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(70,72,212,0.15);
    }
    .prec-btn-outline {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 8px 16px;
        border: 1px solid rgba(199,196,215,0.5); border-radius: 8px;
        background: var(--color-surface-container-lowest);
        color: var(--color-on-surface) !important;
        font-family: 'Geist', sans-serif; font-size: 12px; font-weight: 500;
        cursor: pointer; transition: background 0.15s, color 0.15s; text-decoration: none !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04);
    }
    .prec-btn-outline:hover {
        background: var(--color-surface-container-high);
        color: var(--color-on-surface) !important; /* keep text dark, never turn black from global a:hover */
        text-decoration: none !important;
    }
    .prec-btn-primary {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 8px 16px; border: none; border-radius: 8px;
        background: var(--color-primary); color: #ffffff !important;
        font-family: 'Geist', sans-serif; font-size: 12px; font-weight: 500;
        cursor: pointer; transition: opacity 0.15s; text-decoration: none !important;
        box-shadow: 0 1px 2px rgba(0,0,0,0.06);
    }
    .prec-btn-primary:hover {
        opacity: 0.9;
        color: #ffffff !important; /* prevent Bootstrap overriding to dark */
        text-decoration: none !important;
    }

    /* Global anchor override — stop Bootstrap/theme from turning links to primary indigo */
    .prec-table td a:not(.prec-btn-primary):not(.prec-btn-outline):not(.dropdown-item-action) {
        color: inherit !important;
        text-decoration: none;
    }
    .prec-table td a:not(.prec-btn-primary):not(.prec-btn-outline):not(.dropdown-item-action):hover {
        color: inherit !important;
        text-decoration: underline;
    }

    /* Make table wrap visible so dropdowns aren't clipped, remove scrollbars */
    .prec-table-wrap { overflow: visible; background: var(--color-surface-container-lowest); border-radius: 12px; }

    /* Ensure dropdown menus always render on top */
    .prec-table .dropdown-menu {
        z-index: 1055 !important;
        position: absolute !important;
    }
    .prec-table .dropdown { position: relative; }
    .prec-table { width: 100%; border-collapse: collapse; white-space: normal; }
    .prec-table thead tr {
        background: var(--color-surface-container-lowest);
        border-bottom: 1px solid rgba(199,196,215,0.3);
    }
    .prec-table thead th {
        padding: 16px 24px;
        font-family: 'Geist', sans-serif; font-size: 12px; font-weight: 500;
        letter-spacing: 0.08em; text-transform: uppercase;
        color: var(--color-on-surface-variant);
    }
    .prec-table tbody tr { border-bottom: 1px solid rgba(199,196,215,0.3); transition: background 0.15s; }
    .prec-table tbody tr:hover { background: rgba(229,238,255,0.5) !important; }
    .prec-table tbody tr:last-child { border-bottom: none; }
    .prec-table td { padding: 16px 24px; vertical-align: middle; }

    .store-avatar {
        width: 40px; height: 40px; border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Geist', sans-serif; font-size: 14px; font-weight: 600;
        letter-spacing: 0.02em;
    }
    .owner-avatar {
        width: 32px; height: 32px; border-radius: 50%;
        background: var(--color-secondary); color: #ffffff;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Geist', sans-serif; font-size: 11px; font-weight: 600; flex-shrink: 0;
    }
    .badge-active {
        display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 6px;
        font-size: 11px; font-family: 'Geist', sans-serif; font-weight: 500;
        background: var(--color-secondary-container); color: var(--color-on-secondary-container);
    }
    .badge-disabled {
        display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 6px;
        font-size: 11px; font-family: 'Geist', sans-serif; font-weight: 500;
        background: rgba(186,26,26,0.10); color: var(--color-error);
    }
    .badge-inactive {
        display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 6px;
        font-size: 11px; font-family: 'Geist', sans-serif; font-weight: 500;
        background: var(--color-surface-container-highest); color: var(--color-on-surface-variant);
    }
    .badge-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--color-error); display: inline-block; }

    .btn-action-more {
        background: transparent !important; border: none !important;
        color: var(--color-on-surface-variant) !important;
        padding: 6px !important; border-radius: 6px !important;
        transition: all 0.15s !important; box-shadow: none !important; line-height: 1 !important;
    }
    .btn-action-more::after { display: none !important; }
    .btn-action-more:hover, .btn-action-more:focus {
        background: var(--color-surface-container-high) !important;
        color: var(--color-on-surface) !important;
    }
    .dropdown-item-action {
        display: flex; align-items: center; gap: 12px; padding: 8px 16px;
        font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 500;
        color: var(--color-on-surface-variant) !important;
        transition: all 0.15s; text-decoration: none !important;
    }
    .dropdown-item-action:hover {
        background-color: var(--color-surface-container-low);
        color: var(--color-on-surface) !important;
        text-decoration: none !important;
    }
    .dropdown-item-action.text-danger { color: var(--color-error) !important; }
    .dropdown-item-action.text-danger:hover { background-color: var(--color-error-container) !important; color: var(--color-error) !important; }
    .dropdown-item-action.text-success { color: #078841 !important; }
    .dropdown-item-action.text-success:hover { background-color: rgba(7,136,65,0.08) !important; color: #078841 !important; }

    .plan-bar-bg { width: 100%; height: 6px; background: var(--color-surface-container-highest); border-radius: 999px; overflow: hidden; }
    .plan-bar-fill { height: 100%; border-radius: 999px; transition: width 0.5s ease; }

    .prec-pagination {
        padding: 16px 24px; border-top: 1px solid rgba(199,196,215,0.3);
        background: var(--color-surface-container-lowest);
        display: flex; align-items: center; justify-content: space-between;
    }
    .prec-pagination p { font-family: 'Geist', sans-serif; font-size: 12px; color: var(--color-on-surface-variant); margin: 0; }
    .prec-pag-btn {
        width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
        border-radius: 6px; border: none; background: transparent;
        color: var(--color-on-surface-variant); cursor: pointer; transition: background 0.15s;
    }
    .prec-pag-btn:hover:not([disabled]) { background: var(--color-surface-container); }
    .prec-pag-btn[disabled] { opacity: 0.4; cursor: not-allowed; }
</style>
@endpush
@php
    $profile = \App\Models\Utility::get_file('uploads/profile');
@endphp
@section('content')
<x-ui.page-container>

    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:32px;flex-wrap:wrap;gap:16px;">
        <div>
            <h1 style="font-family:'Geist',sans-serif;font-size:1.5rem;line-height:40px;letter-spacing:-0.04em;font-weight:600;color:#0b1c30;margin:0;">
                {{ __('Stores Management') }}
            </h1>
            <p style="font-family:'Inter',sans-serif;font-size:14px;line-height:20px;color:#464554;margin:8px 0 0 0;">
                {{ __('Overview and control of all active merchant storefronts on the platform.') }}
            </p>
        </div>
        <div>
            <a href="#" class="prec-btn-primary" data-size="lg" data-url="{{ route('store-resource.create') }}" data-ajax-popup="true" data-title="{{ __('Create New Store') }}">
                <span class="material-symbols-outlined" style="font-size:18px;">add</span>
                {{ __('Add Store') }}
            </a>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:24px;margin-bottom:32px;">

        {{-- Card 1: Total Active Stores — indigo icon like dashboard --}}
        <div class="prec-stat-card" style="background:#e5eeff;">
            <div class="bg-circle" style="background:rgba(70,72,212,0.05);"></div>
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px;position:relative;z-index:1;">
                <div style="width:48px;height:48px;border-radius:12px;background:#6063ee;color:#fffbff;display:flex;align-items:center;justify-content:center;">
                    <span class="material-symbols-outlined">storefront</span>
                </div>
                <span style="display:flex;align-items:center;gap:4px;color:#078841;background:rgba(7,136,65,0.10);padding:4px 8px;border-radius:16px;font-family:'Geist',sans-serif;font-size:12px;font-weight:600;">
                    <span class="material-symbols-outlined" style="font-size:14px;">trending_up</span>+2 this month
                </span>
            </div>
            <div style="position:relative;z-index:1;">
                <p style="font-family:'Inter',sans-serif;font-size:13px;color:#464554;margin:0 0 4px 0;">{{ __('Total Active Stores') }}</p>
                <p style="font-family:'Geist',sans-serif;font-size:24px;line-height:32px;font-weight:600;color:#0b1c30;margin:0;">{{ isset($allUsers) ? $allUsers->count() : $users->total() }}</p>
            </div>
        </div>

        {{-- Card 2: Enabled Stores — green icon like dashboard --}}
        <div class="prec-stat-card" style="background:#e5eeff;">
            <div class="bg-circle" style="background:rgba(16,185,129,0.05);"></div>
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px;position:relative;z-index:1;">
                <div style="width:48px;height:48px;border-radius:12px;background:#10b981;color:#fffbff;display:flex;align-items:center;justify-content:center;">
                    <span class="material-symbols-outlined">check_circle</span>
                </div>
                <span style="display:flex;align-items:center;gap:4px;color:#078841;background:rgba(7,136,65,0.10);padding:4px 8px;border-radius:16px;font-family:'Geist',sans-serif;font-size:12px;font-weight:600;">
                    <span class="material-symbols-outlined" style="font-size:14px;">trending_up</span>+5% vs last period
                </span>
            </div>
            <div style="position:relative;z-index:1;">
                <p style="font-family:'Inter',sans-serif;font-size:13px;color:#464554;margin:0 0 4px 0;">{{ __('Enabled Stores') }}</p>
                <p style="font-family:'Geist',sans-serif;font-size:24px;line-height:32px;font-weight:600;color:#0b1c30;margin:0;">{{ isset($allUsers) ? $allUsers->where('store_display', 1)->count() : collect($users->items())->where('store_display', 1)->count() }}</p>
            </div>
        </div>

        {{-- Card 3: Needs Attention — amber icon like dashboard --}}
        <div class="prec-stat-card" style="background:#e5eeff;">
            <div class="bg-circle" style="background:rgba(245,158,11,0.05);"></div>
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:24px;position:relative;z-index:1;">
                <div style="width:48px;height:48px;border-radius:12px;background:#f59e0b;color:#fffbff;display:flex;align-items:center;justify-content:center;">
                    <span class="material-symbols-outlined">warning</span>
                </div>
                <span style="display:flex;align-items:center;gap:4px;color:#ba1a1a;background:rgba(186,26,26,0.10);padding:4px 8px;border-radius:16px;font-family:'Geist',sans-serif;font-size:12px;font-weight:600;">
                    <span class="material-symbols-outlined" style="font-size:14px;">info</span>Login disabled
                </span>
            </div>
            <div style="position:relative;z-index:1;">
                <p style="font-family:'Inter',sans-serif;font-size:13px;color:#464554;margin:0 0 4px 0;">{{ __('Needs Attention') }}</p>
                <p style="font-family:'Geist',sans-serif;font-size:24px;line-height:32px;font-weight:600;color:#0b1c30;margin:0;">{{ isset($allUsers) ? $allUsers->where('is_enable_login', 0)->count() : collect($users->items())->where('is_enable_login', 0)->count() }}</p>
            </div>
        </div>

    </div>


    {{-- Table Card --}}
    <div class="prec-table-card">
        <div class="prec-toolbar" style="padding:16px 24px; display:flex; justify-content:space-between; align-items:center; border-bottom:1px solid rgba(199,196,215,0.3); background:var(--color-surface-container-lowest); border-radius:12px 12px 0 0;">
            <div style="display:flex; gap:16px; align-items:center;">
                <div style="position:relative;">
                    <select class="dataTable-selector" style="appearance:none; padding:8px 32px 8px 12px; border:1px solid rgba(199,196,215,0.5); border-radius:8px; background:var(--color-surface-container-lowest); font-family:'Inter',sans-serif; font-size:13px; font-weight:500; color:var(--color-on-surface); outline:none; cursor:pointer;">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="25" selected>25</option>
                    </select>
                    <span class="material-symbols-outlined" style="position:absolute; right:8px; top:50%; transform:translateY(-50%); font-size:18px; color:var(--color-on-surface-variant); pointer-events:none;">expand_more</span>
                </div>
                
                <div style="display:flex; border:1px solid rgba(199,196,215,0.5); border-radius:8px; overflow:hidden; background:var(--color-surface-container-lowest);">
                    <button style="display:flex; align-items:center; gap:8px; padding:8px 16px; background:transparent; border:none; border-right:1px solid rgba(199,196,215,0.5); color:var(--color-on-surface-variant); font-family:'Inter',sans-serif; font-size:13px; font-weight:500; cursor:pointer;">
                        <span class="material-symbols-outlined" style="font-size:16px;">upload</span>
                        {{ __('Import') }}
                    </button>
                    <button style="display:flex; align-items:center; gap:8px; padding:8px 16px; background:transparent; border:none; color:var(--color-on-surface-variant); font-family:'Inter',sans-serif; font-size:13px; font-weight:500; cursor:pointer;">
                        <span class="material-symbols-outlined" style="font-size:16px;">download</span>
                        {{ __('Export') }}
                    </button>
                </div>
            </div>
            
            <div style="display:flex; gap:12px; align-items:center;">
                <div style="position:relative; width:260px;">
                    <span class="material-symbols-outlined" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); font-size:18px; color:var(--color-on-surface-variant);">search</span>
                    <input type="text" id="storeSearchInput" placeholder="{{ __('Search...') }}" onkeyup="filterStoreRows(this.value)" style="width:100%; padding:8px 12px 8px 36px; border:1px solid rgba(199,196,215,0.5); border-radius:8px; font-family:'Inter',sans-serif; font-size:13px; color:var(--color-on-surface); outline:none;">
                </div>
                <button class="prec-btn-outline" style="padding:8px 16px; display:flex; align-items:center; gap:8px;">
                    <span class="material-symbols-outlined" style="font-size:18px;">filter_alt</span>
                    {{ __('Filters') }}
                </button>
            </div>
        </div>

        <div class="prec-table-wrap">
            <table class="prec-table" id="storesTable">
                <thead>
                    <tr>
                        <th style="width:40px;text-align:center;">
                            <input type="checkbox" id="selectAllStores" style="width:16px;height:16px;cursor:pointer;accent-color:var(--color-primary);" onclick="toggleAllStores(this)">
                        </th>
                        <th style="width:25%;text-align:left;">{{ __('Store Info') }}</th>
                        <th style="width:20%;text-align:left;">{{ __('Plan & Usage') }}</th>
                        <th style="width:20%;text-align:left;">{{ __('Owner') }}</th>
                        <th style="width:15%;text-align:left;">{{ __('Revenue (MTD)') }}</th>
                        <th style="width:10%;text-align:left;">{{ __('Status') }}</th>
                        <th style="width:10%;text-align:right;">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $usr)
                    @php
                        $initials       = strtoupper(substr($usr->name, 0, 2));
                        $planName       = !empty($usr->currentPlan->name) ? $usr->currentPlan->name : 'Free';
                        $storeId        = 'STR-' . strtoupper(substr(md5($usr->id), 0, 4));
                        $delay          = $index * 50;
                        $isActive       = $usr->store_display == 1;
                        $loginEnabled   = $usr->is_enable_login == 1;
                        
                        $avatarColors = [
                            ['bg' => '#eef2ff', 'text' => '#4f46e5'], // Indigo
                            ['bg' => '#f0fdf4', 'text' => '#16a34a'], // Green
                            ['bg' => '#fffbeb', 'text' => '#d97706'], // Amber
                            ['bg' => '#fdf2f8', 'text' => '#db2777'], // Pink
                            ['bg' => '#eff6ff', 'text' => '#2563eb'], // Blue
                            ['bg' => '#f5f3ff', 'text' => '#7c3aed'], // Purple
                            ['bg' => '#ecfdf5', 'text' => '#059669'], // Emerald
                            ['bg' => '#fff1f2', 'text' => '#e11d48'], // Rose
                        ];
                        $colorIndex = abs(crc32($usr->store_name ?? $usr->name)) % count($avatarColors);
                        $theme = $avatarColors[$colorIndex];
                    @endphp
                    <tr class="store-row"
                        style="{{ (!$loginEnabled || $usr->is_active == 0 || !$isActive) ? 'background:rgba(186,26,26,0.025);' : '' }}"
                        data-name="{{ strtolower($usr->name) }}" data-email="{{ strtolower($usr->email) }}">
                        
                        <td style="text-align:center;">
                            <input type="checkbox" class="store-checkbox" value="{{ $usr->id }}" style="width:16px;height:16px;cursor:pointer;accent-color:var(--color-primary);" onclick="updateSelectAllStatus()">
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <div class="store-avatar" style="background:{{ $theme['bg'] }};color:{{ $theme['text'] }};">{{ strtoupper(substr($usr->store_name ?? $usr->name, 0, 2)) }}</div>
                                <div style="display:flex;flex-direction:column;">
                                    <span style="font-family:'Inter',sans-serif;font-size:13px;font-weight:600;color:#0b1c30;cursor:pointer;line-height:18px;"
                                       onmouseover="this.style.color='#4648d4'" onmouseout="this.style.color='#0b1c30'">{{ $usr->store_name ?? $usr->name }}</span>
                                    <span style="font-family:'Geist',sans-serif;font-size:12px;font-weight:500;color:#464554;letter-spacing:0.02em;line-height:16px;">ID: {{ $storeId }}</span>
                                </div>
                            </div>
                        </td>

                        <td style="vertical-align:middle;">
                            <div style="display:flex;flex-direction:column;gap:6px;width:100%;max-width:160px;">
                                <div style="display:flex;justify-content:space-between;align-items:center;">
                                    <span style="font-family:'Inter',sans-serif;font-size:13px;font-weight:500;color:#0b1c30;line-height:18px;">{{ $planName }}</span>
                                    <span style="font-family:'JetBrains Mono',monospace;font-size:13px;color:#464554;line-height:20px;">50%</span>
                                </div>
                                <div style="height:6px;width:100%;background:var(--color-surface-container-highest);border-radius:9999px;overflow:hidden;">
                                    <div style="height:100%;width:50%;background:var(--color-primary);border-radius:9999px;transition:width 0.5s;"></div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div style="display:flex;align-items:center;gap:12px;">
                                <img src="{{ !empty($usr->avatar) ? ($profile . '/' . $usr->avatar) : ($profile . '/avatar.png') }}" class="owner-avatar" style="object-fit:cover;border-radius:50%;width:32px;height:32px;flex-shrink:0;" onerror="this.src='{{ $profile . '/avatar.png' }}'">
                                <span style="font-family:'Inter',sans-serif;font-size:13px;font-weight:500;color:#0b1c30;line-height:18px;">{{ $usr->name }}</span>
                            </div>
                        </td>

                        <td>
                            <span style="font-family:'JetBrains Mono',monospace;font-size:13px;font-weight:500;color:#0b1c30;">{{ \App\Models\Utility::priceFormat($usr->store_revenue ?? 0) }}</span>
                        </td>

                        <td>
                            @if(!$loginEnabled || $usr->is_active == 0)
                                <span class="badge-disabled"><span class="badge-dot"></span>{{ __('Disabled') }}</span>
                            @elseif($isActive)
                                <span class="badge-active">{{ __('Active') }}</span>
                            @else
                                <span class="badge-inactive">{{ __('Inactive') }}</span>
                            @endif
                        </td>

                        <td style="text-align:right;">
                            <div class="dropdown">
                                <button class="btn btn-action-more dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined" style="font-size:20px;display:flex;">more_vert</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg"
                                    style="border-radius:12px;border:1px solid rgba(199,196,215,0.2);padding:8px 0;min-width:200px;">
                                    @if(Auth::user()->type == "super admin")
                                        <li>
                                            <a href="#" class="dropdown-item dropdown-item-action"
                                               data-url="{{ route('owner.info', $usr->id) }}" data-size="lg"
                                               data-ajax-popup="true" data-title="{{ __('Owner Info') }}">
                                                <span class="material-symbols-outlined" style="font-size:18px;">info</span>{{ __('Owner Info') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('login.with.owner', $usr->id) }}" class="dropdown-item dropdown-item-action">
                                                <span class="material-symbols-outlined" style="font-size:18px;">login</span>{{ __('Login as owner') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="dropdown-item dropdown-item-action" data-size="lg"
                                               data-url="{{ route('store.links', $usr->id) }}" data-ajax-popup="true"
                                               data-title="{{ __('Store Links') }}">
                                                <span class="material-symbols-outlined" style="font-size:18px;">link</span>{{ __('Store Links') }}
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                    @endif

                                    @if ($usr->is_enable_login == 1)
                                        <li>
                                            <a href="{{ route('users.login', \Crypt::encrypt($usr->id)) }}" class="dropdown-item dropdown-item-action text-danger">
                                                <span class="material-symbols-outlined" style="font-size:18px;">block</span>{{ __('Login Disable') }}
                                            </a>
                                        </li>
                                    @elseif ($usr->is_enable_login == 0 && $usr->password == null)
                                        <li>
                                            <a href="#" class="dropdown-item dropdown-item-action text-success login_enable"
                                               data-url="{{ route('user.reset', \Crypt::encrypt($usr->id)) }}"
                                               data-ajax-popup="true" data-title="{{ __('New Password') }}">
                                                <span class="material-symbols-outlined" style="font-size:18px;">check_circle</span>{{ __('Login Enable') }}
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ route('users.login', \Crypt::encrypt($usr->id)) }}" class="dropdown-item dropdown-item-action text-success login_enable">
                                                <span class="material-symbols-outlined" style="font-size:18px;">check_circle</span>{{ __('Login Enable') }}
                                            </a>
                                        </li>
                                    @endif

                                    <li><hr class="dropdown-divider"></li>

                                    @can('Upgrade Plans')
                                        <li>
                                            <a href="#" class="dropdown-item dropdown-item-action"
                                               data-url="{{ route('plan.upgrade', $usr->id) }}"
                                               data-ajax-popup="true" data-title="{{ __('Upgrade Plan') }}">
                                                <span class="material-symbols-outlined" style="font-size:18px;">upgrade</span>{{ __('Upgrade Plan') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('Reset Password')
                                        <li>
                                            <a href="#" class="dropdown-item dropdown-item-action"
                                               data-url="{{ route('user.reset', \Crypt::encrypt($usr->id)) }}"
                                               data-ajax-popup="true" data-title="{{ __('Reset Password') }}">
                                                <span class="material-symbols-outlined" style="font-size:18px;">key</span>{{ __('Reset Password') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @can('Edit Store')
                                        <li>
                                            <a href="#" class="dropdown-item dropdown-item-action"
                                               data-url="{{ route('store-resource.edit', $usr->id) }}"
                                               data-ajax-popup="true" data-title="{{ __('Edit Store') }}">
                                                <span class="material-symbols-outlined" style="font-size:18px;">edit</span>{{ __('Edit') }}
                                            </a>
                                        </li>
                                    @endcan

                                    @if($usr->id != 2)
                                        @can('Delete Store')
                                            <li>
                                                <a href="#" class="dropdown-item dropdown-item-action text-danger bs-pass-para"
                                                   data-confirm="{{ __('Are You Sure?') }}"
                                                   data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                   data-confirm-yes="delete-form-{{ $usr->id }}">
                                                    <span class="material-symbols-outlined" style="font-size:18px;">delete</span>{{ __('Delete') }}
                                                </a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['store-resource.destroy', $usr->id], 'id' => 'delete-form-' . $usr->id, 'class' => 'hidden']) !!}
                                                {!! Form::close() !!}
                                            </li>
                                        @endcan
                                    @endif
                                </ul>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="prec-pagination">
            @if(method_exists($users, 'total'))
                <p>Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} entries</p>
                <div style="display:flex;align-items:center;gap:4px;">
                    <a href="{{ $users->previousPageUrl() }}" class="prec-pag-btn" style="text-decoration:none;" {{ $users->onFirstPage() ? 'disabled' : '' }}>
                        <span class="material-symbols-outlined" style="font-size:20px;">chevron_left</span>
                    </a>
                    <button class="prec-pag-btn" style="background:#4648d4;color:#ffffff;font-family:'Geist',sans-serif;font-size:13px;font-weight:500;">
                        {{ $users->currentPage() }}
                    </button>
                    <a href="{{ $users->nextPageUrl() }}" class="prec-pag-btn" style="text-decoration:none;" {{ !$users->hasMorePages() ? 'disabled' : '' }}>
                        <span class="material-symbols-outlined" style="font-size:20px;">chevron_right</span>
                    </a>
                </div>
            @else
                <p>Showing 1 to {{ $users->count() }} of {{ $users->count() }} entries</p>
                <div style="display:flex;align-items:center;gap:4px;">
                    <button class="prec-pag-btn" disabled><span class="material-symbols-outlined" style="font-size:20px;">chevron_left</span></button>
                    <button class="prec-pag-btn" style="background:#4648d4;color:#ffffff;font-family:'Geist',sans-serif;font-size:13px;font-weight:500;">1</button>
                    <button class="prec-pag-btn" disabled><span class="material-symbols-outlined" style="font-size:20px;">chevron_right</span></button>
                </div>
            @endif
        </div>

    </div>

</x-ui.page-container>
@endsection

@push('scripts')
<script>
    function toggleAllStores(source) {
        let checkboxes = document.querySelectorAll('.store-checkbox');
        for(let i=0; i<checkboxes.length; i++) {
            checkboxes[i].checked = source.checked;
        }
    }

    function updateSelectAllStatus() {
        let checkboxes = document.querySelectorAll('.store-checkbox');
        let selectAll = document.getElementById('selectAllStores');
        let allChecked = true;
        let anyUnchecked = false;
        
        for(let i=0; i<checkboxes.length; i++) {
            if(!checkboxes[i].checked) {
                allChecked = false;
                anyUnchecked = true;
                break;
            }
        }
        selectAll.checked = allChecked;
    }

    function filterStoreRows(query) {
        const q = query.toLowerCase().trim();
        document.querySelectorAll('#storesTable tbody tr.store-row').forEach(function(row) {
            const name  = row.dataset.name  || '';
            const email = row.dataset.email || '';
            row.style.display = (!q || name.includes(q) || email.includes(q)) ? '' : 'none';
        });
    }

    function exportTableToCSV(filename) {
        var rows = document.querySelectorAll('#storesTable thead tr, #storesTable tbody tr.store-row:not([style*="display: none"])');
        var csvLines = [];
        rows.forEach(function(row) {
            var cols = row.querySelectorAll('th, td');
            var line = [];
            cols.forEach(function(col, i) {
                if (i === cols.length - 1) return; // skip Actions column
                var text = col.innerText.replace(/\n/g,' ').replace(/,/g,' ').trim();
                line.push('"' + text + '"');
            });
            csvLines.push(line.join(','));
        });
        var blob = new Blob([csvLines.join('\n')], { type: 'text/csv;charset=utf-8;' });
        var link = document.createElement('a');
        link.href = URL.createObjectURL(blob);
        link.setAttribute('download', filename);
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    $(document).on('change', '#password_switch', function () {
        if ($(this).is(':checked')) {
            $('.ps_div').removeClass('d-none');
            $('#password').attr('required', true);
        } else {
            $('.ps_div').addClass('d-none');
            $('#password').val(null);
            $('#password').removeAttr('required');
        }
    });

    $(document).on('click', '.login_enable', function () {
        setTimeout(function () {
            $('.login_field').append($('<input>', { type: 'hidden', val: 'true', name: 'login_enable' }));
        }, 2000);
    });
</script>
@endpush
