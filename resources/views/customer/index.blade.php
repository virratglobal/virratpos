@extends('layouts.ui-admin')

@section('page-title', __('Store Customers'))

@php
    $customer_avatar = \App\Models\Utility::get_file('uploads/customerprofile/');
@endphp

@section('content')
<x-ui.page-container>
    
    <x-ui.page-header title="{{ __('Store Customers') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Store Customers') }}</span>
        </x-slot>

        <x-slot name="actions">
            <div class="flex items-center space-x-2">
                <a href="{{ route('customer.export') }}">
                    <x-ui.button variant="secondary" title="{{ __('Export') }}">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Export
                    </x-ui.button>
                </a>
            </div>
        </x-slot>
    </x-ui.page-header>

    @if (count($customers) > 0)
        <x-ui.table>
            <x-slot name="head">
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Customer') }}</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Email') }}</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Phone No') }}</th>
                <th scope="col" class="relative px-6 py-3"><span class="sr-only">{{ __('Action') }}</span></th>
            </x-slot>

            <x-slot name="body">
                @foreach ($customers as $customer)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <a href="{{$customer_avatar}}/{{$customer->avatar}}" target="_blank">
                                        <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="{{$customer_avatar}}/{{$customer->avatar}}" alt="{{ $customer->name }}">
                                    </a>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $customer->name }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $customer->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $customer->phone_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                @can('Show Customers')
                                    <a href="{{ route('customer.show', $customer->id) }}" class="text-gray-400 hover:text-primary-600" title="{{ __('View') }}">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-ui.table>
    @else
        <x-ui.card>
            <x-ui.empty-state 
                title="{{ __('No customers found') }}" 
                description="{{ __('Customers will appear here when they register or place an order.') }}"
            >
                <x-slot name="icon">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </x-slot>
            </x-ui.empty-state>
        </x-ui.card>
    @endif

</x-ui.page-container>
@endsection
