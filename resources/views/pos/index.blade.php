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
    /* Prevent page-level scrollbar, constrain POS to viewport height */
    .pos-workspace-container {
        height: calc(100vh - 160px) !important;
        display: flex !important;
        gap: 16px !important;
        width: 100% !important;
        overflow: hidden !important;
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
    #product-listing .card {
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
    #product-listing .card:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05) !important;
        border-color: #4648d4 !important;
    }
    #product-listing .card-image {
        aspect-ratio: 1 / 1 !important;
        height: auto !important;
        object-fit: cover !important;
        width: 100% !important;
        border-bottom: 1px solid #e2e8f0 !important;
        background-color: #f8fafc !important;
    }
    #product-listing .card-image[src*="default.jpg"] {
        object-fit: contain !important;
        padding: 12px !important;
    }
    #product-listing .card-body,
    #product-listing .custom-card-body {
        padding: 12px !important;
        display: flex !important;
        flex-direction: column !important;
        flex-grow: 1 !important;
        align-items: flex-start !important;
        text-align: left !important;
        justify-content: flex-end !important;
    }
    #product-listing .product-title-name {
        font-family: 'Inter', sans-serif !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #1e293b !important;
        margin-bottom: 2px !important;
        line-height: 1.4 !important;
        width: 100% !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    #product-listing .text-primary {
        color: #4648d4 !important;
        font-family: 'Inter', sans-serif !important;
        font-weight: 700 !important;
        font-size: 14px !important;
        margin-top: 4px !important;
    }
    #product-listing .top-badge.badge {
        position: absolute !important;
        top: 8px !important;
        right: 8px !important;
        left: auto !important;
        z-index: 10 !important;
        background-color: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(4px) !important;
        color: #4648d4 !important;
        border: 1px solid rgba(70, 72, 212, 0.15) !important;
        font-size: 10px !important;
        font-weight: 700 !important;
        padding: 4px 8px !important;
        border-radius: 6px !important;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
    }

    /* Category pills horizontal list */
    #categories-listing {
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
        padding: 6px 16px !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 12px !important;
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
    .search-input-wrp input#searchproduct {
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
    .carttable-scroll {
        flex-grow: 1 !important;
        overflow-y: auto !important;
    }
    
    /* Cart table custom styles */
    .carttable table {
        width: 100% !important;
        border-collapse: collapse !important;
        margin: 0 !important;
    }
    .carttable th,
    .carttable td {
        padding: 10px 12px !important;
        font-size: 13px !important;
        vertical-align: middle !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }
    .carttable th {
        font-size: 12px !important;
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
        height: 26px !important;
    }
    .quantity.buttons_added input[type="button"] {
        background-color: #f8fafc !important;
        border: none !important;
        color: #64748b !important;
        width: 22px !important;
        height: 26px !important;
        font-size: 13px !important;
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
        width: 28px !important;
        height: 26px !important;
        padding: 0 !important;
        margin: 0 !important;
        border: none !important;
        border-left: 1px solid #cbd5e1 !important;
        border-right: 1px solid #cbd5e1 !important;
        text-align: center !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #0f172a !important;
        background: #ffffff !important;
        outline: none !important;
        box-shadow: none !important;
        line-height: 26px !important;
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

    <!-- Two-Panel POS Workspace -->
    <div class="pos-workspace-container">
        
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
            
            <!-- 1. Quick Action Header Row -->
            <div class="flex items-center justify-between pb-1 shrink-0">
                <div class="flex gap-2 flex-wrap">
                    <a href="{{ route('product.index') }}" class="px-3.5 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-semibold flex items-center gap-1.5 border border-indigo-100 hover:bg-indigo-100 transition-colors text-decoration-none">
                        <i class="ti ti-building-store text-sm"></i> {{ __('Product List') }}
                    </a>
                    <a href="{{ route('orders.index') }}" class="px-3.5 py-2 bg-purple-50 text-purple-600 rounded-lg text-xs font-semibold flex items-center gap-1.5 border border-purple-100 hover:bg-purple-100 transition-colors text-decoration-none">
                        <i class="ti ti-chart-bar text-sm"></i> {{ __('Today Sales') }}
                    </a>
                    <button type="button" class="px-3.5 py-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-semibold flex items-center gap-1.5 border border-blue-100 hover:bg-blue-100 transition-colors cursor-pointer" onclick="alert('Calculator widget coming soon')">
                        <i class="ti ti-calculator text-sm"></i> {{ __('Calculator') }}
                    </button>
                    <a href="{{ route('dashboard') }}" class="px-3.5 py-2 bg-rose-50 text-rose-600 rounded-lg text-xs font-semibold flex items-center gap-1.5 border border-rose-100 hover:bg-rose-100 transition-colors text-decoration-none">
                        <i class="ti ti-home text-sm"></i> {{ __('Dashboard') }}
                    </a>
                </div>
            </div>

            <!-- 2. Main Cart/Billing card container -->
            <div class="pos-billing-card">
                
                <!-- Order Info Grid Row (Customer, Date, Invoice, Warehouse) -->
                <div class="p-4 border-b border-slate-100 flex flex-col gap-3 shrink-0">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-slate-500 mb-1 block">{{ __('Select Customer') }}</label>
                            <div class="flex gap-2">
                                <div class="flex-grow">
                                    {{ Form::select('customer_id',$customers,'', array('class' => 'form-control select customer_select','id'=>'customer','required'=>'required')) }}
                                </div>
                                <button type="button" class="w-10 h-[38px] bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg flex items-center justify-center border-none cursor-pointer transition-colors" onclick="window.location.href='{{ route('customer.index') }}'">
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

                <!-- Cart table body (scrollable) -->
                @php $total = 0 @endphp
                <div class="flex-grow overflow-y-auto custom-scrollbar carttable-scroll" id="carthtml">
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
                <div class="border-t border-slate-100 bg-slate-50 shrink-0">
                    <div class="p-4 grid grid-cols-12 gap-4">
                        <!-- Left Side Inputs (Payment Info) -->
                        <div class="col-span-7 space-y-2">
                            <div class="flex items-center justify-between gap-3">
                                <label class="text-xs font-semibold text-slate-500 w-28 shrink-0">{{ __('Receive Amount') }}</label>
                                <input type="number" class="flex-grow min-w-0 form-control" placeholder="$0.00" value="0">
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <label class="text-xs font-semibold text-slate-500 w-28 shrink-0">{{ __('Change Amount') }}</label>
                                <input type="text" class="flex-grow min-w-0 form-control bg-slate-100" value="$0.00" readonly>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <label class="text-xs font-semibold text-slate-500 w-28 shrink-0">{{ __('Due Amount') }}</label>
                                <input type="text" class="flex-grow min-w-0 form-control bg-slate-100" value="$0.00" readonly>
                            </div>
                            <div class="flex items-center justify-between gap-3">
                                <label class="text-xs font-semibold text-slate-500 w-28 shrink-0">{{ __('Payment Type') }}</label>
                                <select class="flex-grow min-w-0 form-control">
                                    <option value="Cash">{{ __('Cash') }}</option>
                                    <option value="Card">{{ __('Card') }}</option>
                                    <option value="Bank Transfer">{{ __('Bank Transfer') }}</option>
                                </select>
                            </div>
                            <div class="flex items-start justify-between gap-3">
                                <label class="text-xs font-semibold text-slate-500 w-28 shrink-0 pt-2">{{ __('Note') }}</label>
                                <textarea class="flex-grow min-w-0 form-control resize-none h-12" placeholder="{{ __('Type note...') }}"></textarea>
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
                            <button type="button" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-bold shadow-sm transition-all border-none cursor-pointer" data-ajax-popup="true" data-size="xl" data-align="centered" data-url="{{route('pos.create')}}" data-title="{{__('POS Invoice')}}" @if(session($lastsegment) && !empty(session($lastsegment)) && count(session($lastsegment)) > 0) @else disabled="disabled" @endif>
                                {{ __('MAKE PAYMENT') }}
                            </button>
                        @endcan
                    </div>
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
