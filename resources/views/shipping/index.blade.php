@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Shipping') }}
@endsection

@section('content')
<x-ui.page-container>

    {{-- Custom Styles for Segmented Tabs, DataTables, and Table Layout --}}
    <style>
        /* Segmented Tabs Control Styling */
        .segmented-tabs-container {
            background: #ffffff;
            border: 1px solid rgba(199,196,215,0.3);
            border-radius: 12px;
            padding: 4px;
            display: inline-flex;
            height: 48px;
            box-shadow: 0 1px 8px rgba(0,0,0,0.02);
            margin-bottom: 24px;
            width: 100%;
            max-width: 320px;
        }

        .segmented-tabs-container .nav-pills {
            border: none !important;
            padding: 0;
            margin: 0;
            list-style: none;
            display: flex;
            width: 100%;
        }

        .segmented-tabs-container .nav-item {
            flex: 1;
            display: flex;
        }

        .segmented-tabs-container .nav-link {
            background: transparent !important;
            color: #464554 !important;
            font-family: 'Geist', sans-serif !important;
            font-size: 13px !important;
            font-weight: 500 !important;
            border-radius: 8px !important;
            border: none !important;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            padding: 0 16px !important;
            height: 38px !important;
            width: 100%;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
        }

        .segmented-tabs-container .nav-link.active {
            background: #4648d4 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(70, 72, 212, 0.15) !important;
        }

        .segmented-tabs-container .nav-link:hover:not(.active) {
            background: #f8f9ff !important;
            color: #4648d4 !important;
        }

        /* Simple-DataTables Controls Styling */
        .dataTable-wrapper {
            width: 100%;
        }

        .dataTable-top {
            padding: 16px 24px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            flex-wrap: wrap !important;
            gap: 12px !important;
            background: #ffffff !important;
            border-bottom: 1px solid rgba(199,196,215,0.15) !important;
        }

        .dataTable-dropdown {
            display: inline-flex !important;
            align-items: center !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 12px !important;
            color: #767586 !important;
        }

        .dataTable-selector {
            padding: 6px 28px 6px 12px !important;
            border: 1px solid rgba(199,196,215,0.4) !important;
            border-radius: 8px !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 13px !important;
            color: #464554 !important;
            background: #ffffff url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e") no-repeat right 12px center/10px 10px !important;
            appearance: none !important;
            outline: none !important;
            cursor: pointer !important;
            margin: 0 8px !important;
            transition: border-color 0.2s !important;
        }

        .dataTable-selector:focus {
            border-color: #4648d4 !important;
        }

        .dataTable-search {
            position: relative !important;
        }

        .dataTable-input {
            padding: 8px 12px 8px 36px !important;
            border: 1px solid rgba(199,196,215,0.4) !important;
            border-radius: 8px !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 13px !important;
            color: #0b1c30 !important;
            outline: none !important;
            width: 220px !important;
            transition: border-color 0.2s !important;
            background: #ffffff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' stroke='%23a0a0b0' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/%3E%3C/svg%3E") no-repeat left 12px center/15px 15px !important;
        }

        .dataTable-input:focus {
            border-color: #4648d4 !important;
        }

        .dataTable-input::placeholder {
            color: #a0a0b0 !important;
        }

        /* Custom Table Header & Borders */
        .dataTable-table {
            border-collapse: collapse !important;
            width: 100% !important;
        }

        .dataTable-table th {
            padding: 12px 24px !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 11px !important;
            font-weight: 600 !important;
            color: #767586 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.07em !important;
            background: #fafafa !important;
            border-bottom: 1px solid rgba(199,196,215,0.2) !important;
        }

        .dataTable-table td {
            padding: 16px 24px !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 13px !important;
            color: #0b1c30 !important;
            border-bottom: 1px solid rgba(199,196,215,0.12) !important;
            vertical-align: middle !important;
        }

        .dataTable-table tbody tr {
            transition: background 0.15s !important;
        }

        .dataTable-table tbody tr:hover {
            background: #fafbff !important;
        }

        /* Pagination Override */
        .dataTable-bottom {
            padding: 16px 24px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            border-top: 1px solid rgba(199,196,215,0.15) !important;
            background: #ffffff !important;
        }

        .dataTable-info {
            font-family: 'Inter', sans-serif !important;
            font-size: 12px !important;
            color: #767586 !important;
        }

        .dataTable-pagination {
            display: inline-flex !important;
        }

        .dataTable-pagination-list {
            display: inline-flex !important;
            padding: 0 !important;
            margin: 0 !important;
            list-style: none !important;
            gap: 4px !important;
        }

        .dataTable-pagination-list li {
            display: inline-flex !important;
        }

        .dataTable-pagination-list a {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 32px !important;
            height: 32px !important;
            border-radius: 8px !important;
            font-family: 'Inter', sans-serif !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            color: #464554 !important;
            text-decoration: none !important;
            transition: all 0.2s !important;
        }

        .dataTable-pagination-list li.active a,
        .dataTable-pagination-list a:hover {
            background: #eff0fe !important;
            color: #4648d4 !important;
        }

        .dataTable-pagination-list li.disabled a {
            color: #b0afc0 !important;
            pointer-events: none !important;
        }
    </style>

    {{-- ===================== PAGE HEADER ===================== --}}
    <div style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 28px;">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div>
                <h1 style="font-family: 'Geist', sans-serif; font-size: 1.5rem; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">
                    {{ __('Shipping') }}
                </h1>
                <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586; margin: 4px 0 0;">
                    {{ __('Manage shipping locations and delivery settings.') }}
                </p>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <a href="{{ route('shipping.export') }}" style="text-decoration: none;">
                    <button type="button"
                            style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; background: #e5eeff; color: #4648d4; border: none; border-radius: 10px; font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 500; cursor: pointer; letter-spacing: 0.01em; transition: background 0.2s;"
                            onmouseover="this.style.background='#dce9ff'" onmouseout="this.style.background='#e5eeff'">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        {{ __('Export') }}
                    </button>
                </a>
                @can('Create Shipping')
                    <a href="#!" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Import') }}" data-ajax-popup="true" data-size="lg" data-title="{{ __('Import Shipping CSV File') }}" data-url="{{ route('shipping.file.import') }}" style="text-decoration: none;">
                        <button type="button"
                                style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; background: #e5eeff; color: #4648d4; border: none; border-radius: 10px; font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 500; cursor: pointer; letter-spacing: 0.01em; transition: background 0.2s;"
                                onmouseover="this.style.background='#dce9ff'" onmouseout="this.style.background='#e5eeff'">
                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            {{ __('Import') }}
                        </button>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Tabs Navigation --}}
        <div class="col-12" style="margin-bottom: 4px;">
            <div class="segmented-tabs-container">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-user-tab-1" data-bs-toggle="pill"
                            data-bs-target="#pills-user-1" type="button">
                            <span class="material-symbols-outlined" style="font-size: 18px; vertical-align: middle;">pin_drop</span>
                            {{ __('Locations') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-user-tab-2" data-bs-toggle="pill"
                            data-bs-target="#pills-user-2" type="button">
                            <span class="material-symbols-outlined" style="font-size: 18px; vertical-align: middle;">local_shipping</span>
                            {{ __('Shipping') }}
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        
        {{-- Main Container Card --}}
        <div class="col-12">
            <div class="card" style="border: 1px solid rgba(199,196,215,0.2); border-radius: 14px; box-shadow: 0 1px 8px rgba(0,0,0,0.04); overflow: hidden; background: #ffffff;">
                <div class="tab-content" id="pills-tabContent">
                    
                    {{-- ===================== LOCATIONS TAB ===================== --}}
                    <div class="tab-pane fade show active" id="pills-user-1" role="tabpanel" aria-labelledby="pills-user-tab-1">
                        
                        {{-- Header Area --}}
                        <div style="padding: 20px 24px; border-bottom: 1px solid rgba(199,196,215,0.15); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                            <div>
                                <h2 style="font-family: 'Geist', sans-serif; font-size: 15px; font-weight: 600; color: #0b1c30; margin: 0; letter-spacing: -0.01em;">
                                    {{ __('Locations') }}
                                </h2>
                                <p style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586; margin: 2px 0 0;">
                                    {{ __('Manage the locations available for shipping.') }}
                                </p>
                            </div>
                            @can('Create Location')
                                <a href="#" data-url="{{ route('location.create') }}" data-title="{{ __('Create New Location') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create New Location') }}" style="text-decoration: none;">
                                    <button type="button"
                                            style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; background: #4648d4; color: #ffffff; border: none; border-radius: 10px; font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 500; cursor: pointer; transition: background 0.2s;"
                                            onmouseover="this.style.background='#2f2ebe'" onmouseout="this.style.background='#4648d4'">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        {{ __('Create New Location') }}
                                    </button>
                                </a>
                            @endcan
                        </div>

                        {{-- Locations Table / Empty State --}}
                        @if($locations->isEmpty())
                            <div style="text-align: center; padding: 48px 24px; background: #ffffff;">
                                <div style="width: 56px; height: 56px; background: #eff0fe; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                    <span class="material-symbols-outlined" style="font-size: 28px; color: #4648d4;">pin_drop</span>
                                </div>
                                <h3 style="font-family: 'Geist', sans-serif; font-size: 15px; font-weight: 600; color: #0b1c30; margin: 0 0 4px;">
                                    {{ __('No shipping locations yet') }}
                                </h3>
                                <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586; margin: 0 0 20px; max-width: 360px; margin-left: auto; margin-right: auto;">
                                    {{ __('Create your first location to start managing shipping destinations.') }}
                                </p>
                                @can('Create Location')
                                    <a href="#" data-url="{{ route('location.create') }}" data-title="{{ __('Create New Location') }}" data-ajax-popup="true" style="text-decoration: none;">
                                        <button type="button"
                                                style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; background: #4648d4; color: #ffffff; border: none; border-radius: 10px; font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 500; cursor: pointer; transition: background 0.2s;"
                                                onmouseover="this.style.background='#2f2ebe'" onmouseout="this.style.background='#4648d4'">
                                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            {{ __('Create New Location') }}
                                        </button>
                                    </a>
                                @endcan
                            </div>
                        @else
                            <div class="table-responsive" style="overflow-x: auto;">
                                <table class="table mb-0 dataTable">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Created At') }}</th>
                                            <th style="text-align: right !important;">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($locations as $location)
                                            <tr data-name="{{ $location->name }}">
                                                <td style="font-weight: 600; color: #0b1c30;">{{ $location->name }}</td>
                                                <td>{{ \App\Models\Utility::dateFormat($location->created_at) }}</td>
                                                <td style="text-align: right !important;">
                                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 6px;">
                                                        @can('Edit Location')
                                                            <a href="#!"
                                                               data-url="{{ route('location.edit', $location->id) }}"
                                                               data-ajax-popup="true"
                                                               data-title="{{ __('Edit Location') }}"
                                                               data-bs-toggle="tooltip"
                                                               data-bs-placement="top"
                                                               title="{{ __('Edit') }}"
                                                               style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; background: #eff0fe; color: #4648d4; text-decoration: none; transition: background 0.15s;"
                                                               onmouseover="this.style.background='#e2e3fd'" onmouseout="this.style.background='#eff0fe'">
                                                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                </svg>
                                                            </a>
                                                        @endcan
                                                        @can('Delete Location')
                                                            <a class="bs-pass-para"
                                                               href="#"
                                                               data-title="{{ __('Delete Lead') }}"
                                                               data-confirm="{{ __('Are You Sure?') }}"
                                                               data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                               data-confirm-yes="delete-form-{{ $location->id }}"
                                                               data-bs-toggle="tooltip"
                                                               data-bs-placement="top"
                                                               title="{{ __('Delete') }}"
                                                               style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; background: #ffdad6; color: #ba1a1a; text-decoration: none; transition: background 0.15s;"
                                                               onmouseover="this.style.background='#ffbdb8'" onmouseout="this.style.background='#ffdad6'">
                                                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                </svg>
                                                            </a>
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['location.destroy', $location->id], 'id' => 'delete-form-' . $location->id, 'style' => 'display:none;']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                    
                    {{-- ===================== SHIPPING TAB ===================== --}}
                    <div class="tab-pane fade" id="pills-user-2" role="tabpanel" aria-labelledby="pills-user-tab-2">
                        
                        {{-- Header Area --}}
                        <div style="padding: 20px 24px; border-bottom: 1px solid rgba(199,196,215,0.15); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px;">
                            <div>
                                <h2 style="font-family: 'Geist', sans-serif; font-size: 15px; font-weight: 600; color: #0b1c30; margin: 0; letter-spacing: -0.01em;">
                                    {{ __('Shipping') }}
                                </h2>
                                <p style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586; margin: 2px 0 0;">
                                    {{ __('Manage your shipping rates and methods.') }}
                                </p>
                            </div>
                            @can('Create Shipping')
                                <a href="#" data-url="{{ route('shipping.create') }}" data-title="{{ __('Create New Shipping') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create New Shipping') }}" style="text-decoration: none;">
                                    <button type="button"
                                            style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; background: #4648d4; color: #ffffff; border: none; border-radius: 10px; font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 500; cursor: pointer; transition: background 0.2s;"
                                            onmouseover="this.style.background='#2f2ebe'" onmouseout="this.style.background='#4648d4'">
                                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        {{ __('Create New Shipping') }}
                                    </button>
                                </a>
                            @endcan
                        </div>

                        {{-- Shipping Table / Empty State --}}
                        @if($shippings->isEmpty())
                            <div style="text-align: center; padding: 48px 24px; background: #ffffff;">
                                <div style="width: 56px; height: 56px; background: #eff0fe; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                    <span class="material-symbols-outlined" style="font-size: 28px; color: #4648d4;">local_shipping</span>
                                </div>
                                <h3 style="font-family: 'Geist', sans-serif; font-size: 15px; font-weight: 600; color: #0b1c30; margin: 0 0 4px;">
                                    {{ __('No shipping methods yet') }}
                                </h3>
                                <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586; margin: 0 0 20px; max-width: 360px; margin-left: auto; margin-right: auto;">
                                    {{ __('Create your first shipping method to start managing shipping destinations.') }}
                                </p>
                                @can('Create Shipping')
                                    <a href="#" data-url="{{ route('shipping.create') }}" data-title="{{ __('Create New Shipping') }}" data-ajax-popup="true" style="text-decoration: none;">
                                        <button type="button"
                                                style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; background: #4648d4; color: #ffffff; border: none; border-radius: 10px; font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 500; cursor: pointer; transition: background 0.2s;"
                                                onmouseover="this.style.background='#2f2ebe'" onmouseout="this.style.background='#4648d4'">
                                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                            {{ __('Create New Shipping') }}
                                        </button>
                                    </a>
                                @endcan
                            </div>
                        @else
                            <div class="table-responsive" style="overflow-x: auto;">
                                <table class="table mb-0 dataTable1">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Name') }}</th>
                                            <th>{{ __('Price') }}</th>
                                            <th>{{ __('Location') }}</th>
                                            <th>{{ __('Created At') }}</th>
                                            <th style="text-align: right !important;">{{ __('Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($shippings as $shipping)
                                            <tr data-name="{{ $shipping->name }}">
                                                <td style="font-weight: 600; color: #0b1c30;">{{ $shipping->name }}</td>
                                                <td style="font-weight: 600; color: #4648d4;">{{ \App\Models\Utility::priceFormat($shipping->price) }}</td>
                                                <td>{{ !empty($shipping->locationName()) ? $shipping->locationName() : '-' }}</td>
                                                <td>{{ \App\Models\Utility::dateFormat($shipping->created_at) }}</td>
                                                <td style="text-align: right !important;">
                                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 6px;">
                                                        @can('Edit Shipping')
                                                            <a href="#!"
                                                               data-url="{{ route('shipping.edit', $shipping->id) }}"
                                                               data-ajax-popup="true"
                                                               data-title="{{ __('Edit Shipping') }}"
                                                               data-bs-toggle="tooltip"
                                                               data-bs-placement="top"
                                                               title="{{ __('Edit') }}"
                                                               style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; background: #eff0fe; color: #4648d4; text-decoration: none; transition: background 0.15s;"
                                                               onmouseover="this.style.background='#e2e3fd'" onmouseout="this.style.background='#eff0fe'">
                                                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                                </svg>
                                                            </a>
                                                        @endcan
                                                        @can('Delete Shipping')
                                                            <a class="bs-pass-para"
                                                               href="#"
                                                               data-title="{{ __('Delete Lead') }}"
                                                               data-confirm="{{ __('Are You Sure?') }}"
                                                               data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                               data-confirm-yes="delete-form-{{ $shipping->id }}"
                                                               data-bs-toggle="tooltip"
                                                               data-bs-placement="top"
                                                               title="{{ __('Delete') }}"
                                                               style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; background: #ffdad6; color: #ba1a1a; text-decoration: none; transition: background 0.15s;"
                                                               onmouseover="this.style.background='#ffbdb8'" onmouseout="this.style.background='#ffdad6'">
                                                                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                </svg>
                                                            </a>
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['shipping.destroy', $shipping->id], 'id' => 'delete-form-' . $shipping->id, 'style' => 'display:none;']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-ui.page-container>
@endsection
