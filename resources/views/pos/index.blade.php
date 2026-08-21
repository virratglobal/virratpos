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

@push('style')
<style>
    /* Prevent page-level scrollbar, constrain POS to viewport height */
    .pos-workspace-container {
        display: flex !important;
        gap: 16px !important;
        width: 100% !important;
        overflow: hidden !important;
        height: calc(100vh - 185px) !important;
    }
    
    /* Scrollbar styling for high-performance terminal feel */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #475569;
    }
    .no-scrollbar::-webkit-scrollbar {
        display: none !important;
    }
    .no-scrollbar {
        -ms-overflow-style: none !important;
        scrollbar-width: none !important;
    }

    /* Left panel: Product catalog grid */
    #product-listing {
        display: grid !important;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)) !important;
        gap: 12px !important;
        width: 100% !important;
        margin: 0 !important;
        padding-bottom: 20px !important;
    }
    @media (min-width: 1200px) {
        #product-listing {
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr)) !important;
        }
    }
    #product-listing > div {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
        padding: 0 !important;
    }

    /* Product cards (Stitch UI style) */
    #product-listing .card,
    #modal-product-listing .card {
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        overflow: hidden !important;
        background: #ffffff !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        height: 100% !important;
        display: flex !important;
        flex-direction: column !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
        cursor: pointer !important;
        position: relative !important;
    }
    #product-listing .card:hover,
    #modal-product-listing .card:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05) !important;
        border-color: #4648d4 !important;
    }
    #product-listing .card-image,
    #modal-product-listing .card-image {
        aspect-ratio: 1.3 / 1 !important;
        height: 90px !important;
        object-fit: cover !important;
        width: 100% !important;
        border-bottom: 1px solid #e2e8f0 !important;
        background-color: #f8fafc !important;
    }
    #product-listing .card-image[src*="default.jpg"],
    #modal-product-listing .card-image[src*="default.jpg"] {
        object-fit: contain !important;
        padding: 12px !important;
    }
    #product-listing .card-body,
    #product-listing .custom-card-body,
    #modal-product-listing .card-body,
    #modal-product-listing .custom-card-body {
        padding: 8px 12px !important;
        display: flex !important;
        flex-direction: column !important;
        flex-grow: 1 !important;
        align-items: flex-start !important;
        text-align: left !important;
        justify-content: flex-end !important;
    }
    #product-listing .product-title-name,
    #modal-product-listing .product-title-name {
        font-family: 'Inter', sans-serif !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #1e293b !important;
        margin-bottom: 2px !important;
        line-height: 1.4 !important;
        width: 100% !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    #product-listing .text-primary,
    #modal-product-listing .text-primary {
        color: #4648d4 !important;
        font-family: 'Inter', sans-serif !important;
        font-weight: 700 !important;
        font-size: 13px !important;
        margin-top: 2px !important;
    }
    #product-listing .top-badge.badge,
    #modal-product-listing .top-badge.badge {
        position: absolute !important;
        top: 6px !important;
        right: 6px !important;
        left: auto !important;
        z-index: 10 !important;
        background-color: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(4px) !important;
        color: #4648d4 !important;
        border: 1px solid rgba(70, 72, 212, 0.15) !important;
        font-size: 9px !important;
        font-weight: 700 !important;
        padding: 2px 6px !important;
        border-radius: 4px !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
    }

    /* Category pills horizontal list */
    #categories-listing,
    #modal-categories-listing {
        display: flex !important;
        flex-wrap: nowrap !important;
        overflow-x: auto !important;
        gap: 8px !important;
        padding-bottom: 4px !important;
        width: 100% !important;
    }
    .cat-tab-item {
        margin: 0 !important;
        flex-shrink: 0 !important;
    }
    .cat-tab-item .card {
        border: none !important;
        box-shadow: none !important;
        background: transparent !important;
        margin-bottom: 0 !important;
        border-radius: 0 !important;
    }
    .cat-tab-item button {
        background-color: #f1f5f9 !important;
        color: #475569 !important;
        border-radius: 9999px !important;
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
        padding: 5px 14px !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 11px !important;
        font-weight: 500 !important;
        transition: all 0.2s !important;
        white-space: nowrap !important;
    }
    .cat-tab-item button:hover {
        background-color: #e2e8f0 !important;
        color: #0f172a !important;
    }
    .cat-tab-item.cat-active button,
    .cat-tab-item.cat-active .tab-btns {
        background-color: #4648d4 !important;
        color: #ffffff !important;
        border-color: #4648d4 !important;
    }

    /* Search input styles */
    .search-input-wrp .input-group {
        border-radius: 8px !important;
        overflow: hidden !important;
        border: 1px solid #cbd5e1 !important;
        background-color: #ffffff !important;
    }
    .search-input-wrp .input-group-text {
        background: transparent !important;
        border: none !important;
        color: #64748b !important;
        padding: 8px 12px !important;
    }
    .search-input-wrp input#searchproduct,
    .search-input-wrp input#modal-searchproduct {
        border: none !important;
        background: transparent !important;
        padding: 8px 12px 8px 0 !important;
        box-shadow: none !important;
        font-size: 13px !important;
        height: 38px !important;
    }
    .search-input-wrp .input-group:focus-within {
        border-color: #4648d4 !important;
        box-shadow: 0 0 0 3px rgba(70, 72, 212, 0.1) !important;
    }

    /* Right panel: Billing & Cart Card */
    .pos-billing-card {
        border-radius: 16px !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05) !important;
        background: #ffffff !important;
        display: flex !important;
        flex-direction: column !important;
        height: 100% !important;
        overflow: hidden !important;
    }
    .billing-totals-wrap {
        flex: 0 0 auto !important;
        display: flex !important;
        flex-direction: column !important;
        background-color: #f8fafc !important;
        border-top: 1px solid #e2e8f0 !important;
    }
    .carttable-scroll {
        flex: 1 1 0% !important;
        overflow-y: auto !important;
        overflow-x: auto !important;
        min-height: 120px !important;
    }
    
    /* Cart table custom styles */
    .carttable table {
        width: 100% !important;
        border-collapse: collapse !important;
        margin: 0 !important;
    }
    .carttable th,
    .carttable td {
        padding: 8px 12px !important;
        font-size: 12px !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }
    .carttable th {
        font-size: 11px !important;
        font-weight: 600 !important;
        color: #475569 !important;
        background-color: #f8fafc !important;
        text-align: left !important;
    }
    .carttable td.name {
        font-weight: 500 !important;
        color: #1e293b !important;
        word-break: break-word !important;
        line-height: 1.4 !important;
    }
    .carttable td.price,
    .carttable td.subtotal {
        font-weight: 500 !important;
        color: #1e293b !important;
    }
    .cart-images img {
        border: 1px solid #e2e8f0 !important;
        border-radius: 6px !important;
        width: 32px !important;
        height: 32px !important;
        object-fit: cover !important;
    }

    /* Quantity increment controls inside table */
    .quantity.buttons_added {
        display: inline-flex !important;
        align-items: center !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        overflow: hidden !important;
        background: #ffffff !important;
        height: 24px !important;
    }
    .quantity.buttons_added input[type="button"] {
        background-color: #f8fafc !important;
        border: none !important;
        color: #64748b !important;
        width: 20px !important;
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
        background-color: #f1f5f9 !important;
        color: #0f172a !important;
    }
    .quantity.buttons_added input[type="number"] {
        width: 26px !important;
        height: 24px !important;
        padding: 0 !important;
        margin: 0 !important;
        border: none !important;
        border-left: 1px solid #cbd5e1 !important;
        border-right: 1px solid #cbd5e1 !important;
        text-align: center !important;
        font-size: 11px !important;
        font-weight: 600 !important;
        color: #0f172a !important;
        background: #ffffff !important;
        outline: none !important;
        box-shadow: none !important;
        line-height: 24px !important;
        -webkit-appearance: none !important;
        -moz-appearance: textfield !important;
        border-radius: 0 !important;
    }

    /* Inputs details in billing card */
    .pos-billing-card .form-control,
    .pos-billing-card select,
    .customer_select,
    select#customer {
        border-radius: 8px !important;
        border: 1px solid #cbd5e1 !important;
        padding: 6px 12px !important;
        font-size: 13px !important;
        background-color: #ffffff !important;
        color: #0f172a !important;
        height: 38px !important;
        outline: none !important;
        box-shadow: none !important;
        width: 100%;
    }
    .pos-billing-card .form-control:focus,
    .customer_select:focus,
    select#customer:focus {
        border-color: #4648d4 !important;
        box-shadow: 0 0 0 3px rgba(70, 72, 212, 0.1) !important;
    }
    
    /* Layout styling responsive */
    @media (max-width: 991px) {
        .pos-workspace-container {
            height: auto !important;
            flex-direction: column !important;
            overflow: visible !important;
        }
        .pos-workspace-container > div {
            width: 100% !important;
            height: auto !important;
        }
        .pos-billing-card {
            height: 600px !important;
        }
    }

    /* Pay Method Button styling */
    .paymethod-btn {
        transition: all 0.2s ease-in-out;
    }
</style>
@endpush

@section('content')
<x-ui.page-container>
    <?php $lastsegment = request()->segment(count(request()->segments())) ?>

    <div class="flex flex-col h-auto lg:h-[calc(100vh-105px)] overflow-visible lg:overflow-hidden">
        <!-- Dedicated POS Toolbar -->
        <div class="pos-toolbar mb-3 bg-white border border-slate-200 rounded-xl px-4 py-3 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4 select-none shrink-0">
            <!-- POS / Register Indicator -->
            <div class="flex items-center gap-2">
                <span class="flex h-3 w-3 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                </span>
                <span class="font-bold text-slate-800 tracking-tight text-sm uppercase">{{ __('POS Terminal') }}</span>
                <span class="text-slate-300 font-light">|</span>
                <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider bg-slate-100 px-2 py-0.5 rounded">{{ __('Register Active') }}</span>
            </div>

            <!-- Live Date & Time -->
            <div class="flex items-center gap-2 font-medium text-slate-700 text-sm md:absolute md:left-1/2 md:-translate-x-1/2">
                <span class="material-symbols-outlined text-indigo-600 text-lg leading-none">schedule</span>
                <span id="pos-live-date" class="text-slate-500 font-semibold"></span>
                <span class="text-slate-300">•</span>
                <span id="pos-live-time" class="font-bold text-slate-800"></span>
            </div>

            <!-- Redesigned Action Buttons (No Navigation Links) -->
            <div class="flex items-center gap-2 flex-wrap">
                <button type="button" onclick="openProductBrowser()" class="h-9 px-3.5 bg-white hover:bg-indigo-50 text-slate-700 hover:text-indigo-600 rounded-lg text-xs font-bold flex items-center gap-1.5 border border-slate-200 hover:border-indigo-200 shadow-sm transition-all cursor-pointer focus:outline-none focus:ring-2 focus:ring-indigo-500/25">
                    <i class="ti ti-building-store text-base leading-none"></i> {{ __('Product List') }}
                </button>
                <button type="button" onclick="openTodaySales()" class="h-9 px-3.5 bg-white hover:bg-purple-50 text-slate-700 hover:text-purple-600 rounded-lg text-xs font-bold flex items-center gap-1.5 border border-slate-200 hover:border-purple-200 shadow-sm transition-all cursor-pointer focus:outline-none focus:ring-2 focus:ring-purple-500/25">
                    <i class="ti ti-chart-bar text-base leading-none"></i> {{ __('Today\'s Sales') }}
                </button>
                <button type="button" id="btn-calculator" class="h-9 px-3.5 bg-white hover:bg-blue-50 text-slate-700 hover:text-blue-600 rounded-lg text-xs font-bold flex items-center gap-1.5 border border-slate-200 hover:border-blue-200 shadow-sm transition-all cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-500/25" onclick="toggleCalculator()">
                    <i class="ti ti-calculator text-base leading-none"></i> {{ __('Calculator') }}
                </button>
                <button type="button" onclick="openPosDashboard()" class="h-9 px-3.5 bg-white hover:bg-rose-50 text-slate-700 hover:text-rose-600 rounded-lg text-xs font-bold flex items-center gap-1.5 border border-slate-200 hover:border-rose-200 shadow-sm transition-all cursor-pointer focus:outline-none focus:ring-2 focus:ring-rose-500/25">
                    <i class="ti ti-dashboard text-base leading-none"></i> {{ __('POS Dashboard') }}
                </button>
            </div>
        </div>

        <!-- Two-Panel POS Workspace -->
        <div class="pos-workspace-container flex-grow min-h-0">
            
            <!-- LEFT PANEL: PRODUCT CATALOGUE (w-[40%]) -->
            <div class="w-full lg:w-[40%] flex flex-col gap-3 h-full overflow-hidden">
                
                <!-- 1. Search Bar Card -->
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm flex flex-col gap-3 shrink-0">
                    <div class="search-main-form w-full">
                        <form class="search-input-wrp m-0" onsubmit="return false;">
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-search"></i></span>
                                <input id="searchproduct" type="text" data-url="{{ route('search.products') }}" placeholder="{{ __('Search product by code or name') }}" class="form-control">
                            </div>
                        </form>
                    </div>
                    
                    <!-- Category Pills listing -->
                    <div class="category-tab-wrapper overflow-hidden">
                        <div id="categories-listing" class="no-scrollbar">
                            <!-- Dynamic categories loaded via AJAX -->
                        </div>
                    </div>
                </div>

                <!-- 2. Scrollable Product Cards Grid -->
                <div class="flex-grow overflow-y-auto custom-scrollbar pr-1">
                    <div id="product-listing">
                        <!-- Dynamic products loaded via AJAX -->
                    </div>
                </div>

            </div>

            <!-- RIGHT PANEL: CART & BILLING (w-[60%]) -->
            <div class="w-full lg:w-[60%] flex flex-col gap-3 h-full overflow-hidden">

                <!-- 2. Main Cart/Billing card container -->
                <div class="pos-billing-card">
                    
                    <!-- Order Info Grid Row (Customer, Date, Invoice, Warehouse) -->
                    <div class="p-4 border-b border-slate-100 flex flex-col gap-3 shrink-0">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-semibold text-slate-500 mb-1 block">{{ __('Select Customer') }}</label>
                                <div class="flex gap-2 items-center">
                                    <div class="flex-grow">
                                        {{ Form::select('customer_id',$customers,'', array('class' => 'form-control select customer_select','id'=>'customer','required'=>'required')) }}
                                    </div>
                                    <!-- Info Icon -->
                                    <button type="button" id="btn-customer-info" class="w-9 h-[38px] bg-slate-50 hover:bg-slate-100 text-slate-500 rounded-lg flex items-center justify-center border border-slate-200 cursor-pointer transition-colors" onclick="showSelectedCustomerInfo()">
                                        <span class="material-symbols-outlined text-lg">info</span>
                                    </button>
                                    <!-- Add Customer Modal Plus Icon -->
                                    <button type="button" class="w-10 h-[38px] bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg flex items-center justify-center border-none cursor-pointer transition-colors" onclick="toggleAddCustomerModal()">
                                        <i class="ti ti-plus text-sm"></i>
                                    </button>
                                </div>
                                {{ Form::hidden('vc_name_hidden', '',['id' => 'vc_name_hidden']) }}
                                <input type="hidden" id="store_id" value="{{ \Auth::user()->current_store }}">
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-500 mb-1 block">{{ __('Date') }}</label>
                                <div class="relative">
                                    <input type="text" class="form-control w-full pr-10" value="{{ date('d M Y') }}" readonly>
                                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-lg pointer-events-none">calendar_today</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-semibold text-slate-500 mb-1 block">{{ __('Invoice no.') }}</label>
                                <input type="text" class="form-control w-full bg-slate-50" value="INV-{{ time() }}" readonly>
                            </div>
                            <div>
                                <label class="text-xs font-semibold text-slate-500 mb-1 block">{{ __('Select Warehouse') }}</label>
                                <select class="form-control w-full">
                                    <option value="1">{{ __('Default Warehouse') }}</option>
                                    <option value="2">{{ __('Main Warehouse') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Cart table body (flexible scrollable) -->
                    @php $total = 0 @endphp
                    <div class="overflow-y-auto custom-scrollbar carttable-scroll" id="carthtml">
                        <div class="carttable">
                            <table class="w-full text-sm text-left">
                                <thead class="sticky top-0 bg-slate-50 text-slate-700 font-semibold border-b border-slate-200 z-10">
                                    <tr>
                                        <th style="width: 10%;">{{__('Image')}}</th>
                                        <th style="width: 22%;">{{__('Items')}}</th>
                                        <th style="width: 16%;" class="text-center">{{__('Qty')}}</th>
                                        <th style="width: 14%;" class="text-center">{{__('Tax')}}</th>
                                        <th style="width: 14%;" class="text-right">{{__('Sale Price')}}</th>
                                        <th style="width: 16%;" class="text-right">{{__('Sub Total')}}</th>
                                        <th style="width: 8%;" class="text-center">{{__('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody" class="divide-y divide-slate-100">
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

                                                // Render tax badges exactly like controller
                                                $product_tax = '';
                                                if (!empty($details['tax'])) {
                                                    foreach ($details['tax'] as $tax) {
                                                        $product_tax .= "<span class='badge bg-primary'>" . $tax['tax_name'] . ' (' . $tax['tax'] . '%)' . "</span><br>";
                                                    }
                                                } else {
                                                    $product_tax = '-';
                                                }
                                            @endphp
                                            @if(\Auth::user()->current_store == $product->store_id)
                                                @if($details['variant_id'] <= 0)
                                                    <tr data-product-id="{{$id}}" id="product-id-{{$details['id']}}">
                                                @else
                                                    <tr data-product-id="{{$id}}" id="product-variant-id-{{$details['variant_id']}}">
                                                @endif
                                                    <td class="cart-images">
                                                        <img alt="Image placeholder" src="{{ asset(Storage::url('uploads/is_cover_image/'.$image_url)) }}" class="card-image avatar rounded border border-slate-200">
                                                    </td>
                                                    @if($details['variant_id'] <= 0)
                                                        <td class="name">{{ $details['product_name'] }}</td>
                                                        <td>
                                                            <span class="quantity buttons_added">
                                                                <input type="button" value="-" class="minus">
                                                                <input type="number" step="1" min="1" max="" name="quantity" title="{{ __('Quantity') }}" class="input-number" size="4" data-url="{{ url('update-cart/') }}" data-id="{{ $id }}" value="{{ $details['quantity'] }}">
                                                                <input type="button" value="+" class="plus">
                                                            </span>
                                                        </td>
                                                        <td class="tax">{!! $product_tax !!}</td>
                                                        <td class="price text-right">{{ \App\Models\Utility::priceFormat($details['price']) }}</td>
                                                        <td class="subtotal text-right">{{ \App\Models\Utility::priceFormat($details['subtotal']) }}</td>
                                                    @else
                                                        <td class="name">
                                                            {{ $details['product_name'] }} - ({{ $details['variant_name'] }})
                                                        </td>
                                                        <td>
                                                            <span class="quantity buttons_added">
                                                                <input type="button" value="-" class="minus">
                                                                <input type="number" step="1" min="1" max="" name="quantity" title="{{ __('Quantity') }}" class="input-number" size="4" data-url="{{ url('update-cart/') }}" data-id="{{ $id }}" value="{{ $details['quantity'] }}">
                                                                <input type="button" value="+" class="plus">
                                                            </span>
                                                        </td>
                                                        <td class="tax">{!! $product_tax !!}</td>
                                                        <td class="price text-right">{{ \App\Models\Utility::priceFormat($details['variant_price']) }}</td>
                                                        <td class="subtotal text-right">{{ \App\Models\Utility::priceFormat($details['variant_subtotal']) }}</td>
                                                    @endif
                                                    <td class="text-center">
                                                        <a href="#" class="bs-pass-para text-rose-500 hover:text-rose-700 transition-colors" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="delete-form-{{ $id }}" title="{{ __('Delete') }}" data-id="{{ $id }}">
                                                            <span class="material-symbols-outlined text-lg">close</span>
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
                    </div>

                    <!-- Billing & Totals Section -->
                    <div class="border-t border-slate-100 bg-slate-50 flex-grow billing-totals-wrap min-h-0">
                        <div class="p-4 grid grid-cols-12 gap-4">
                            <!-- Left Side Inputs (Payment Info) -->
                            <div class="col-span-7 space-y-2">
                                <div class="flex items-center justify-between gap-3">
                                    <label class="text-xs font-semibold text-slate-500 w-28 shrink-0">{{ __('Receive Amount') }}</label>
                                    <input type="number" id="receive-amount" class="flex-grow min-w-0 form-control" placeholder="$0.00" value="0">
                                </div>
                                <div class="flex items-center justify-between gap-3">
                                    <label class="text-xs font-semibold text-slate-500 w-28 shrink-0">{{ __('Change Amount') }}</label>
                                    <input type="text" id="change-amount" class="flex-grow min-w-0 form-control bg-slate-100" value="$0.00" readonly>
                                </div>
                                <div class="flex items-center justify-between gap-3">
                                    <label class="text-xs font-semibold text-slate-500 w-28 shrink-0">{{ __('Due Amount') }}</label>
                                    <input type="text" id="due-amount" class="flex-grow min-w-0 form-control bg-slate-100" value="$0.00" readonly>
                                </div>
                                <div class="flex items-center justify-between gap-3">
                                    <label class="text-xs font-semibold text-slate-500 w-28 shrink-0">{{ __('Payment Type') }}</label>
                                    <select id="payment-type-select" class="flex-grow min-w-0 form-control">
                                        <option value="Cash">{{ __('Cash') }}</option>
                                        <option value="Card">{{ __('Card') }}</option>
                                        <option value="Bank Transfer">{{ __('Bank Transfer') }}</option>
                                    </select>
                                </div>
                                <div class="flex items-start justify-between gap-3">
                                    <label class="text-xs font-semibold text-slate-500 w-28 shrink-0 pt-2">{{ __('Note') }}</label>
                                    <textarea id="order-notes" class="flex-grow min-w-0 form-control resize-none h-12" placeholder="{{ __('Type note...') }}"></textarea>
                                </div>
                            </div>
                            <!-- Right Side Summary (Totals) -->
                            <div class="col-span-5 bg-white border border-slate-200 rounded-xl p-3 flex flex-col justify-center space-y-2">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="font-semibold text-slate-500">{{ __('Sub Total') }}</span>
                                    <span class="font-bold text-slate-800 subtotal_price" id="displaytotal">{{  \App\Models\Utility::priceFormat($total) }}</span>
                                </div>
                                <div class="flex justify-between items-center text-xs gap-1">
                                    <span class="font-semibold text-slate-500 shrink-0">{{__('Discount')}}</span>
                                    <div class="flex items-center gap-1 shrink-0">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-primary py-0 px-1.5 active" style="font-size: 9px;">%</button>
                                            <button type="button" class="btn btn-outline-primary py-0 px-1.5" style="font-size: 9px;">$</button>
                                        </div>
                                        <div style="width: 70px;">
                                            {{ Form::number('discount',null, array('class' => 'form-control discount w-full text-right','required'=>'required','placeholder'=>__('Ex: 10'), 'style'=>'height: 28px; padding: 2px 6px; font-size: 11px;')) }}
                                            {{ Form::hidden('discount_hidden', '',['id' => 'discount_hidden']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center text-xs gap-1">
                                    <span class="font-semibold text-slate-500 shrink-0">{{__('VAT')}}</span>
                                    <div class="flex items-center gap-1 shrink-0">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-primary py-0 px-1.5 active" style="font-size: 9px;">%</button>
                                            <button type="button" class="btn btn-outline-primary py-0 px-1.5" style="font-size: 9px;">$</button>
                                        </div>
                                        <input type="text" class="form-control text-end py-0 bg-slate-50" value="0.00" readonly style="height: 28px; width: 70px; padding: 2px 6px; font-size: 11px;">
                                    </div>
                                </div>
                                <div class="flex justify-between items-center pt-2 border-t border-slate-100 mt-1">
                                    <span class="font-bold text-slate-700">{{ __('Total') }}</span>
                                    <span class="font-bold text-base text-indigo-600 totalamount">{{ \App\Models\Utility::priceFormat($total) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons Footer -->
                    <div class="p-4 bg-white border-t border-slate-100 grid grid-cols-2 gap-4 shrink-0" id="btn-pur">
                        <div>
                            <a href="#" class="bs-pass-para w-full py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-sm font-bold text-center block transition-all text-decoration-none" data-toggle="tooltip" data-original-title="{{ __('Empty Cart') }}" data-confirm="{{ __('Are You Sure?') }}" data-text="{{__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="delete-form-emptycart">
                                {{ __('SAVE') }}
                            </a>
                            {!! Form::open(['method' => 'post', 'url' => ['empty-cart'],'id' => 'delete-form-emptycart']) !!}
                            <input type="hidden" name="session_key" value="{{ $lastsegment }}" id="empty_cart">
                            {!! Form::close() !!}
                        </div>
                        <div>
                            @can('Create Pos')
                                <button type="button" id="btn-make-payment" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-bold shadow-sm transition-all border-none cursor-pointer" onclick="openPaymentModal()" @if(session($lastsegment) && !empty(session($lastsegment)) && count(session($lastsegment)) > 0) @else disabled="disabled" @endif>
                                    {{ __('MAKE PAYMENT') }}
                                </button>
                            @endcan
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- ======================= MODALS ======================= -->

        <!-- Add Customer Modal -->
        <div id="addCustomerModal" class="fixed inset-0 z-[1060] hidden items-center justify-center bg-black/40 backdrop-blur-sm" style="display: none; align-items: center; justify-content: center;">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xl w-[450px] overflow-hidden flex flex-col">
                <!-- Header -->
                <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                    <span class="font-bold text-slate-800 text-sm">{{ __('Add Customer') }}</span>
                    <button type="button" class="text-slate-400 hover:text-slate-600 cursor-pointer border-none bg-transparent p-0 flex" onclick="toggleAddCustomerModal()">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
                <!-- Body -->
                <form id="addCustomerForm" class="p-4 space-y-3" onsubmit="submitAddCustomer(event)">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-semibold text-slate-500 mb-1 block">{{ __('Customer Name *') }}</label>
                            <input type="text" name="name" required class="form-control w-full" placeholder="John Doe">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-slate-500 mb-1 block">{{ __('Phone Number *') }}</label>
                            <input type="text" name="phone_number" required class="form-control w-full" placeholder="1234567890">
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-500 mb-1 block">{{ __('Email') }}</label>
                        <input type="email" name="email" class="form-control w-full" placeholder="john@example.com">
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-500 mb-1 block">{{ __('Address') }}</label>
                        <input type="text" name="address" class="form-control w-full" placeholder="123 POS St">
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="text-xs font-semibold text-slate-500 mb-1 block">{{ __('City') }}</label>
                            <input type="text" name="city" class="form-control w-full" placeholder="City">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-slate-500 mb-1 block">{{ __('State') }}</label>
                            <input type="text" name="state" class="form-control w-full" placeholder="State">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-slate-500 mb-1 block">{{ __('ZIP Code') }}</label>
                            <input type="text" name="zipcode" class="form-control w-full" placeholder="12345">
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-500 mb-1 block">{{ __('Optional Notes') }}</label>
                        <textarea name="notes" class="form-control w-full resize-none h-12" placeholder="Customer notes..."></textarea>
                    </div>
                    <!-- Footer -->
                    <div class="pt-3 border-t border-slate-100 flex justify-end gap-2">
                        <button type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold border-none cursor-pointer" onclick="toggleAddCustomerModal()">{{ __('Cancel') }}</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold border-none cursor-pointer">{{ __('Create Customer') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Customer Quick View Modal -->
        <div id="customerDetailsModal" class="fixed inset-0 z-[1060] hidden items-center justify-center bg-black/40 backdrop-blur-sm" style="display: none; align-items: center; justify-content: center;">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xl w-[400px] overflow-hidden flex flex-col">
                <!-- Header -->
                <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                    <span class="font-bold text-slate-800 text-sm">{{ __('Customer Profile View') }}</span>
                    <button type="button" class="text-slate-400 hover:text-slate-600 cursor-pointer border-none bg-transparent p-0 flex" onclick="toggleCustomerDetailsModal()">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
                <!-- Body -->
                <div class="p-4 space-y-4">
                    <div class="flex items-center gap-3 pb-3 border-b border-slate-100">
                        <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg" id="cview-avatar-initials">CD</div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm m-0" id="cview-name">-</h4>
                            <span class="text-xs text-slate-400 font-medium" id="cview-phone">-</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-slate-400 font-semibold uppercase tracking-wider block mb-0.5">{{ __('Email') }}</span>
                            <span class="text-slate-800 font-medium break-all" id="cview-email">-</span>
                        </div>
                        <div>
                            <span class="text-slate-400 font-semibold uppercase tracking-wider block mb-0.5">{{ __('Address') }}</span>
                            <span class="text-slate-800 font-medium" id="cview-address">-</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-3 border-t border-slate-100">
                        <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 text-center">
                            <span class="text-[10px] text-slate-400 font-bold uppercase block mb-1">{{ __('Total Orders') }}</span>
                            <span class="text-lg font-bold text-slate-800" id="cview-order-count">0</span>
                        </div>
                        <div class="bg-indigo-50/50 rounded-xl p-3 border border-indigo-100/50 text-center">
                            <span class="text-[10px] text-indigo-500 font-bold uppercase block mb-1">{{ __('Total Spent') }}</span>
                            <span class="text-lg font-bold text-indigo-600" id="cview-total-purchase">₹0.00</span>
                        </div>
                    </div>
                </div>
                <!-- Footer -->
                <div class="px-4 py-3 bg-slate-50 border-t border-slate-100 flex justify-end">
                    <button type="button" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-xs font-bold border-none cursor-pointer" onclick="toggleCustomerDetailsModal()">{{ __('Close') }}</button>
                </div>
            </div>
        </div>

        <!-- Product Browser Modal -->
        <div id="productBrowserModal" class="fixed inset-0 z-[1050] hidden items-center justify-center bg-black/40 backdrop-blur-sm" style="display: none; align-items: center; justify-content: center;">
            <div class="bg-slate-50 rounded-2xl border border-slate-200 shadow-xl w-[90%] max-w-[900px] h-[85vh] overflow-hidden flex flex-col">
                <!-- Header -->
                <div class="bg-white px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-building-store text-lg text-indigo-600"></i>
                        <span class="font-bold text-slate-800 text-sm">{{ __('Product Browser') }}</span>
                    </div>
                    <button type="button" class="text-slate-400 hover:text-slate-600 cursor-pointer border-none bg-transparent p-0 flex" onclick="toggleProductBrowserModal()">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
                <!-- Search & Filter Area -->
                <div class="bg-white p-4 border-b border-slate-100 flex flex-col md:flex-row gap-3">
                    <div class="flex-grow">
                        <div class="search-input-wrp m-0">
                            <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-search"></i></span>
                                <input id="modal-searchproduct" type="text" placeholder="{{ __('Search product by code or name') }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto no-scrollbar py-1" style="max-width: 100%;">
                        <div id="modal-categories-listing" class="flex gap-2">
                            <!-- Category Pills -->
                        </div>
                    </div>
                </div>
                <!-- Body (Grid scrollable) -->
                <div class="flex-grow overflow-y-auto p-4 custom-scrollbar">
                    <div id="modal-product-listing" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                        <!-- Product cards -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Today's Sales Modal -->
        <div id="todaySalesModal" class="fixed inset-0 z-[1050] hidden items-center justify-center bg-black/40 backdrop-blur-sm" style="display: none; align-items: center; justify-content: center;">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xl w-[650px] h-[80vh] overflow-hidden flex flex-col">
                <!-- Header -->
                <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-chart-bar text-lg text-indigo-600"></i>
                        <span class="font-bold text-slate-800 text-sm">{{ __('Today\'s Sales Overview') }}</span>
                    </div>
                    <button type="button" class="text-slate-400 hover:text-slate-600 cursor-pointer border-none bg-transparent p-0 flex" onclick="toggleTodaySalesModal()">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
                <!-- Summary Cards -->
                <div class="p-4 grid grid-cols-2 sm:grid-cols-4 gap-3 bg-slate-50 border-b border-slate-100">
                    <div class="bg-white p-3 rounded-xl border border-slate-200">
                        <span class="text-[10px] text-slate-400 font-bold uppercase block">{{ __('Total Sales') }}</span>
                        <span class="text-sm font-bold text-slate-800 block mt-1" id="todaysales-total">₹0.00</span>
                    </div>
                    <div class="bg-white p-3 rounded-xl border border-slate-200">
                        <span class="text-[10px] text-slate-400 font-bold uppercase block">{{ __('Orders') }}</span>
                        <span class="text-sm font-bold text-slate-800 block mt-1" id="todaysales-count">0</span>
                    </div>
                    <div class="bg-white p-3 rounded-xl border border-slate-200">
                        <span class="text-[10px] text-slate-400 font-bold uppercase block">{{ __('Cash Sales') }}</span>
                        <span class="text-sm font-bold text-emerald-600 block mt-1" id="todaysales-cash">₹0.00</span>
                    </div>
                    <div class="bg-white p-3 rounded-xl border border-slate-200">
                        <span class="text-[10px] text-slate-400 font-bold uppercase block">{{ __('Other Sales') }}</span>
                        <span class="text-sm font-bold text-indigo-600 block mt-1" id="todaysales-other">₹0.00</span>
                    </div>
                </div>
                <!-- Transactions List -->
                <div class="flex-grow overflow-y-auto p-4 custom-scrollbar">
                    <h3 class="text-xs font-bold text-slate-700 mb-3 uppercase tracking-wider">{{ __('Recent POS Transactions') }}</h3>
                    <div class="border border-slate-200 rounded-xl overflow-hidden">
                        <table class="w-full text-xs text-left">
                            <thead class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-200">
                                <tr>
                                    <th class="p-3">{{ __('Invoice') }}</th>
                                    <th class="p-3">{{ __('Customer') }}</th>
                                    <th class="p-3 text-center">{{ __('Time') }}</th>
                                    <th class="p-3 text-right">{{ __('Amount') }}</th>
                                    <th class="p-3 text-center">{{ __('Payment') }}</th>
                                    <th class="p-3 text-center">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="todaysales-transactions" class="divide-y divide-slate-100">
                                <!-- Dynamic rows -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- POS Dashboard Modal -->
        <div id="posDashboardModal" class="fixed inset-0 z-[1050] hidden items-center justify-center bg-black/40 backdrop-blur-sm" style="display: none; align-items: center; justify-content: center;">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xl w-[500px] overflow-hidden flex flex-col">
                <!-- Header -->
                <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="ti ti-dashboard text-lg text-indigo-600"></i>
                        <span class="font-bold text-slate-800 text-sm">{{ __('POS Terminal Dashboard') }}</span>
                    </div>
                    <button type="button" class="text-slate-400 hover:text-slate-600 cursor-pointer border-none bg-transparent p-0 flex" onclick="togglePosDashboardModal()">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
                <!-- Body -->
                <div class="p-4 grid grid-cols-2 gap-4">
                    <div class="bg-indigo-50 border border-indigo-100 rounded-2xl p-4 text-center col-span-2">
                        <span class="text-xs text-indigo-500 font-bold uppercase tracking-wider block mb-1">{{ __('Today\'s Sales') }}</span>
                        <span class="text-3xl font-extrabold text-indigo-600" id="posdash-sales">₹0.00</span>
                    </div>
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 text-center">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">{{ __('Today\'s Orders') }}</span>
                        <span class="text-2xl font-bold text-slate-800" id="posdash-orders">0</span>
                    </div>
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 text-center">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">{{ __('Items Sold') }}</span>
                        <span class="text-2xl font-bold text-slate-800" id="posdash-items-sold">0</span>
                    </div>
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 text-center">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">{{ __('Average Order Value') }}</span>
                        <span class="text-2xl font-bold text-slate-800" id="posdash-aov">₹0.00</span>
                    </div>
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 text-center">
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block mb-1">{{ __('Pending Payments') }}</span>
                        <span class="text-2xl font-bold text-amber-600" id="posdash-pending">0</span>
                    </div>
                </div>
                <!-- Footer -->
                <div class="px-4 py-3 bg-slate-50 border-t border-slate-100 flex justify-end">
                    <button type="button" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-xs font-bold border-none cursor-pointer" onclick="togglePosDashboardModal()">{{ __('Close') }}</button>
                </div>
            </div>
        </div>

        <!-- Calculator Modal -->
        <div id="calculatorModal" class="fixed inset-0 z-[1050] hidden items-center justify-center bg-black/40 backdrop-blur-sm" style="display: none; align-items: center; justify-content: center;">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xl w-72 overflow-hidden flex flex-col">
                <!-- Header -->
                <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                    <div class="flex items-center gap-1.5 text-slate-700 font-semibold text-sm">
                        <i class="ti ti-calculator text-base text-indigo-600"></i>
                        <span>{{ __('Calculator') }}</span>
                    </div>
                    <button type="button" class="text-slate-400 hover:text-slate-600 cursor-pointer border-none bg-transparent p-0 flex" onclick="toggleCalculator()">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
                <!-- Display Screen -->
                <div class="bg-slate-900 p-4 text-right flex flex-col justify-end min-h-[80px]">
                    <div id="calc-expression" class="text-slate-400 text-xs font-mono break-all leading-tight mb-1 h-4"></div>
                    <div id="calc-display" class="text-white text-2xl font-bold font-mono truncate leading-none">0</div>
                </div>
                <!-- Keypad -->
                <div class="p-3 grid grid-cols-4 gap-2 bg-slate-50">
                    <!-- Row 1 -->
                    <button onclick="clearCalc()" class="col-span-2 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-sm font-bold border border-rose-100 transition-colors cursor-pointer">C</button>
                    <button onclick="backspaceCalc()" class="py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-sm font-bold border-none transition-colors cursor-pointer">⌫</button>
                    <button onclick="inputOperator('/')" class="py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-lg text-sm font-bold border border-indigo-100 transition-colors cursor-pointer">÷</button>
                    
                    <!-- Row 2 -->
                    <button onclick="inputNumber('7')" class="py-2 bg-white hover:bg-slate-100 text-slate-800 rounded-lg text-sm font-semibold border border-slate-200 transition-colors cursor-pointer">7</button>
                    <button onclick="inputNumber('8')" class="py-2 bg-white hover:bg-slate-100 text-slate-800 rounded-lg text-sm font-semibold border border-slate-200 transition-colors cursor-pointer">8</button>
                    <button onclick="inputNumber('9')" class="py-2 bg-white hover:bg-slate-100 text-slate-800 rounded-lg text-sm font-semibold border border-slate-200 transition-colors cursor-pointer">9</button>
                    <button onclick="inputOperator('*')" class="py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-lg text-sm font-bold border border-indigo-100 transition-colors cursor-pointer">×</button>
                    
                    <!-- Row 3 -->
                    <button onclick="inputNumber('4')" class="py-2 bg-white hover:bg-slate-100 text-slate-800 rounded-lg text-sm font-semibold border border-slate-200 transition-colors cursor-pointer">4</button>
                    <button onclick="inputNumber('5')" class="py-2 bg-white hover:bg-slate-100 text-slate-800 rounded-lg text-sm font-semibold border border-slate-200 transition-colors cursor-pointer">5</button>
                    <button onclick="inputNumber('6')" class="py-2 bg-white hover:bg-slate-100 text-slate-800 rounded-lg text-sm font-semibold border border-slate-200 transition-colors cursor-pointer">6</button>
                    <button onclick="inputOperator('-')" class="py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-lg text-sm font-bold border border-indigo-100 transition-colors cursor-pointer">-</button>
                    
                    <!-- Row 4 -->
                    <button onclick="inputNumber('1')" class="py-2 bg-white hover:bg-slate-100 text-slate-800 rounded-lg text-sm font-semibold border border-slate-200 transition-colors cursor-pointer">1</button>
                    <button onclick="inputNumber('2')" class="py-2 bg-white hover:bg-slate-100 text-slate-800 rounded-lg text-sm font-semibold border border-slate-200 transition-colors cursor-pointer">2</button>
                    <button onclick="inputNumber('3')" class="py-2 bg-white hover:bg-slate-100 text-slate-800 rounded-lg text-sm font-semibold border border-slate-200 transition-colors cursor-pointer">3</button>
                    <button onclick="inputOperator('+')" class="py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-lg text-sm font-bold border border-indigo-100 transition-colors cursor-pointer">+</button>
                    
                    <!-- Row 5 -->
                    <button onclick="inputNumber('0')" class="col-span-2 py-2 bg-white hover:bg-slate-100 text-slate-800 rounded-lg text-sm font-semibold border border-slate-200 transition-colors cursor-pointer">0</button>
                    <button onclick="inputDecimal()" class="py-2 bg-white hover:bg-slate-100 text-slate-800 rounded-lg text-sm font-semibold border border-slate-200 transition-colors cursor-pointer">.</button>
                    <button onclick="calculateResult()" class="py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-bold border-none transition-colors cursor-pointer">=</button>
                </div>
            </div>
        </div>

        <!-- POS Checkout Payment Modal -->
        <div id="posPaymentModal" class="fixed inset-0 z-[1050] hidden items-center justify-center bg-black/40 backdrop-blur-sm" style="display: none; align-items: center; justify-content: center;">
            <!-- Inner Card (Standard Form State) -->
            <div id="paymentFormState" class="bg-white rounded-2xl border border-slate-200 shadow-xl w-[450px] overflow-hidden flex flex-col">
                <!-- Header -->
                <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                    <span class="font-bold text-slate-800 text-sm">{{ __('Collect Payment') }}</span>
                    <button type="button" class="text-slate-400 hover:text-slate-600 cursor-pointer border-none bg-transparent p-0 flex" onclick="togglePaymentModal()">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
                <!-- Body -->
                <div class="p-4 space-y-4">
                    <div class="bg-indigo-50 border border-indigo-100/50 rounded-2xl p-4 text-center">
                        <span class="text-xs text-indigo-500 font-semibold uppercase tracking-wider block mb-1">{{ __('Total Due') }}</span>
                        <span class="text-3xl font-extrabold text-indigo-600" id="paymodal-total">₹0.00</span>
                    </div>
                    
                    <div>
                        <label class="text-xs font-semibold text-slate-500 mb-1 block">{{ __('Select Payment Method') }}</label>
                        <div class="grid grid-cols-3 gap-2" id="paymodal-method-buttons">
                            <button type="button" onclick="selectPaymentMethod('Cash')" class="paymethod-btn py-2 border rounded-xl font-bold text-xs cursor-pointer bg-indigo-600 border-indigo-600 text-white flex flex-col items-center gap-1">
                                <i class="ti ti-cash text-base"></i>
                                <span>{{ __('Cash') }}</span>
                            </button>
                            <button type="button" onclick="selectPaymentMethod('Card')" class="paymethod-btn py-2 border border-slate-200 hover:bg-slate-50 rounded-xl font-bold text-xs cursor-pointer text-slate-700 flex flex-col items-center gap-1">
                                <i class="ti ti-credit-card text-base"></i>
                                <span>{{ __('Card') }}</span>
                            </button>
                            <button type="button" onclick="selectPaymentMethod('Bank Transfer')" class="paymethod-btn py-2 border border-slate-200 hover:bg-slate-50 rounded-xl font-bold text-xs cursor-pointer text-slate-700 flex flex-col items-center gap-1">
                                <i class="ti ti-building-bank text-base"></i>
                                <span>{{ __('UPI / Bank') }}</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-xs font-semibold text-slate-500 mb-1 block">{{ __('Amount Received') }}</label>
                            <input type="number" id="paymodal-received" step="0.01" class="form-control w-full font-bold text-sm" placeholder="0.00" onkeyup="calculatePaymodalChange()">
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-slate-500 mb-1 block">{{ __('Change Due') }}</label>
                            <input type="text" id="paymodal-change" class="form-control w-full bg-slate-50 font-bold text-sm text-emerald-600" value="₹0.00" readonly>
                        </div>
                    </div>
                    
                    <div>
                        <label class="text-xs font-semibold text-slate-500 mb-1 block">{{ __('Customer') }}</label>
                        <input type="text" id="paymodal-customer" class="form-control w-full bg-slate-50 text-xs" readonly>
                    </div>
                </div>
                <!-- Footer -->
                <div class="px-4 py-3 bg-slate-50 border-t border-slate-100 flex justify-end gap-2">
                    <button type="button" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-xs font-bold border-none cursor-pointer" onclick="togglePaymentModal()">{{ __('Cancel') }}</button>
                    <button type="button" id="paymodal-submit-btn" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold border-none cursor-pointer" onclick="submitPOSPayment()">{{ __('Complete Payment') }}</button>
                </div>
            </div>

            <!-- Inner Card (Payment Success State) -->
            <div id="paymentSuccessState" class="bg-white rounded-2xl border border-slate-200 shadow-xl w-[450px] overflow-hidden flex flex-col" style="display:none;">
                <div class="p-6 text-center space-y-4">
                    <div class="w-14 h-14 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-2">
                        <span class="material-symbols-outlined text-3xl">check_circle</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 m-0">{{ __('Payment Completed Successfully!') }}</h3>
                    <p class="text-xs text-slate-400 m-0">{{ __('The transaction has been processed and saved.') }}</p>
                    
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 text-left space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-semibold">{{ __('Invoice Number:') }}</span>
                            <span class="text-slate-800 font-bold" id="success-invoice-no">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-semibold">{{ __('Amount Paid:') }}</span>
                            <span class="text-slate-800 font-bold text-indigo-600" id="success-amount">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-semibold">{{ __('Customer:') }}</span>
                            <span class="text-slate-800 font-bold" id="success-customer">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-semibold">{{ __('Payment Method:') }}</span>
                            <span class="text-slate-800 font-bold" id="success-method">-</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400 font-semibold">{{ __('Date & Time:') }}</span>
                            <span class="text-slate-800 font-bold" id="success-datetime">-</span>
                        </div>
                    </div>

                    <div class="pt-2 flex justify-center gap-2">
                        <button type="button" class="px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 rounded-lg text-xs font-bold border border-indigo-100 cursor-pointer flex items-center gap-1" id="success-print-btn">
                            <span class="material-symbols-outlined text-base">print</span>
                            <span>{{ __('Print Receipt') }}</span>
                        </button>
                        <button type="button" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold border-none cursor-pointer" onclick="startNewSale()">{{ __('New Sale') }}</button>
                        <button type="button" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold border-none cursor-pointer" onclick="closePaymentSuccessModal()">{{ __('Close') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice / Receipt Print Preview Modal -->
        <div id="invoicePreviewModal" class="fixed inset-0 z-[1070] hidden items-center justify-center bg-black/40 backdrop-blur-sm" style="display: none; align-items: center; justify-content: center;">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-xl w-[90%] max-w-[500px] h-[85vh] overflow-hidden flex flex-col">
                <!-- Header -->
                <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 flex items-center justify-between">
                    <span class="font-bold text-slate-800 text-sm">{{ __('Receipt Print Preview') }}</span>
                    <div class="flex items-center gap-2">
                        <button type="button" class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-xs font-bold border-none cursor-pointer flex items-center gap-1" id="invoice-preview-print-btn">
                            <span class="material-symbols-outlined text-sm">print</span>
                            <span>{{ __('Print') }}</span>
                        </button>
                        <button type="button" class="text-slate-400 hover:text-slate-600 cursor-pointer border-none bg-transparent p-0 flex" onclick="toggleInvoicePreviewModal()">
                            <span class="material-symbols-outlined text-lg">close</span>
                        </button>
                    </div>
                </div>
                <!-- Body (iframe content) -->
                <div class="flex-grow overflow-hidden bg-slate-100 p-4">
                    <iframe id="invoice-preview-iframe" class="w-full h-full border border-slate-200 rounded-xl bg-white" src="about:blank"></iframe>
                </div>
            </div>
        </div>

    </div> <!-- Close outer flex-col container -->
</x-ui.page-container>
@endsection

@push('script-page')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Site details variables
        var site_currency_symbol_position = '{{ \App\Models\Utility::getValByName("currency_symbol_position") }}';
        var site_currency_symbol = '{{ \App\Models\Store::where("id",\Auth::user()->current_store)->first()->currency }}';

        // Format Currency Helper
        function formatCurrency(amount) {
            var formatted = parseFloat(amount).toFixed(2);
            if (site_currency_symbol_position === 'pre') {
                return site_currency_symbol + formatted;
            } else {
                return formatted + site_currency_symbol;
            }
        }

        // Calculator Variables & Logic
        let calcCurrentInput = '0';
        let calcExpression = '';

        window.toggleCalculator = function() {
            const modal = document.getElementById('calculatorModal');
            const btn = document.getElementById('btn-calculator');
            if (modal.style.display === 'none') {
                modal.style.display = 'flex';
                if (btn) {
                    btn.classList.add('bg-blue-50', 'text-blue-600', 'border-blue-300', 'ring-2', 'ring-blue-500/10');
                    btn.classList.remove('bg-white', 'text-slate-700', 'border-slate-200');
                }
                resetCalculator();
            } else {
                modal.style.display = 'none';
                if (btn) {
                    btn.classList.remove('bg-blue-50', 'text-blue-600', 'border-blue-300', 'ring-2', 'ring-blue-500/10');
                    btn.classList.add('bg-white', 'text-slate-700', 'border-slate-200');
                }
            }
        };

        window.resetCalculator = function() {
            calcCurrentInput = '0';
            calcExpression = '';
            updateCalcDisplay();
        };

        window.updateCalcDisplay = function() {
            document.getElementById('calc-display').innerText = calcCurrentInput;
            document.getElementById('calc-expression').innerText = calcExpression;
        };

        window.clearCalc = function() {
            resetCalculator();
        };

        window.backspaceCalc = function() {
            if (calcCurrentInput.length > 1) {
                calcCurrentInput = calcCurrentInput.slice(0, -1);
            } else {
                calcCurrentInput = '0';
            }
            updateCalcDisplay();
        };

        window.inputNumber = function(num) {
            if (calcCurrentInput === '0') {
                calcCurrentInput = num;
            } else {
                calcCurrentInput += num;
            }
            updateCalcDisplay();
        };

        window.inputDecimal = function() {
            if (!calcCurrentInput.includes('.')) {
                calcCurrentInput += '.';
            }
            updateCalcDisplay();
        };

        window.inputOperator = function(op) {
            calcExpression = calcCurrentInput + ' ' + op + ' ';
            calcCurrentInput = '0';
            updateCalcDisplay();
        };

        window.calculateResult = function() {
            if (calcExpression === '') return;
            
            let fullExpr = calcExpression + calcCurrentInput;
            let evalExpr = fullExpr.replace('÷', '/').replace('×', '*');
            
            try {
                let result = Function('"use strict";return (' + evalExpr + ')')();
                
                if (result % 1 !== 0) {
                    result = parseFloat(result.toFixed(8));
                }
                
                calcExpression = fullExpr + ' =';
                calcCurrentInput = String(result);
                updateCalcDisplay();
                calcExpression = ''; 
            } catch (e) {
                calcCurrentInput = 'Error';
                updateCalcDisplay();
                calcCurrentInput = '0';
                calcExpression = '';
            }
        };

        // Live Clock
        function startLiveClock() {
            const dateEl = document.getElementById('pos-live-date');
            const timeEl = document.getElementById('pos-live-time');
            if (!dateEl || !timeEl) return;

            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            function updateTime() {
                const now = new Date();
                
                const dayName = days[now.getDay()];
                const dayNum = now.getDate();
                const monthName = months[now.getMonth()];
                const year = now.getFullYear();
                
                let hours = now.getHours();
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; 
                
                dateEl.textContent = `${dayName}, ${dayNum} ${monthName} ${year}`;
                timeEl.textContent = `${String(hours).padStart(2, '0')}:${minutes} ${ampm}`;
            }
            
            updateTime();
            setInterval(updateTime, 1000);
        }

        // Modal Toggles
        window.toggleAddCustomerModal = function() {
            var modal = $('#addCustomerModal');
            modal.css('display', modal.css('display') === 'none' ? 'flex' : 'none');
        };

        window.toggleCustomerDetailsModal = function() {
            var modal = $('#customerDetailsModal');
            modal.css('display', modal.css('display') === 'none' ? 'flex' : 'none');
        };

        window.toggleProductBrowserModal = function() {
            var modal = $('#productBrowserModal');
            modal.css('display', modal.css('display') === 'none' ? 'flex' : 'none');
        };

        window.toggleTodaySalesModal = function() {
            var modal = $('#todaySalesModal');
            modal.css('display', modal.css('display') === 'none' ? 'flex' : 'none');
        };

        window.togglePosDashboardModal = function() {
            var modal = $('#posDashboardModal');
            modal.css('display', modal.css('display') === 'none' ? 'flex' : 'none');
        };

        window.togglePaymentModal = function() {
            var modal = $('#posPaymentModal');
            modal.css('display', modal.css('display') === 'none' ? 'flex' : 'none');
        };

        window.toggleInvoicePreviewModal = function() {
            var modal = $('#invoicePreviewModal');
            modal.css('display', modal.css('display') === 'none' ? 'flex' : 'none');
        };

        // Form Submit: Add Customer
        window.submitAddCustomer = function(e) {
            e.preventDefault();
            var form = $('#addCustomerForm');
            var formData = form.serialize();
            
            $.ajax({
                url: "{{ route('pos.customer.store') }}",
                method: "POST",
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        // Append new option and select it
                        var newOption = new Option(response.display, response.name, true, true);
                        $('#customer').append(newOption).trigger('change');
                        
                        toggleAddCustomerModal();
                        form[0].reset();
                        show_toastr('Success', response.message, 'success');
                    } else {
                        show_toastr('Error', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    var errorMsg = xhr.responseJSON ? xhr.responseJSON.message : "{{ __('Failed to create customer.') }}";
                    show_toastr('Error', errorMsg, 'error');
                }
            });
        };

        // Show Selected Customer Details
        window.showSelectedCustomerInfo = function() {
            var name = $('#customer').val();
            if (!name || name === 'Walk-in-customer') {
                show_toastr('Info', "{{ __('Walk-in Customer does not have an address profile.') }}", 'info');
                return;
            }
            
            $.ajax({
                url: "{{ url('pos/customer/show-ajax') }}/" + encodeURIComponent(name),
                method: "GET",
                success: function(response) {
                    if (response.status === 'success') {
                        $('#cview-name').text(response.name);
                        $('#cview-phone').text(response.phone);
                        $('#cview-email').text(response.email || '-');
                        
                        var addr = response.address || '';
                        if (response.city) addr += ', ' + response.city;
                        if (response.state) addr += ', ' + response.state;
                        if (response.zip) addr += ' ' + response.zip;
                        $('#cview-address').text(addr || '-');
                        
                        $('#cview-order-count').text(response.order_count);
                        $('#cview-total-purchase').text(response.total_purchase);
                        
                        var initials = response.name.split(' ').map(n => n[0]).join('').substring(0, 2).toUpperCase();
                        $('#cview-avatar-initials').text(initials);
                        
                        toggleCustomerDetailsModal();
                    } else {
                        show_toastr('Error', response.message, 'error');
                    }
                },
                error: function() {
                    show_toastr('Error', "{{ __('Failed to fetch customer data.') }}", 'error');
                }
            });
        };

        // Open Product Browser
        window.openProductBrowser = function() {
            // Populate category list in modal
            var modalCats = $('#categories-listing').html();
            modalCats = modalCats.replaceAll('category-select', 'modal-category-select');
            $('#modal-categories-listing').html(modalCats);
            
            // Highlight active category
            var mainActiveId = $('#categories-listing .cat-active').data('id') || '0';
            $('#modal-categories-listing .modal-category-select').parent().removeClass('cat-active');
            $('#modal-categories-listing [data-id="' + mainActiveId + '"]').addClass('cat-active');
            $('#modal-categories-listing [data-id="' + mainActiveId + '"] button').addClass('btn-primary');
            
            // Copy search value and trigger product load
            $('#modal-searchproduct').val($('#searchproduct').val());
            loadModalProducts();
            
            toggleProductBrowserModal();
        };

        function loadModalProducts() {
            var url = $('#searchproduct').data('url');
            var search = $('#modal-searchproduct').val();
            var cat = $('#modal-categories-listing .cat-active').data('id') || '0';
            var store_id = $('#store_id').val();
            var session_key = $('#empty_cart').val();
            
            $.ajax({
                type: 'GET',
                url: url,
                data: {
                    'search': search,
                    'cat_id': cat,
                    'store_id': store_id,
                    'session_key': session_key
                },
                success: function (data) {
                    $('#modal-product-listing').html(data);
                }
            });
        }

        // Keyup search inside modal browser
        $(document).on('keyup', '#modal-searchproduct', function() {
            loadModalProducts();
        });

        // Click category select inside modal browser
        $(document).on('click', '#modal-categories-listing .modal-category-select', function(e) {
            e.preventDefault();
            $('#modal-categories-listing .tab-btns').removeClass('btn-primary');
            $(this).find('.tab-btns').addClass('btn-primary');
            $('#modal-categories-listing .cat-tab-item').parent().removeClass('cat-active');
            $(this).parent().parent().addClass('cat-active');
            loadModalProducts();
        });

        // Open Today's Sales
        window.openTodaySales = function() {
            $.ajax({
                url: "{{ route('pos.today-sales') }}",
                method: "GET",
                success: function(response) {
                    if (response.status === 'success') {
                        $('#todaysales-total').text(response.total_sales);
                        $('#todaysales-count').text(response.order_count);
                        $('#todaysales-cash').text(response.cash_sales);
                        $('#todaysales-other').text(response.other_sales);
                        
                        var html = '';
                        if (response.transactions.length > 0) {
                            response.transactions.forEach(function(tx) {
                                html += '<tr>' +
                                        '<td class="p-3 font-semibold text-slate-800">' + tx.order_id + '</td>' +
                                        '<td class="p-3 text-slate-600">' + tx.name + '</td>' +
                                        '<td class="p-3 text-center text-slate-400">' + tx.time + '</td>' +
                                        '<td class="p-3 text-right font-bold text-slate-800">' + tx.amount + '</td>' +
                                        '<td class="p-3 text-center">' +
                                            '<span class="px-2 py-0.5 rounded text-[10px] font-bold ' + 
                                            (tx.payment_type.toLowerCase().includes('cash') || tx.payment_type.toLowerCase() === 'pos' ? 'bg-emerald-50 text-emerald-600' : 'bg-indigo-50 text-indigo-600') + '">' +
                                            tx.payment_type + '</span>' +
                                        '</td>' +
                                        '<td class="p-3 text-center">' +
                                            '<button type="button" onclick="viewInvoiceInPage(\'' + tx.id_encrypted + '\')" class="px-2.5 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 border border-indigo-100 rounded-lg text-[10px] font-bold cursor-pointer transition-colors">' +
                                            '{{ __("View Invoice") }}</button>' +
                                        '</td>' +
                                        '</tr>';
                            });
                        } else {
                            html = '<tr><td colspan="6" class="p-4 text-center text-slate-400 font-medium">' + '{{ __("No sales recorded today.") }}' + '</td></tr>';
                        }
                        $('#todaysales-transactions').html(html);
                        toggleTodaySalesModal();
                    } else {
                        show_toastr('Error', response.message, 'error');
                    }
                },
                error: function() {
                    show_toastr('Error', "{{ __('Failed to fetch today\'s sales.') }}", 'error');
                }
            });
        };

        // Open POS Dashboard
        window.openPosDashboard = function() {
            $.ajax({
                url: "{{ route('pos.dashboard-ajax') }}",
                method: "GET",
                success: function(response) {
                    if (response.status === 'success') {
                        $('#posdash-sales').text(response.today_sales);
                        $('#posdash-orders').text(response.today_orders);
                        $('#posdash-items-sold').text(response.items_sold);
                        $('#posdash-aov').text(response.aov);
                        $('#posdash-pending').text(response.pending_payments);
                        togglePosDashboardModal();
                    }
                },
                error: function() {
                    show_toastr('Error', "{{ __('Failed to fetch POS dashboard metrics.') }}", 'error');
                }
            });
        };

        // In-page Invoice Iframe Preview & Local Print
        window.viewInvoiceInPage = function(orderIdEncrypted) {
            var url = "{{ url('order-receipt') }}/" + orderIdEncrypted;
            $('#invoice-preview-iframe').attr('src', url);
            
            // Print action for frame
            $('#invoice-preview-print-btn').off('click').on('click', function() {
                var iframe = document.getElementById('invoice-preview-iframe');
                if (iframe && iframe.contentWindow) {
                    iframe.contentWindow.print();
                }
            });
            
            toggleInvoicePreviewModal();
        };

        // Checkout & Payment Modal Flow
        let selectedPayMethod = 'Cash';

        window.openPaymentModal = function() {
            var total = $('.totalamount').text();
            $('#paymodal-total').text(total);
            
            var custName = $('#customer option:selected').text();
            $('#paymodal-customer').val(custName);
            
            // Reset fields
            $('#paymodal-received').val('');
            $('#paymodal-change').val(formatCurrency(0));
            
            // Reset to Cash selection
            selectPaymentMethod('Cash');
            
            // Sync selected method in sidebar dropdown
            $('#payment-type-select').val('Cash');
            
            $('#paymentFormState').show();
            $('#paymentSuccessState').hide();
            
            togglePaymentModal();
        };

        window.selectPaymentMethod = function(method) {
            selectedPayMethod = method;
            $('.paymethod-btn').removeClass('bg-indigo-600 border-indigo-600 text-white').addClass('border-slate-200 text-slate-700');
            
            var index = method === 'Cash' ? 0 : (method === 'Card' ? 1 : 2);
            $('.paymethod-btn').eq(index).removeClass('border-slate-200 text-slate-700').addClass('bg-indigo-600 border-indigo-600 text-white');
            
            // Sync selection to sidebar select dropdown
            $('#payment-type-select').val(method === 'Bank Transfer' ? 'Bank Transfer' : method);
        };

        window.calculatePaymodalChange = function() {
            var totalText = $('#paymodal-total').text();
            var totalVal = parseFloat(totalText.replace(/[^\d\.]/g, '')) || 0;
            var receivedVal = parseFloat($('#paymodal-received').val()) || 0;
            var changeVal = Math.max(0, receivedVal - totalVal);
            
            $('#paymodal-change').val(formatCurrency(changeVal));
        };

        // Submit checkout payment dynamically
        window.submitPOSPayment = function() {
            var submitBtn = $('#paymodal-submit-btn');
            submitBtn.prop('disabled', true).text('{{ __("Processing...") }}');
            
            $.ajax({
                url: "{{ route('pos.data.store') }}",
                method: 'GET',
                data: {
                    vc_name: $('#customer').val(),
                    store_id: $('#store_id').val(),
                    discount: $('#discount_hidden').val(),
                    price: $('.totalamount').text(),
                    payment_type: selectedPayMethod,
                    notes: $('#order-notes').val()
                },
                success: function(response) {
                    if (response.status === 'success' || response.code == 200) {
                        $('#success-invoice-no').text('#' + (response.id || ''));
                        $('#success-amount').text($('.totalamount').text());
                        $('#success-customer').text($('#customer option:selected').text());
                        $('#success-method').text(selectedPayMethod);
                        
                        var now = new Date();
                        $('#success-datetime').text(now.toLocaleString());
                        
                        // Bind Print Receipt action
                        $('#success-print-btn').off('click').on('click', function() {
                            viewInvoiceInPage(response.order_id); 
                        });
                        
                        // Transition modal cards
                        $('#paymentFormState').hide();
                        $('#paymentSuccessState').show();
                        
                        // Clear the POS sidebar cart table content locally
                        $('#tbody').empty();
                        $('#displaytotal').text(formatCurrency(0));
                        $('.totalamount').text(formatCurrency(0));
                        $('.discount').val('');
                        $('#discount_hidden').val(0);
                        $('#btn-make-payment').prop('disabled', true);
                        
                        show_toastr('Success', response.success || "{{ __('Payment processed successfully.') }}", 'success');
                    } else {
                        show_toastr('Error', response.message, 'error');
                        submitBtn.prop('disabled', false).text('{{ __("Complete Payment") }}');
                    }
                },
                error: function(xhr) {
                    var errorMsg = xhr.responseJSON ? xhr.responseJSON.message : "{{ __('Failed to process payment.') }}";
                    show_toastr('Error', errorMsg, 'error');
                    submitBtn.prop('disabled', false).text('{{ __("Complete Payment") }}');
                }
            });
        };

        window.closePaymentSuccessModal = function() {
            togglePaymentModal();
        };

        window.startNewSale = function() {
            $.ajax({
                url: "{{ url('empty-cart') }}",
                method: "POST",
                data: {
                    session_key: $('#empty_cart').val()
                },
                success: function() {
                    // Reset dropdown
                    $('#customer').val('').trigger('change');
                    
                    // Reset UI numbers
                    $('#displaytotal').text(formatCurrency(0));
                    $('.totalamount').text(formatCurrency(0));
                    $('.discount').val('');
                    $('#discount_hidden').val(0);
                    
                    // Reset form fields
                    $('#order-notes').val('');
                    $('#receive-amount').val(0);
                    $('#change-amount').val(formatCurrency(0));
                    $('#due-amount').val(formatCurrency(0));
                    
                    // Generate new invoice number
                    var newInvoiceNo = 'INV-' + Math.floor(Date.now() / 1000);
                    $('input[value^="INV-"]').val(newInvoiceNo);
                    
                    $('#btn-make-payment').prop('disabled', true);
                    togglePaymentModal();
                }
            });
        };

        // Document Ready Handler
        $( document ).ready(function() {
            startLiveClock();

            $( "#vc_name_hidden" ).val($('.customer_select').val());
            $( "#discount_hidden").val($('.discount').val());

            // Load categories and initial products
            getProductCategories();
            if ($('#searchproduct').length > 0) {
                var url = $('#searchproduct').data('url');
                var store_id = $( "#store_id" ).val();
                searchProducts(url,'','0',store_id);
            }

            $( '.customer_select' ).change(function() {
                $( "#vc_name_hidden" ).val($(this).val());
            });

            $(document).on('keyup', 'input#searchproduct', function () {
                var url = $(this).data('url');
                var value = this.value;
                var cat = $('.cat-active').children().data('cat-id') || '0';
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
                    url: '{{ route("product.categories") }}',
                    success: function (data) {
                        $('#categories-listing').html(data);
                    }
                });
            }

            // Sync values from sidebar total / inputs to payment received / change amounts
            $(document).on('keyup change', '#receive-amount', function() {
                var totalVal = parseFloat($('.totalamount').text().replace(/[^\d\.]/g, '')) || 0;
                var recVal = parseFloat($(this).val()) || 0;
                var change = Math.max(0, recVal - totalVal);
                var due = Math.max(0, totalVal - recVal);
                
                $('#change-amount').val(formatCurrency(change));
                $('#due-amount').val(formatCurrency(due));
            });

            // Increment/Decrement helper for quantity controls
            $(document).on('click', '.minus, .plus', function (e) {
                e.preventDefault();
                var $qty = $(this).closest('.quantity').find('.input-number');
                var currentVal = parseFloat($qty.val()) || 1;
                var isPlus = $(this).hasClass('plus');
                
                if (isPlus) {
                    $qty.val(currentVal + 1).trigger('change');
                } else {
                    if (currentVal > 1) {
                        $qty.val(currentVal - 1).trigger('change');
                    }
                }
            });

            // Click Handler: Add to Cart (Left Panel or Product Browser Modal)
            $(document).on('click', '.toacart', function () {
                var sum = 0;
                $.ajax({
                    url: $(this).data('url'),
                    success: function (data) {
                        if (data.code == '200') {
                            $('#displaytotal').text(addCommas(data.product.subtotal));
                            $('.totalamount').text(addCommas(data.product.subtotal));

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

                            // Append row if not present, otherwise update quantity
                            var targetId = data.product.variant_id <= 0 ? '#product-id-' + data.product.id : '#product-variant-id-' + data.product.variant_id;
                            if ($(targetId).length > 0) {
                                $(targetId + ' input[name="quantity"]').val(data.product.quantity);
                            } else {
                                $('#tbody').append(data.carthtml);
                            }
                            
                            $('.no-found').addClass('d-none');
                            $('#btn-pur button').removeAttr('disabled');
                            $('#btn-make-payment').removeAttr('disabled');
                            $('.btn-empty button').addClass('btn-clear-cart');
                            
                            show_toastr('Success', "{{ __('Product added to cart.') }}", 'success');
                        }
                    },
                    error: function (data) {
                        data = data.responseJSON;
                        show_toastr('{{ __("Error") }}', data.error, 'error');
                    }
                });
            });

            // Handler: Quantity update
            $(document).on('change keyup', '#carthtml input[name="quantity"]', function (e) {
                e.preventDefault();
                var ele = $(this);
                var sum = 0;
                var quantity = ele.val();
                var discount = $('.discount').val() || 0;
                var session_key = $('#empty_cart').val();
                
                if(quantity != null && quantity != 0){
                    $.ajax({
                        url: ele.data('url'),
                        method: "patch",
                        data: {
                            id: ele.attr("data-id"),
                            quantity: quantity,
                            discount: discount,
                            session_key: session_key
                        },
                        success: function (data) {
                            if (data.code == '200') {
                                $.each(data.product, function (key, value) {
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
                                } else {
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

            // Category select inside main panel
            $(document).on('click', '#categories-listing .category-select', function (e) {
                var cat = $(this).data('cat-id');
                $('#categories-listing .category-select').find('.tab-btns').removeClass('btn-primary');
                $(this).find('.tab-btns').addClass('btn-primary');
                $('#categories-listing .cat-tab-item').removeClass('cat-active');
                $(this).parent().addClass('cat-active');
                
                var url = '{{ route("search.products") }}';
                var store_id = $('#store_id').val();
                searchProducts(url, '', cat, store_id);
            });

            // Discount update
            $(document).on('change keyup', '.discount', function () {
                var discount = $('.discount').val() || 0;
                var total = $('#displaytotal').text();
                var maintotal = parseFloat(total.replace("$","").replace("₹","").replace(",","")) || 0;
                
                if(discount <= maintotal){
                    $( "#discount_hidden" ).val(discount);
                }else{
                    $( "#discount_hidden" ).val(maintotal);
                }
                
                $.ajax({
                    url: "{{route('cartdiscount')}}",
                    method: 'POST',
                    data: { discount: discount },
                    success: function (data) {
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
            });

            // Variant Selection
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
                        url: '{{ route("get.products.variant.quantity") }}',
                        data: {
                            "_token": $('meta[name="csrf-token"]').attr('content'),
                            variants: variants.join(' : '),
                            product_id: $('#product_id').val()
                        },
                        success: function(data) {
                            if (data.variant_id == 0) {
                                $('.variant_stock1').addClass('d-none');
                                $('.variation_price1').html('Please Select Variants');
                            } else {
                                var qty = 'Price : '  + data.price;
                                var amount = 'QTY : ' + data.quantity;
                                $('.variation_price1').html(qty);
                                $('#variant_id').val(data.variant_id);
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
                    url: '{{ route("addToCartVariant", ["__product_id", "session_key", "variation_id"]) }}'
                        .replace('__product_id', id).replace('session_key', session_key).replace('variation_id', variation_ids ?? 0),
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
                            
                            var targetId = '#product-variant-id-' + data.product.variant_id;
                            if ($(targetId).length > 0) {
                                $(targetId + ' input[name="quantity"]').val(data.product.quantity);
                            } else {
                                $('#tbody').append(data.carthtml);
                            }
                            
                            $('.no-found').addClass('d-none');
                            $('#btn-pur button').removeAttr('disabled');
                            $('#btn-make-payment').removeAttr('disabled');
                            $('.btn-empty button').addClass('btn-clear-cart');
                            show_toastr('Success', "{{ __('Product variant added to cart.') }}", 'success');
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
        });
    </script>
@endpush
