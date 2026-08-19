@extends('layouts.ui-admin')
@php
    $logo=\App\Models\Utility::get_file('uploads/logo');
    $product_item=\App\Models\Utility::get_file('uploads/is_cover_image/');
    $company_favicon=Utility::getValByName('company_favicon');
    $SITE_RTL = Utility::getValByName('SITE_RTL');
    $setting = \App\Models\Utility::colorset();
    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';

    if(isset($setting['color_flag']) && $setting['color_flag'] == 'true')
    {
        $themeColor = 'custom-color';
    }
    else {
        $themeColor = $color;
    }
    $storesetting = Utility::StorageSettings();
@endphp
@section('page-title', __('Pos'))
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Pos') }}</li>
@endsection

@push('style')
<style>
    /* Constrain layout to viewport height to avoid page-level scrollbars */
    .product-tab-wrp {
        height: calc(100vh - 160px) !important;
        display: flex !important;
        flex-direction: column !important;
        overflow: hidden !important;
    }
    .pdp-sop-card {
        flex-grow: 1 !important;
        overflow: hidden !important;
        margin-top: 0 !important;
    }
    
    /* Make right product catalogue scrollable independently */
    .product-body-nop {
        height: calc(100vh - 240px) !important;
        overflow-y: auto !important;
        padding-right: 6px !important;
    }
    
    /* Dynamic compact product grid */
    #product-listing {
        display: grid !important;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)) !important;
        gap: 12px !important;
        width: 100% !important;
        margin: 0 !important;
    }
    #product-listing > div {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
        padding: 0 !important;
    }

    /* Product cards */
    .toacart,
    .product-tab-wrp .tab-pane {
        cursor: pointer !important;
        transition: all 0.2s ease-in-out !important;
    }
    .toacart .card,
    .product-tab-wrp .tab-pane .card {
        border: 1px solid rgba(199, 196, 215, 0.2) !important;
        border-radius: 8px !important;
        overflow: hidden !important;
        background: #ffffff !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        height: 100% !important;
        position: relative !important;
        display: flex !important;
        flex-direction: column !important;
    }
    .toacart .card:hover,
    .product-tab-wrp .tab-pane .card:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05) !important;
        border-color: #4648d4 !important;
    }
    .toacart:active .card {
        border-color: #4648d4 !important;
        background: #f8f9ff !important;
    }
    .toacart .card-image,
    .product-tab-wrp .tab-pane .card-image,
    #product-listing .card-image {
        height: 90px !important;
        object-fit: cover !important;
        width: 100% !important;
        border-bottom: 1px solid rgba(199, 196, 215, 0.1) !important;
        background-color: #f8fafc !important;
    }
    #product-listing .card-image[src*="default.jpg"] {
        object-fit: contain !important;
        padding: 12px !important;
    }
    .toacart .card-body,
    .product-tab-wrp .tab-pane .card-body {
        padding: 6px 8px !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-start !important;
        text-align: left !important;
        justify-content: space-between !important;
        flex-grow: 1 !important;
    }
    .product-title-name {
        font-family: 'Geist', sans-serif !important;
        font-size: 11px !important;
        font-weight: 600 !important;
        color: #0b1c30 !important;
        margin-bottom: 2px !important;
        line-height: 1.3 !important;
        width: 100% !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    .toacart .text-primary,
    .product-tab-wrp .tab-pane .text-primary,
    #product-listing .text-primary {
        color: #1a7431 !important; /* Semantic Green */
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        font-weight: 700 !important;
        font-size: 12px !important;
    }
    .top-badge.badge {
        position: absolute !important;
        top: 6px !important;
        left: 6px !important;
        z-index: 2 !important;
        background-color: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(4px) !important;
        color: #ba1a1a !important;
        border: 1px solid rgba(186, 26, 26, 0.2) !important;
        font-size: 9px !important;
        font-weight: 600 !important;
        padding: 2px 5px !important;
        border-radius: 4px !important;
    }

    /* Left Billing panel card styling */
    .pos-billing-card {
        border-radius: 12px !important;
        border: 1px solid rgba(199, 196, 215, 0.15) !important;
        box-shadow: 0 1px 8px rgba(0,0,0,0.04) !important;
        background: #ffffff !important;
        display: flex !important;
        flex-direction: column !important;
        height: calc(100vh - 180px) !important;
        overflow: hidden !important;
    }
    .carttable-scroll {
        flex-grow: 1 !important;
        overflow-y: auto !important;
        height: auto !important;
        max-height: none !important;
    }
    .pdp-cart-body {
        display: flex !important;
        flex-direction: column !important;
        flex-grow: 1 !important;
        overflow: hidden !important;
    }

    /* Table layout and dimensions */
    .carttable table {
        width: 100% !important;
        table-layout: fixed !important;
        border-collapse: collapse !important;
        margin: 0 !important;
    }
    .carttable th,
    .carttable td {
        padding: 6px 4px !important;
        font-size: 11px !important;
        vertical-align: middle !important;
        border-bottom: 1px solid rgba(199, 196, 215, 0.1) !important;
    }
    .carttable th {
        font-size: 10px !important;
        font-weight: 700 !important;
        color: #767586 !important;
        background-color: #f8f9ff !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        text-align: center !important;
    }
    .carttable th:nth-child(2) {
        text-align: left !important;
    }
    .carttable td.name {
        white-space: normal !important;
        word-break: break-word !important;
        line-height: 1.3 !important;
        font-weight: 600 !important;
        color: #0b1c30 !important;
    }
    
    /* Column widths: Image | Items | Code | Unit | Sale Price | Qty | Sub Total | Action */
    .carttable th:nth-child(1), .carttable td:nth-child(1) { width: 10% !important; text-align: center !important; }  /* Image */
    .carttable th:nth-child(2), .carttable td:nth-child(2) { width: 22% !important; text-align: left !important; }    /* Items */
    .carttable th:nth-child(3), .carttable td:nth-child(3) { width: 14% !important; text-align: center !important; }  /* Code */
    .carttable th:nth-child(4), .carttable td:nth-child(4) { width: 10% !important; text-align: center !important; }  /* Unit */
    .carttable th:nth-child(5), .carttable td:nth-child(5) { width: 12% !important; text-align: center !important; }  /* Sale Price */
    .carttable th:nth-child(6), .carttable td:nth-child(6) { width: 16% !important; text-align: center !important; }  /* Qty */
    .carttable th:nth-child(7), .carttable td:nth-child(7) { width: 12% !important; text-align: center !important; }  /* Sub Total */
    .carttable th:nth-child(8), .carttable td:nth-child(8) { width: 6% !important; text-align: center !important; }   /* Action */
    
    .carttable td.price,
    .carttable td.subtotal {
        text-align: center !important;
    }

    /* Quantity inputs */
    .quantity.buttons_added {
        display: inline-flex !important;
        align-items: center !important;
        border: 1px solid #c7c4d7 !important;
        border-radius: 6px !important;
        overflow: hidden !important;
        background: #ffffff !important;
        vertical-align: middle !important;
        height: 24px !important;
    }
    .quantity.buttons_added input[type="button"] {
        background-color: #f8f9ff !important;
        border: none !important;
        color: #0b1c30 !important;
        width: 18px !important;
        height: 24px !important;
        font-size: 11px !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        transition: background 0.1s !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        padding: 0 !important;
        margin: 0 !important;
    }
    .quantity.buttons_added input[type="button"]:hover {
        background-color: #e2e8f0 !important;
    }
    .quantity.buttons_added input[type="number"] {
        width: 24px !important;
        height: 24px !important;
        padding: 0 !important;
        margin: 0 !important;
        border: none !important;
        border-left: 1px solid #c7c4d7 !important;
        border-right: 1px solid #c7c4d7 !important;
        text-align: center !important;
        font-size: 11px !important;
        font-weight: 600 !important;
        color: #0b1c30 !important;
        background: #ffffff !important;
        outline: none !important;
        box-shadow: none !important;
        line-height: 24px !important;
        -webkit-appearance: none !important;
        -moz-appearance: textfield !important;
        border-radius: 0 !important;
    }
    .cart-images img {
        border: 1px solid rgba(199, 196, 215, 0.2) !important;
        border-radius: 4px !important;
        width: 26px !important;
        height: 26px !important;
        object-fit: cover !important;
    }

    /* Customer Select & Inputs */
    .customer_select,
    select#customer,
    .pos-billing-card .form-control {
        border-radius: 6px !important;
        border: 1px solid #c7c4d7 !important;
        padding: 4px 8px !important;
        font-size: 12px !important;
        background-color: #ffffff !important;
        color: #0b1c30 !important;
        height: 32px !important;
        outline: none !important;
    }
    .customer_select:focus,
    .pos-billing-card .form-control:focus {
        border-color: #4648d4 !important;
        box-shadow: 0 0 0 3px rgba(70, 72, 212, 0.1) !important;
    }

    /* Category list selector */
    #categories-listing {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        gap: 6px !important;
        padding-bottom: 4px !important;
    }
    #categories-listing::-webkit-scrollbar {
        height: 4px !important;
    }
    #categories-listing::-webkit-scrollbar-track {
        background: transparent !important;
    }
    #categories-listing::-webkit-scrollbar-thumb {
        background: rgba(0, 0, 0, 0.1) !important;
        border-radius: 4px !important;
    }
    .cat-tab-item {
        margin: 0 !important;
    }
    .cat-tab-item .card {
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
        margin-bottom: 0 !important;
    }
    .cat-tab-item button {
        background-color: #f1f5f9 !important;
        color: #475569 !important;
        border-radius: 6px !important;
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
        padding: 5px 12px !important;
        font-family: 'Geist', sans-serif !important;
        font-size: 11px !important;
        font-weight: 600 !important;
        transition: all 0.2s !important;
        white-space: nowrap !important;
    }
    .cat-tab-item button:hover {
        background-color: #4648d4 !important;
        color: #ffffff !important;
        border-color: #4648d4 !important;
    }
    .cat-tab-item.cat-active button {
        background-color: #4648d4 !important;
        color: #ffffff !important;
        border-color: #4648d4 !important;
    }

    /* Search input field custom */
    .search-input-wrp .input-group {
        border-radius: 8px !important;
        overflow: hidden !important;
        border: 1px solid #c7c4d7 !important;
        background-color: #f8f9ff !important;
    }
    .search-input-wrp .input-group-text {
        background: transparent !important;
        border: none !important;
        color: #767586 !important;
        padding: 8px 10px !important;
    }
    .search-input-wrp input#searchproduct {
        border: none !important;
        background: transparent !important;
        padding: 8px 10px 8px 0 !important;
        box-shadow: none !important;
        font-size: 13px !important;
    }
    .search-input-wrp .input-group:focus-within {
        border-color: #4648d4 !important;
        box-shadow: 0 0 0 3px rgba(70, 72, 212, 0.1) !important;
        background-color: #ffffff !important;
    }

    /* Totals & checkout styling */
    .total-section {
        border-top: 1px solid rgba(199, 196, 215, 0.2) !important;
        padding-top: 12px !important;
        margin-top: auto !important;
    }
    .total-section .discount {
        height: 30px !important;
        border: 1px solid #c7c4d7 !important;
        border-radius: 6px !important;
        padding: 4px 8px !important;
        font-size: 11px !important;
        width: 100% !important;
        text-align: right !important;
    }
    .total-section h6 {
        font-family: 'Geist', sans-serif !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #464554 !important;
    }
    .total-section .subtotal_price,
    .total-section .totalamount {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        color: #0b1c30 !important;
    }
    
    #btn-pur button.btn-primary {
        background-color: #4648d4 !important;
        border-color: #4648d4 !important;
        color: #ffffff !important;
        font-family: 'Geist', sans-serif !important;
        font-weight: 600 !important;
        padding: 8px 18px !important;
        border-radius: 8px !important;
        font-size: 12px !important;
        transition: all 0.2s !important;
    }
    #btn-pur button.btn-primary:hover {
        background-color: #6063ee !important;
        border-color: #6063ee !important;
    }
    .btn-empty a.btn-danger {
        background-color: #ffffff !important;
        border: 1px solid #ba1a1a !important;
        color: #ba1a1a !important;
        font-family: 'Geist', sans-serif !important;
        font-weight: 600 !important;
        padding: 8px 16px !important;
        border-radius: 8px !important;
        font-size: 12px !important;
        transition: all 0.2s !important;
    }
    .btn-empty a.btn-danger:hover {
        background-color: #ffdad6 !important;
        color: #ba1a1a !important;
    }

    /* Active sidebar and navigation colors */
    .sg-nav-link.sg-active {
        background-color: #4648d4 !important;
        color: #ffffff !important;
    }

    /* Header spacing details */
    .dash-header {
        padding: 10px 24px !important;
        margin-bottom: 0 !important;
    }

    /* Responsive Layout Overrides */
    @media (max-width: 991px) {
        .product-tab-wrp,
        .product-body-nop,
        .pos-billing-card {
            height: auto !important;
            overflow: visible !important;
        }
        .carttable-scroll {
            height: 300px !important;
            flex-grow: 0 !important;
        }
        .category-tab-wrapper {
            max-width: 100% !important;
            width: 100% !important;
        }
    }
</style>
@endpush

@section('content')
<x-ui.page-container>
    <x-ui.page-header title="{{ __('Pos') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Pos') }}</span>
        </x-slot>
    </x-ui.page-header>

    <?php $lastsegment = request()->segment(count(request()->segments())) ?>

    <!-- Two-Panel Workspace -->
    <div class="row row-gap pdp-sop-card g-3 mt-1 align-items-stretch">
        
        <!-- LEFT PANEL: Cart / Billing (col-lg-5 col-xl-4) -->
        <div class="col-lg-5 col-xl-4 col-md-12">
            <div class="card m-0 h-100 pos-billing-card">
                
                <div class="card-body carttable cart-product-list carttable-scroll pdp-cart-body d-flex flex-column" id="carthtml" style="padding: 12px !important;">
                    
                    <!-- 1. QUICK ACTION BAR -->
                    <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                        <h4 class="mb-0 font-extrabold text-sm text-dark" style="font-family: 'Geist', sans-serif;">{{ __('Quick Action') }}</h4>
                        <div class="d-flex align-items-center gap-1">
                            <a href="{{ route('product.index') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1 py-1 px-2" style="border-radius: 6px; font-weight: 600; font-size: 10px;">
                                <i class="ti ti-building-store"></i> {{ __('Product List') }}
                            </a>
                            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1 py-1 px-2" style="border-radius: 6px; font-weight: 600; font-size: 10px;">
                                <i class="ti ti-chart-bar"></i> {{ __('Today Sales') }}
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1 py-1 px-2" style="border-radius: 6px; font-weight: 600; font-size: 10px;" onclick="alert('Calculator widget coming soon')">
                                <i class="ti ti-calculator"></i> {{ __('Calculator') }}
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1 py-1 px-2" style="border-radius: 6px; font-weight: 600; font-size: 10px;">
                                <i class="ti ti-home"></i> {{ __('Dashboard') }}
                            </a>
                        </div>
                    </div>

                    <!-- 2. CUSTOMER / ORDER INFORMATION (2x2 Grid) -->
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label font-bold text-xs text-gray-500 mb-1 d-block">{{ __('Select Customer') }}</label>
                            <div class="d-flex align-items-center gap-1">
                                <div class="flex-grow-1">
                                    {{ Form::select('customer_id',$customers,'', array('class' => 'form-control select customer_select','id'=>'customer','required'=>'required')) }}
                                </div>
                                <button type="button" class="btn btn-primary d-flex align-items-center justify-content-center p-0" style="width: 32px; height: 32px; background-color: #4648d4 !important; border-color: #4648d4 !important; color: #ffffff !important;" onclick="window.location.href='{{ route('customer.index') }}'">
                                    <i class="ti ti-plus"></i>
                                </button>
                            </div>
                            {{ Form::hidden('vc_name_hidden', '',['id' => 'vc_name_hidden']) }}
                            <input type="hidden" id="store_id" value="{{ \Auth::user()->current_store }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label font-bold text-xs text-gray-500 mb-1 d-block">{{ __('Date') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ date('d M Y') }}" readonly style="height: 32px; font-size: 12px;">
                                <span class="input-group-text bg-light p-1 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="ti ti-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 mb-3 border-bottom pb-2">
                        <div class="col-6">
                            <label class="form-label font-bold text-xs text-gray-500 mb-1 d-block">{{ __('Invoice no.') }}</label>
                            <input type="text" class="form-control" value="INV-{{ time() }}" readonly style="height: 32px; font-size: 12px;">
                        </div>
                        <div class="col-6">
                            <label class="form-label font-bold text-xs text-gray-500 mb-1 d-block">{{ __('Select Warehouse') }}</label>
                            <select class="form-control" style="height: 32px; font-size: 12px;">
                                <option value="1">{{ __('Default Warehouse') }}</option>
                                <option value="2">{{ __('Main Warehouse') }}</option>
                            </select>
                        </div>
                    </div>

                    <!-- 3. CART TABLE -->
                    @php $total = 0 @endphp
                    <div class="table-responsive" style="flex-grow: 1;">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>{{__('Image')}}</th>
                                <th class="text-left">{{__('Items')}}</th>
                                <th>{{__('Code')}}</th>
                                <th>{{__('Unit')}}</th>
                                <th class="text-center">{{__('Sale Price')}}</th>
                                <th class="text-center">{{__('Qty')}}</th>
                                <th class="text-center">{{__('Sub Total')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>

                            <tbody id="tbody">
                            @if(session($lastsegment) && !empty(session($lastsegment)) && count(session($lastsegment)) > 0)
                                @foreach(session($lastsegment) as $id => $details)
                                    @php
                                        $product = \App\Models\Product::find($details['id']);
                                        $image_url = !empty($product->is_cover) ? $product->is_cover : 'default.jpg';
                                        if($details['variant_id'] <= 0){
                                            $total = $total + (float) $details['subtotal'];
                                        }else{
                                            $total = $total + (float) $details['variant_subtotal'];
                                        }
                                    @endphp
                                    @if(\Auth::user()->current_store == $product->store_id)
                                        @if($details['variant_id'] <= 0)
                                            <tr data-product-id="{{$id}}" id="product-id-{{$details['id']}}">
                                        @else
                                            <tr data-product-id="{{$id}}" id="product-variant-id-{{$details['variant_id']}}">
                                        @endif
                                            <td class="cart-images">
                                                <img alt="Image placeholder" src="{{ asset(Storage::url('uploads/is_cover_image/'.$image_url)) }}" class="card-image avatar rounded-circle-sale border border-2 border-primary rounded">
                                            </td>
                                            @if($details['variant_id'] <= 0)
                                                <td class="name">{{ $details['product_name'] }}</td>
                                                <td class="code text-center">{{ $product->SKU ?? 'N/A' }}</td>
                                                <td class="unit text-center">{{ __('Pcs') }}</td>
                                                <td class="price">{{ \App\Models\Utility::priceFormat($details['price']) }}</td>
                                                <td>
                                                    <span class="quantity buttons_added">
                                                        <input type="button" value="-" class="minus">
                                                        <input type="number" step="1" min="1" max="" name="quantity" title="{{ __('Quantity') }}" class="input-number" size="4" data-url="{{ url('update-cart/') }}" data-id="{{ $id }}" value="{{ $details['quantity'] }}">
                                                        <input type="button" value="+" class="plus">
                                                    </span>
                                                </td>
                                                <td class="subtotal">{{ \App\Models\Utility::priceFormat($details['subtotal']) }}</td>
                                            @else
                                                <td class="name">
                                                    {{ $details['product_name'] }} - ({{ $details['variant_name'] }})
                                                </td>
                                                <td class="code text-center">{{ $product->SKU ?? 'N/A' }}</td>
                                                <td class="unit text-center">{{ __('Pcs') }}</td>
                                                <td class="price">{{ \App\Models\Utility::priceFormat($details['variant_price']) }}</td>
                                                <td>
                                                    <span class="quantity buttons_added">
                                                        <input type="button" value="-" class="minus">
                                                        <input type="number" step="1" min="1" max="" name="quantity" title="{{ __('Quantity') }}" class="input-number" size="4" data-url="{{ url('update-cart/') }}" data-id="{{ $id }}" value="{{ $details['quantity'] }}">
                                                        <input type="button" value="+" class="plus">
                                                    </span>
                                                </td>
                                                <td class="subtotal">{{ \App\Models\Utility::priceFormat($details['variant_subtotal']) }}</td>
                                            @endif
                                            <td class="text-center">
                                                <a href="#" class="bs-pass-para btn btn-sm btn-icon bg-danger text-white" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="delete-form-{{ $id }}" title="{{ __('Delete') }}" data-id="{{ $id }}">
                                                    <span><i class="ti ti-trash"></i></span>
                                                </a>
                                                {!! Form::open(['method' => 'delete', 'url' => ['remove-from-cart'],'id' => 'delete-form-'.$id]) !!}
                                                <input type="hidden" name="session_key" value="{{ $lastsegment }}" id="cart_delete_form">
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- 4. BILLING AREA (Split Panel) -->
                    <div class="total-section pdp-discount mt-3">
                        <div class="row">
                            <!-- LEFT: Receive Amount, Change Amount, Due Amount, Payment Type, Note -->
                            <div class="col-md-6 border-end pr-2" style="max-height: 200px; overflow-y: auto;">
                                <div class="mb-1">
                                    <label class="form-label text-xs font-semibold text-gray-500 mb-0">{{ __('Receive Amount') }}</label>
                                    <input type="number" class="form-control form-control-sm" placeholder="$0.00" value="0">
                                </div>
                                <div class="mb-1">
                                    <label class="form-label text-xs font-semibold text-gray-500 mb-0">{{ __('Change Amount') }}</label>
                                    <input type="text" class="form-control form-control-sm" value="$0.00" readonly>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label text-xs font-semibold text-gray-500 mb-0">{{ __('Due Amount') }}</label>
                                    <input type="text" class="form-control form-control-sm" value="$0.00" readonly>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label text-xs font-semibold text-gray-500 mb-0">{{ __('Payment Type') }}</label>
                                    <select class="form-control form-control-sm">
                                        <option value="Cash">{{ __('Cash') }}</option>
                                        <option value="Card">{{ __('Card') }}</option>
                                        <option value="Bank Transfer">{{ __('Bank Transfer') }}</option>
                                    </select>
                                </div>
                                <div class="mb-0">
                                    <label class="form-label text-xs font-semibold text-gray-500 mb-0">{{ __('Note') }}</label>
                                    <textarea class="form-control form-control-sm" rows="2" placeholder="{{ __('Type note...') }}" style="height: auto;"></textarea>
                                </div>
                            </div>

                            <!-- RIGHT: Sub Total, Discount, VAT, Total Amount -->
                            <div class="col-md-6 pl-2 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-xs font-semibold text-gray-600">{{ __('Sub Total') }} :</span>
                                        <h6 class="mb-0 font-bold text-dark subtotal_price" id="displaytotal">
                                            {{  \App\Models\Utility::priceFormat($total) }}
                                        </h6>
                                    </div>

                                    <!-- Discount Row -->
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-xs font-semibold text-gray-600">{{__('Discount')}} :</span>
                                        <div class="d-flex align-items-center gap-1 justify-content-end">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-outline-primary py-0 px-2 active" style="font-size: 9px; line-height: 1.5;">%</button>
                                                <button type="button" class="btn btn-outline-primary py-0 px-2" style="font-size: 9px; line-height: 1.5;">$</button>
                                            </div>
                                            <div style="width: 80px;">
                                                {{ Form::number('discount',null, array('class' => 'form-control discount','required'=>'required','placeholder'=>__('Ex: 10'))) }}
                                                {{ Form::hidden('discount_hidden', '',['id' => 'discount_hidden']) }}
                                            </div>
                                        </div>
                                    </div>

                                    <!-- VAT Row -->
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-xs font-semibold text-gray-600">{{__('VAT')}} :</span>
                                        <div class="d-flex align-items-center gap-1 justify-content-end">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <button type="button" class="btn btn-outline-primary py-0 px-2 active" style="font-size: 9px; line-height: 1.5;">%</button>
                                                <button type="button" class="btn btn-outline-primary py-0 px-2" style="font-size: 9px; line-height: 1.5;">$</button>
                                            </div>
                                            <div style="width: 80px;">
                                                <input type="text" class="form-control text-end py-0" value="0.00" readonly style="height: 30px; font-size: 11px;">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total Amount Row -->
                                    <div class="d-flex justify-content-between align-items-center mb-3 pt-1 border-top">
                                        <h6 class="mb-0 text-gray-800 font-bold text-xs">{{ __('Total Amount') }} :</h6>
                                        <h6 class="totalamount mb-0 font-extrabold text-dark" style="font-size: 14px;">
                                            {{ \App\Models\Utility::priceFormat($total) }}
                                        </h6>
                                    </div>
                                </div>

                                <!-- 5. BOTTOM ACTIONS -->
                                <div class="d-flex align-items-center justify-content-between gap-2" id="btn-pur">
                                    <div class="flex-grow-1">
                                        <a href="#" class="btn btn-warning bs-pass-para w-100 py-2 font-bold text-center m-0" style="background-color: #ff9f43 !important; border-color: #ff9f43 !important; color: #ffffff !important; font-size: 11px; border-radius: 6px; line-height: 1.2;" data-toggle="tooltip" data-original-title="{{ __('Empty Cart') }}"
                                            data-confirm="{{ __('Are You Sure?') }}" data-text="{{__('This action can not be undone. Do you want to continue?')}}"
                                            data-confirm-yes="delete-form-emptycart">{{ __('SAVE') }}
                                        </a>
                                        {!! Form::open(['method' => 'post', 'url' => ['empty-cart'],'id' => 'delete-form-emptycart']) !!}
                                        <input type="hidden" name="session_key" value="{{ $lastsegment }}" id="empty_cart">
                                        {!! Form::close() !!}
                                    </div>
                                    <div class="flex-grow-1">
                                        @can('Create Pos')
                                            <button type="button" class="btn btn-primary w-100 py-2 font-bold" style="background-color: #4648d4 !important; border-color: #4648d4 !important; color: #ffffff !important; font-size: 11px; border-radius: 6px; line-height: 1.2;" data-ajax-popup="true" data-size="xl"
                                                    data-align="centered" data-url="{{route('pos.create')}}" data-title="{{__('POS Invoice')}}"
                                                    @if(session($lastsegment) && !empty(session($lastsegment)) && count(session($lastsegment)) > 0) @else disabled="disabled" @endif>
                                                {{ __('MAKE PAYMENT') }}
                                            </button>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- RIGHT PANEL: Product Catalogue (col-lg-7 col-xl-8) -->
        <div class="col-lg-7 col-xl-8 col-md-12 d-flex flex-column">
            
            <!-- Search + Category Area inside Catalogue -->
            <div class="category-wrp mb-3">
                <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap">
                    <!-- Search Product input (Left) -->
                    <div class="search-main-form flex-grow-1">
                        <form class="search-input-wrp m-0" onsubmit="return false;">
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-search"></i></span>
                                <input id="searchproduct" type="text" data-url="{{ route('search.products') }}" placeholder="{{ __('Scan / search product by code or name') }}" class="form-control">
                            </div>
                        </form>
                    </div>

                    <!-- Category / Brand toggles (Right) -->
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-primary d-flex align-items-center gap-1 font-semibold text-xs py-2 px-3" style="background-color: #4648d4 !important; border-color: #4648d4 !important; color: #ffffff !important; border-radius: 8px;">
                            <i class="ti ti-category"></i> {{ __('Category') }}
                        </button>
                        <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1 font-semibold text-xs py-2 px-3" style="border-radius: 8px;">
                            <i class="ti ti-tag"></i> {{ __('Brand') }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Categories Horizontal Pills -->
            <div class="category-tab-wrapper overflow-hidden mb-3">
                <div id="categories-listing" class="d-flex align-items-center gap-2 overflow-x-auto py-1">
                    <!-- Dynamic categories go here -->
                </div>
            </div>

            <!-- Products Grid -->
            <div class="product-body-nop pdp-body-nop p-0" style="flex-grow: 1;">
                <div class="form-row row m-0" id="product-listing">
                    <!-- Products listing goes here -->
                </div>
            </div>
            
        </div>
        
    </div>
</x-ui.page-container>
@endsection
@push('script-page')

    <script>

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $( document ).ready(function() {

            $( "#vc_name_hidden" ).val($('.customer_select').val());
            $( "#discount_hidden").val($('.discount').val());

            $(function () {
                getProductCategories();

            });

            if ($('#searchproduct').length > 0) {
                var url = $('#searchproduct').data('url');
                var store_id = $( "#store_id" ).val();
                searchProducts(url,'','0',store_id);
            }


            {{--  $( '#warehouse' ).change(function() {
            var ware_id = $( "#warehouse" ).val();
                searchProducts(url,'','0',ware_id);
            });  --}}
            $( '.customer_select' ).change(function() {
                $( "#vc_name_hidden" ).val($(this).val());
            });



            $(document).on('click', '#clearinput', function (e) {
                var IDs = [];
                $(this).closest('div').find("input").each(function () {
                    IDs.push('#' + this.id);
                });
                $(IDs.toString()).val('');
            });


            $(document).on('keyup', 'input#searchproduct', function () {
                var url = $(this).data('url');
                var value = this.value;
                var cat = $('.cat-active').children().data('cat-id');
                var store_id = $( "#store_id" ).val();
                searchProducts(url, value,cat,store_id);
            });


            function searchProducts(url, value,cat_id,store_id = '0') {
                var session_key = $('#empty_cart').val();
                $.ajax({
                    type: 'GET',
                    url: url,
                    data: {
                        'search': value,
                        'cat_id': cat_id,
                        'store_id' : store_id,
                        'session_key': session_key
                    },
                    success: function (data) {
                        $('#product-listing').html(data);
                    }
                });
            }

            function getProductCategories() {
                $.ajax({
                    type: 'GET',
                    url: '{{ route('product.categories') }}',
                    success: function (data) {

                        $('#categories-listing').html(data);
                    }
                });
            }

            $(document).on('click', '.toacart', function () {

                var sum = 0
                $.ajax({
                    url: $(this).data('url'),

                    success: function (data) {

                        if (data.code == '200') {

                            $('#displaytotal').text(addCommas(data.product.subtotal));
                            $('.totalamount').text(addCommas(data.product.subtotal));

                            if ('carttotal' in data) {
                                $.each(data.carttotal, function (key, value) {
                                    // $('#product-id-' + value.id + ' .subtotal').text(addCommas(value.subtotal));
                                    // sum += value.subtotal;
                                    if(value.variant_id == 0){
                                        $('#product-id-' + value.id + ' .subtotal').text(addCommas(value.subtotal));
                                        sum += value.subtotal;
                                    }else{
                                        $('#product-variant-id-' + value.variant_id + ' .subtotal').text(addCommas(value.variant_subtotal));
                                        sum += value.variant_subtotal;
                                    }
                                });
                                $('#displaytotal').text(addCommas(sum));

                                $('.totalamount').text(addCommas(sum));

                        $('.discount').val('');
                            }

                            $('#tbody').append(data.carthtml);
                            $('.no-found').addClass('d-none');
                            $('.carttable #product-id-' + data.product.id + ' input[name="quantity"]').val(data.product.quantity);
                            $('#btn-pur button').removeAttr('disabled');
                            $('.btn-empty button').addClass('btn-clear-cart');

                            }
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('{{ __("Error") }}', data.error, 'error');
                    }
                });
            });

            $(document).on('change keyup', '#carthtml input[name="quantity"]', function (e) {

                e.preventDefault();
                var ele = $(this);
                var sum = 0;
                var quantity = ele.closest('span').find('input[name="quantity"]').val();
                var discount = $('.discount').val();
                var session_key = $('#empty_cart').val();
                if(quantity != null && quantity != 0){
                    $.ajax({
                        url: ele.data('url'),
                        method: "patch",
                        data: {
                            id: ele.attr("data-id"),
                            quantity: quantity,
                            discount:discount,
                            session_key: session_key
                        },
                        success: function (data) {

                            if (data.code == '200') {

                                if (quantity == 0) {
                                    ele.closest(".row").hide(250, function () {
                                        ele.closest(".row").remove();
                                    });
                                    if (ele.closest(".row").is(":last-child")) {
                                        $('#btn-pur button').attr('disabled', 'disabled');
                                        $('.btn-empty button').removeClass('btn-clear-cart');
                                    }
                                }

                                $.each(data.product, function (key, value) {
                                    // sum += value.subtotal;
                                    // $('#product-id-' + value.id + ' .subtotal').text(addCommas(value.subtotal));
                                    if(value.variant_id == 0){
                                        $('#product-id-' + value.id + ' .subtotal').text(addCommas(value.subtotal));
                                        sum += value.subtotal;
                                    }else{
                                        $('#product-variant-id-' + value.variant_id + ' .subtotal').text(addCommas(value.variant_subtotal));
                                        sum += value.variant_subtotal;
                                    }
                                });

                                $('#displaytotal').text(addCommas(sum));
                                if(discount <= sum){
                                    $('.totalamount').text(data.discount);
                                }
                                else{
                                    $('.totalamount').text(addCommas(0));
                                }
                            }
                        },
                        error: function (data) {
                            data = data.responseJSON;
                            show_toastr('{{ __("Error") }}', data.error, 'error');
                        }
                    });
                }
            });

            $(document).on('click', '.remove-from-cart', function (e) {
                e.preventDefault();

                var ele = $(this);
                var sum = 0;

                if (confirm('{{ __("Are you sure?") }}')) {
                    ele.closest(".row").hide(250, function () {
                        ele.closest(".row").parent().parent().remove();
                    });
                    if (ele.closest(".row").is(":last-child")) {
                        $('#btn-pur button').attr('disabled', 'disabled');
                        $('.btn-empty button').removeClass('btn-clear-cart');
                    }
                    $.ajax({
                        url: ele.data('url'),
                        method: "DELETE",
                        data: {
                            id: ele.attr("data-id"),

                        },
                        success: function (data) {
                            if (data.code == '200') {

                                $.each(data.product, function (key, value) {
                                    sum += value.subtotal;
                                    $('#product-id-' + value.id + ' .subtotal').text(addCommas(value.subtotal));
                                });

                                $('#displaytotal').text(addCommas(sum));

                                show_toastr('success', data.success, 'success')
                            }
                        },
                        error: function (data) {
                            data = data.responseJSON;
                            show_toastr('{{ __("Error") }}', data.error, 'error');
                        }
                    });
                }
            });

            $(document).on('click', '.btn-clear-cart', function (e) {
                e.preventDefault();

                if (confirm('{{ __("Remove all items from cart?") }}')) {

                    $.ajax({
                        url: $(this).data('url'),
                        data: {
                            session_key: session_key
                        },
                        success: function (data) {
                            location.reload();
                        },
                        error: function (data) {
                            data = data.responseJSON;
                            show_toastr('{{ __("Error") }}', data.error, 'error');
                        }
                    });
                }
            });

            $(document).on('click', '.btn-done-payment', function (e) {
                e.preventDefault();
                var ele = $(this);

                $.ajax({
                    url: ele.data('url'),

                    method: 'GET',
                    data: {
                        vc_name: $('#vc_name_hidden').val(),
                        warehouse_name: $('#warehouse_name_hidden').val(),
                        discount : $('#discount_hidden').val(),
                    },
                    beforeSend: function () {
                        ele.remove();
                    },
                    success: function (data) {

                        if (data.code == 200) {
                            show_toastr('success', data.success, 'success')
                        }

                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('{{ __("Error") }}', data.error, 'error');
                    }

                });

            });

            $(document).on('click', '.category-select', function (e) {
                var cat = $(this).data('cat-id');
                var white = 'text-white';
                var dark = 'text-dark';
                $('.category-select').find('.tab-btns').removeClass('btn-primary')
                $(this).find('.tab-btns').addClass('btn-primary')
                $('.category-select').parent().removeClass('cat-active');
                $('.category-select').find('.card-title').removeClass('text-white').addClass('text-dark');
                $('.category-select').find('.card-title').parent().removeClass('text-white').addClass('text-dark');
                $(this).find('.card-title').removeClass('text-dark').addClass('text-white');
                $(this).find('.card-title').parent().removeClass('text-dark').addClass('text-white');
                $(this).parent().addClass('cat-active');
                var url = '{{ route('search.products') }}'
                var store_id=$('#store_id').val();
                searchProducts(url,'',cat,store_id);
            });

            $(document).on('change keyup', '.discount', function () {

                var discount = $('.discount').val();
                var total = $('#displaytotal').text();
                var maintotal = parseFloat(total.replace("$","").replace(",",""))
                if(discount <= maintotal){
                    $( "#discount_hidden" ).val(discount);
                }else{
                    $( "#discount_hidden" ).val(maintotal);
                }
                $.ajax({
                    url: "{{route('cartdiscount')}}",
                    method: 'POST',
                    data: {discount: discount,},
                    success: function (data)
                    {
                        if(discount <= maintotal){
                            $('.totalamount').text(data.total);
                        }else{
                            $('.totalamount').text(addCommas(0));
                        }
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('{{ __("Error") }}', data.error, 'error');
                    }
                });


                var price = {{$total}}
                var total_amount = price-discount;
                $('.totalamount').text(total_amount);


            });

        });


        // Product Variant script

        $(document).on('change', '.variant-selection', function() {
                var variants = [];
                $(".variant-selection").each(function(index, element) {
                    if (element.value != '' && element.value != undefined) {
                        var el_val = element.value;
                        variants.push(el_val);
                    }
                });
                if (variants.length > 0) {

                    $.ajax({
                        url: '{{ route('get.products.variant.quantity') }}',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            variants: variants.join(' : '),
                            product_id: $('#product_id').val()
                        },

                        success: function(data) {
                            if (data.variant_id == 0) {
                                $('.variant_stock1').addClass('d-none');
                                $('.variation_price1').html('Please Select Variants');
                                // $('#variant_qty').val('0');
                            } else {
                                var qty = 'Price : '  + data.price;
                                var amount = 'QTY : ' + data.quantity;
                                $('.variation_price1').html(qty);
                                $('#variant_id').val(data.variant_id);
                                // $('#variant_qty').val(data.quantity);
                                $('.variant_qty').html(amount);
                                $('.variant_stock1').removeClass('d-none');
                                if (data.quantity != 0) {
                                    $('.variant_stock1').html('In Stock');
                                    $(".variant_stock1").css({
                                        "backgroundColor": "#C2FFA5",
                                        "color": "#58A336"
                                    });
                                } else {
                                    $(".variant_qty").css({
                                        // "backgroundColor": "#FFA5A5",
                                        "color": "rgb(253 58 110)"
                                    });
                                    $('.variant_qty').html('Out Of Stock');
                                }
                            }
                        }
                    });
                }
            });


            $(document).on('click', '.toacartvariant', function () {

            var sum = 0;
            var id = $(this).attr('data-id');
            var session_key = "{{ $lastsegment }}";
            var variants = [];
                $(".variant-selection").each(function(index, element) {
                    variants.push(element.value);
                });

                if (jQuery.inArray('0', variants) != -1) {
                    show_toastr('Error', "{{ __('Please select all option.') }}", 'error');
                    return false;
                }

                var variation_ids = $('#variant_id').val();

            $.ajax({
                    url: '{{ route('addToCartVariant', ['__product_id', 'session_key', 'variation_id']) }}'
                        .replace('__product_id', id).replace('session_key', session_key).replace('variation_id', variation_ids ?? 0),//$(this).data('url'),
                    data: {
                        "_token": "{{ csrf_token() }}",
                        variants: variants.join(' : '),
                    },
                success: function (data) {
                    if (data.code == '200') {

                        $('#displaytotal').text(addCommas(data.product.variant_subtotal));
                        $('.totalamount').text(addCommas(data.product.variant_subtotal));

                        if ('carttotal' in data) {
                            $.each(data.carttotal, function (key, value) {
                                    if(value.variant_id == 0){
                                        $('#product-id-' + value.id + ' .subtotal').text(addCommas(value.subtotal));
                                        sum += value.subtotal;
                                    }else{
                                        $('#product-variant-id-' + value.variant_id + ' .subtotal').text(addCommas(value.variant_subtotal));
                                        sum += value.variant_subtotal;
                                    }
                            });
                            $('#displaytotal').text(addCommas(sum));

                            $('.totalamount').text(addCommas(sum));

                        $('.discount').val('');
                        }
                        $('#tbody').append(data.carthtml);
                        $('.no-found').addClass('d-none');
                        $('.carttable #product-variant-id-' + data.product.variant_id + ' input[name="quantity"]').val(data.product.quantity);
                        $('#btn-pur button').removeAttr('disabled');
                        $('.btn-empty button').addClass('btn-clear-cart');

                        }
                },
                error: function (data) {
                    data = data.responseJSON;
                    show_toastr('{{ __("Error") }}', data.error, 'error');
                }
            });
        });

            $(document).on('click', '.add_to_cart_variant', function () {
                $('#commonModal').modal('hide');
            });

    </script>
    <script>
        var site_currency_symbol_position = '{{ \App\Models\Utility::getValByName('currency_symbol_position') }}';
        var site_currency_symbol = '{{ \App\Models\Store::where('id',\Auth::user()->current_store)->first()->currency }}';
    </script>
@endpush
