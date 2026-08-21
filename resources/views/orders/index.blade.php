@extends('layouts.ui-admin')

@section('page-title', __('Orders'))

@php
    $user = \Auth::user()->currentuser();
    $plan = \App\Models\Plan::find($user->plan);
    $isStorageLimitReached = ($plan->storage_limit <= $user->storage_limit && $plan->storage_limit != -1);
    
    $store_id = \Auth::user()->current_store;
    $summary_total_orders = \App\Models\Order::where('user_id', $store_id)->count();
    $summary_pending_orders = \App\Models\Order::where('user_id', $store_id)->where('status', 'pending')->count();
    $summary_completed_orders = \App\Models\Order::where('user_id', $store_id)->where('status', '!=', 'pending')->where('status', '!=', 'Cancel Order')->count();
    $summary_total_revenue = \App\Models\Order::where('user_id', $store_id)->sum('price');
@endphp

@section('content')
<x-ui.page-container>
    
    <x-ui.page-header title="{{ __('Orders') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900 text-slate-500 text-xs text-decoration-none">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-1.5 h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium text-xs">{{ __('Orders') }}</span>
        </x-slot>

        <x-slot name="actions">
            <a href="{{ route('order.export') }}" class="text-decoration-none">
                <button type="button" class="px-4 py-2 bg-white text-slate-700 rounded-lg text-xs font-semibold flex items-center gap-1.5 border border-slate-200 hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm cursor-pointer">
                    <span class="material-symbols-outlined text-base">download</span>
                    {{ __('Export') }}
                </button>
            </a>
        </x-slot>
    </x-ui.page-header>

    @if ($isStorageLimitReached)
        <div class="mb-6 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl">
            <div class="flex">
                <div class="flex-shrink-0">
                    <span class="material-symbols-outlined text-rose-500">warning</span>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-rose-700 font-medium m-0">
                        {{ __('Your plan storage limit is over, so you can not see customer uploaded payment receipt.') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <!-- Order Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
        <!-- Total Orders -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex items-center justify-between min-h-[120px]">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider m-0">{{ __('Total Orders') }}</p>
                <h3 class="text-2xl font-bold text-slate-800 m-0 mt-1">{{ number_format($summary_total_orders) }}</h3>
                <span class="text-[11px] text-indigo-600 font-medium bg-indigo-50 px-2 py-0.5 rounded-full mt-1.5 inline-block">{{ __('All time count') }}</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-xl">shopping_cart</span>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex items-center justify-between min-h-[120px]">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider m-0">{{ __('Pending') }}</p>
                <h3 class="text-2xl font-bold text-slate-800 m-0 mt-1">{{ number_format($summary_pending_orders) }}</h3>
                <span class="text-[11px] text-amber-600 font-medium bg-amber-50 px-2 py-0.5 rounded-full mt-1.5 inline-block">{{ __('Awaiting delivery') }}</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-xl">hourglass_empty</span>
            </div>
        </div>

        <!-- Completed Orders -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex items-center justify-between min-h-[120px]">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider m-0">{{ __('Completed') }}</p>
                <h3 class="text-2xl font-bold text-slate-800 m-0 mt-1">{{ number_format($summary_completed_orders) }}</h3>
                <span class="text-[11px] text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded-full mt-1.5 inline-block">{{ __('Shipped & Delivered') }}</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-xl">task_alt</span>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4 flex items-center justify-between min-h-[120px]">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider m-0">{{ __('Total Revenue') }}</p>
                <h3 class="text-2xl font-bold text-slate-800 m-0 mt-1">{{ \App\Models\Utility::priceFormat($summary_total_revenue) }}</h3>
                <span class="text-[11px] text-blue-600 font-medium bg-blue-50 px-2 py-0.5 rounded-full mt-1.5 inline-block">{{ __('Gross sales') }}</span>
            </div>
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-xl">payments</span>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-4">
        @if (count($orders) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 dataTable">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Order') }}</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Date') }}</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Customer') }}</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Products') }}</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Value') }}</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Payment') }}</th>
                            <th scope="col" class="px-5 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Status') }}</th>
                            <th scope="col" class="px-5 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @foreach ($orders as $order)
                            <tr class="order-row hover:bg-slate-50/50 transition-colors" data-status="{{ $order->status == 'Cancel Order' ? 'cancelled' : ($order->status == 'pending' ? 'pending' : 'completed') }}">
                                <!-- ORDER -->
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <a href="{{ route('orders.show', \Illuminate\Support\Facades\Crypt::encrypt($order->id)) }}" class="text-indigo-600 hover:text-indigo-900 font-bold font-mono text-sm text-decoration-none">
                                            {{ $order->order_id[0] == '#' ?  $order->order_id : '#' .$order->order_id }}
                                        </a>
                                        <span class="text-[10px] text-slate-400 font-semibold mt-0.5">{{ __('POS Order') }}</span>
                                    </div>
                                </td>
                                <!-- DATE -->
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-medium text-slate-700">{{ date('M d, Y', strtotime($order->created_at)) }}</span>
                                        <span class="text-[10px] text-slate-400 font-medium mt-0.5">{{ date('h:i A', strtotime($order->created_at)) }}</span>
                                    </div>
                                </td>
                                <!-- CUSTOMER -->
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center border border-slate-200">
                                            <span class="material-symbols-outlined text-sm">person</span>
                                        </div>
                                        <span class="text-xs font-semibold text-slate-700">{{ $order->name }}</span>
                                    </div>
                                </td>
                                <!-- PRODUCTS -->
                                <td class="px-5 py-3.5">
                                    @php
                                        $order_products = json_decode($order->product);
                                        $product_count = !empty($order_products) ? count((array)$order_products) : 0;
                                    @endphp
                                    <div class="flex items-center gap-1.5 flex-wrap">
                                        @if($product_count > 0)
                                            @php $idx = 0; @endphp
                                            @foreach($order_products as $prod_item)
                                                @if($idx < 2)
                                                    <div class="relative group flex items-center gap-1 border border-slate-100 rounded-lg p-1 bg-slate-50/50">
                                                        @if(!empty($prod_item->image))
                                                            <img src="{{ asset(Storage::url('uploads/is_cover_image/' . $prod_item->image)) }}" class="w-8 h-8 rounded-md object-cover" alt="" title="{{ $prod_item->product_name }}">
                                                        @else
                                                            <div class="w-8 h-8 rounded-md bg-slate-200 text-slate-500 flex items-center justify-center" title="{{ $prod_item->product_name }}">
                                                                <span class="material-symbols-outlined text-xs">image</span>
                                                            </div>
                                                        @endif
                                                        <div class="flex flex-col max-w-[80px]">
                                                            <span class="text-[10px] text-slate-600 font-medium truncate" title="{{ $prod_item->product_name }}">{{ $prod_item->product_name }}</span>
                                                            <span class="text-[9px] text-slate-400 font-semibold">×{{ $prod_item->quantity }}</span>
                                                        </div>
                                                    </div>
                                                @endif
                                                @php $idx++; @endphp
                                            @endforeach
                                            @if($product_count > 2)
                                                <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded-md">+{{ $product_count - 2 }}</span>
                                            @endif
                                        @else
                                            <span class="text-[11px] text-slate-400">-</span>
                                        @endif
                                    </div>
                                </td>
                                <!-- VALUE -->
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <span class="text-sm font-bold text-slate-800">{{ \App\Models\Utility::priceFormat($order->price) }}</span>
                                </td>
                                <!-- PAYMENT -->
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-semibold text-slate-700">{{ $order->payment_type }}</span>
                                        <span class="text-[10px] text-slate-400 font-medium mt-0.5">{{ $order->payment_status }}</span>
                                    </div>
                                </td>
                                <!-- STATUS -->
                                <td class="px-5 py-3.5 whitespace-nowrap">
                                    @if ($order->status == 'Cancel Order')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-100">
                                            {{ __('Cancelled') }}
                                        </span>
                                    @elseif ($order->status == 'pending')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600 border border-amber-100">
                                            {{ __('Pending') }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                            {{ __('Delivered') }}
                                        </span>
                                    @endif
                                </td>
                                <!-- ACTIONS -->
                                <td class="px-5 py-3.5 whitespace-nowrap text-right text-xs font-medium">
                                    <div class="flex justify-end items-center gap-1.5">
                                        @can('Show Orders')
                                            <a href="{{ route('orders.show', \Illuminate\Support\Facades\Crypt::encrypt($order->id)) }}" class="p-1.5 bg-slate-50 hover:bg-indigo-50 text-slate-400 hover:text-indigo-600 rounded-lg transition-colors border border-slate-100 text-decoration-none flex items-center justify-center" title="{{ __('View') }}">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                        @endcan
                                        @can('Delete Orders')
                                            <a href="#" class="p-1.5 bg-slate-50 hover:bg-rose-50 text-slate-400 hover:text-rose-600 rounded-lg transition-colors border border-slate-100 bs-pass-para text-decoration-none flex items-center justify-center"
                                                data-confirm="{{ __('Are You Sure?') }}"
                                                data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                data-confirm-yes="delete-form-{{ $order->id }}"
                                                title="{{ __('Delete') }}">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['orders.destroy', $order->id], 'id' => 'delete-form-' . $order->id, 'class' => 'hidden']) !!}
                                            {!! Form::close() !!}
                                        @endcan

                                        @if($order->payment_status == 'pending' && $order->payment_type == 'Bank Transfer')
                                            <a href="#" class="p-1.5 bg-slate-50 hover:bg-amber-50 text-slate-400 hover:text-amber-600 rounded-lg transition-colors border border-slate-100 text-decoration-none flex items-center justify-center"
                                                data-url="{{ route('bank_transfer.order.show',$order->id) }}"
                                                data-ajax-popup="true" data-size="lg"
                                                title="{{ __('Payment Status') }}">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="py-12 text-center text-slate-400">
                <span class="material-symbols-outlined text-5xl mb-2 text-slate-300">shopping_cart</span>
                <h4 class="text-sm font-bold text-slate-800 m-0">{{ __('No orders yet') }}</h4>
                <p class="text-xs text-slate-400 max-w-[280px] mx-auto mt-1">{{ __('Your orders will appear here once customers make purchases.') }}</p>
            </div>
        @endif
    </div>

</x-ui.page-container>
@endsection

@push('style')
<style>
    /* Styling simple-datatables layout to match modern SaaS styling */
    .dataTable-top {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 16px !important;
        padding: 0 0 16px 0 !important;
        flex-wrap: wrap !important;
    }
    .dataTable-dropdown {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #64748b !important;
    }
    .dataTable-selector {
        padding: 6px 32px 6px 12px !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        background-color: #fff !important;
        font-weight: 600 !important;
        color: #334155 !important;
        outline: none !important;
        cursor: pointer !important;
        transition: border-color 0.15s ease-in-out !important;
    }
    .dataTable-selector:focus {
        border-color: #584ED2 !important;
    }
    .dataTable-search {
        display: flex !important;
        align-items: center !important;
    }
    .dataTable-input {
        padding: 8px 16px !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        color: #334155 !important;
        width: 220px !important;
        outline: none !important;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out !important;
    }
    .dataTable-input:focus {
        border-color: #584ED2 !important;
        box-shadow: 0 0 0 3px rgba(88, 78, 210, 0.1) !important;
    }
    
    /* Table styling */
    .dataTable th {
        background-color: #f8fafc !important;
        border-bottom: 1px solid #e2e8f0 !important;
        font-size: 11px !important;
        font-weight: 600 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.05em !important;
        color: #64748b !important;
        padding: 12px 20px !important;
    }
    .dataTable td {
        padding: 14px 20px !important;
        vertical-align: middle !important;
    }
    .dataTable-bottom {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 16px 0 0 0 !important;
        font-size: 12px !important;
        font-weight: 500 !important;
        color: #64748b !important;
    }
    .dataTable-info {
        font-weight: 500 !important;
    }
    .dataTable-pagination ul {
        display: flex !important;
        list-style: none !important;
        padding: 0 !important;
        margin: 0 !important;
        gap: 4px !important;
    }
    .dataTable-pagination a {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 32px !important;
        height: 32px !important;
        border-radius: 8px !important;
        border: 1px solid #e2e8f0 !important;
        font-size: 12px !important;
        font-weight: 600 !important;
        color: #64748b !important;
        text-decoration: none !important;
        transition: all 0.15s ease-in-out !important;
    }
    .dataTable-pagination a:hover {
        background-color: #f8fafc !important;
        color: #334155 !important;
        border-color: #cbd5e1 !important;
    }
    .dataTable-pagination .active a {
        background-color: #584ED2 !important;
        color: #fff !important;
        border-color: #584ED2 !important;
    }
    .dataTable-pagination .disabled a {
        opacity: 0.5 !important;
        cursor: not-allowed !important;
        pointer-events: none !important;
    }
</style>
@endpush

@push('script-page')
<script>
    $(document).ready(function() {
        var checkExist = setInterval(function() {
            if ($('.dataTable-top').length) {
                clearInterval(checkExist);
                
                var statusFilterHtml = `
                    <div class="dataTable-status-filter flex items-center gap-1.5 ml-auto lg:ml-0">
                        <label class="text-xs font-semibold text-slate-500 uppercase tracking-wider m-0">{{ __('Status') }}:</label>
                        <select id="order-status-filter" class="px-2.5 py-1.5 bg-white border border-slate-200 rounded-lg text-xs font-semibold text-slate-700 outline-none focus:border-indigo-500 transition-colors cursor-pointer">
                            <option value="all">{{ __('All') }}</option>
                            <option value="pending">{{ __('Pending') }}</option>
                            <option value="completed">{{ __('Completed') }}</option>
                            <option value="cancelled">{{ __('Cancelled') }}</option>
                        </select>
                    </div>
                `;
                
                $('.dataTable-dropdown').after(statusFilterHtml);
                
                $('#order-status-filter').change(function() {
                    var selectedStatus = $(this).val();
                    $('.dataTable tbody tr').each(function() {
                        var rowStatus = $(this).attr('data-status');
                        if (selectedStatus === 'all' || rowStatus === selectedStatus) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                });
            }
        }, 100);
    });
</script>
@endpush
