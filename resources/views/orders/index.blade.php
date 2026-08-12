@extends('layouts.ui-admin')

@section('page-title', __('Orders'))

@php
    $user = \Auth::user()->currentuser();
    $plan = \App\Models\Plan::find($user->plan);
    $isStorageLimitReached = ($plan->storage_limit <= $user->storage_limit && $plan->storage_limit != -1);
@endphp

@section('content')
<x-ui.page-container>
    
    <x-ui.page-header title="{{ __('Orders') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Orders') }}</span>
        </x-slot>

        <x-slot name="actions">
            <div class="flex items-center space-x-2">
                <a href="{{ route('order.export') }}">
                    <x-ui.button variant="secondary" title="{{ __('Export') }}">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Export
                    </x-ui.button>
                </a>
            </div>
        </x-slot>
    </x-ui.page-header>

    @if ($isStorageLimitReached)
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">
                        {{ __('Your plan storage limit is over, so you can not see customer uploaded payment receipt.') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if (count($orders) > 0)
        <x-ui.table>
            <x-slot name="head">
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Order ID') }}</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Date') }}</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Customer') }}</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Value') }}</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Payment Type') }}</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Receipt') }}</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                <th scope="col" class="relative px-6 py-3"><span class="sr-only">{{ __('Action') }}</span></th>
            </x-slot>

            <x-slot name="body">
                @foreach ($orders as $order)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('orders.show', \Illuminate\Support\Facades\Crypt::encrypt($order->id)) }}" class="text-primary-600 hover:text-primary-900 font-medium font-mono text-sm">
                                {{ $order->order_id[0] == '#' ?  $order->order_id : '#' .$order->order_id }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \App\Models\Utility::dateFormat($order->created_at) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $order->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \App\Models\Utility::priceFormat($order->price) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $order->payment_type }}
                            <div class="text-xs text-gray-400 mt-1">{{ $order->payment_status }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if ($isStorageLimitReached)
                                -
                            @else
                                @if ($order->payment_type == 'Bank Transfer' && $order->receipt)
                                    <a href="{{ asset(Storage::url($order->receipt)) }}" download class="text-primary-600 hover:text-primary-900" title="{{ __('Download Receipt') }}">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </a>
                                @else
                                    -
                                @endif
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($order->status == 'Cancel Order')
                                <x-ui.badge variant="danger">{{ __('Cancelled') }}</x-ui.badge>
                                <div class="text-xs text-gray-400 mt-1">{{ \App\Models\Utility::dateFormat($order->created_at) }}</div>
                            @elseif ($order->status == 'pending')
                                <x-ui.badge variant="warning">{{ __('Pending') }}</x-ui.badge>
                                <div class="text-xs text-gray-400 mt-1">{{ \App\Models\Utility::dateFormat($order->created_at) }}</div>
                            @else
                                <x-ui.badge variant="success">{{ __('Delivered') }}</x-ui.badge>
                                <div class="text-xs text-gray-400 mt-1">{{ \App\Models\Utility::dateFormat($order->updated_at) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end items-center space-x-2">
                                @can('Show Orders')
                                    <a href="{{ route('orders.show', \Illuminate\Support\Facades\Crypt::encrypt($order->id)) }}" class="text-gray-400 hover:text-primary-600" title="{{ __('View') }}">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                @endcan
                                @can('Delete Orders')
                                    <a href="#" class="text-gray-400 hover:text-red-600 bs-pass-para"
                                        data-confirm="{{ __('Are You Sure?') }}"
                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                        data-confirm-yes="delete-form-{{ $order->id }}"
                                        title="{{ __('Delete') }}">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['orders.destroy', $order->id], 'id' => 'delete-form-' . $order->id, 'class' => 'hidden']) !!}
                                    {!! Form::close() !!}
                                @endcan

                                @if($order->payment_status == 'pending' && $order->payment_type == 'Bank Transfer')
                                    <a href="#" class="text-gray-400 hover:text-primary-600"
                                        data-url="{{ route('bank_transfer.order.show',$order->id) }}"
                                        data-ajax-popup="true" data-size="lg"
                                        title="{{ __('Payment Status') }}">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-ui.table>
    @else
        <x-ui.card>
            <x-ui.empty-state 
                title="{{ __('No orders found') }}" 
                description="{{ __('Orders will appear here once received.') }}"
            >
                <x-slot name="icon">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </x-slot>
                <!-- Manual order creation button can be added here if supported by the backend -->
            </x-ui.empty-state>
        </x-ui.card>
    @endif

</x-ui.page-container>
@endsection
