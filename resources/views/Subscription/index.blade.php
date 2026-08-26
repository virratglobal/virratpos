@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Subscriber') }}
@endsection

@section('content')
@php
    $totalSubs = $subs->count();
    $newThisMonth = $subs->where('created_at', '>=', now()->startOfMonth())->count();
@endphp

<style>
    /* DataTables specific overrides for a clean SaaS aesthetic */
    .dataTables_wrapper {
        padding: 0 1.5rem 1.5rem 1.5rem;
    }
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 1rem;
    }
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        color: #111827;
        outline: none;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        transition: all 0.2s;
        margin-left: 0.5rem;
    }
    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
    }
    .dataTables_wrapper .dataTables_length {
        margin-bottom: 1rem;
        color: #6b7280;
        font-size: 0.875rem;
    }
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.375rem 2rem 0.375rem 0.75rem;
        font-size: 0.875rem;
        color: #111827;
        background-color: #fff;
        margin: 0 0.5rem;
    }
    .dataTables_wrapper .dataTables_paginate {
        padding-top: 1.25rem;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.375rem 0.75rem;
        margin-left: 0.25rem;
        border-radius: 0.5rem;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #374151 !important;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.disabled) {
        background: #f9fafb !important;
        border-color: #d1d5db;
        color: #111827 !important;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #4f46e5 !important;
        color: #fff !important;
        border-color: #4f46e5;
        font-weight: 500;
    }
    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .dataTables_wrapper .dataTables_info {
        font-size: 0.875rem;
        color: #6b7280;
        padding-top: 1.25rem;
    }
    table.dataTable.no-footer {
        border-bottom: 1px solid #f3f4f6;
    }
</style>

<x-ui.page-container>
    <!-- Modern SaaS Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight" style="font-family: 'Geist', sans-serif;">
                {{ __('Subscriber') }}
            </h1>
            <p class="text-sm text-gray-500 mt-1 mb-2">{{ __('Manage your store subscribers and email contacts.') }}</p>
            <nav class="flex items-center text-sm text-gray-500 space-x-2 font-medium" style="font-family: 'Inter', sans-serif;">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">{{ __('Home') }}</a>
                <span class="text-gray-300">/</span>
                <span class="text-gray-400 cursor-default">{{ __('Products') }}</span>
                <span class="text-gray-300">/</span>
                <span class="text-gray-900">{{ __('Subscribers') }}</span>
            </nav>
        </div>
        
        <div class="mt-4 sm:mt-0">
            @can('Create Subscriber')
                <button data-url="{{ route('subscriptions.create') }}" data-title="{{ __('Add Subscriber') }}" data-ajax-popup="true" class="inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm hover:shadow transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    {{ __('Add Subscriber') }}
                </button>
            @endcan
        </div>
    </div>

    <!-- KPI Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">
        <!-- Total Subscribers -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Total Subscribers') }}</h3>
                <div class="w-9 h-9 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <i class="ti ti-users text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-3xl font-bold text-gray-900">{{ $totalSubs }}</div>
        </div>
        
        <!-- New This Month -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('New This Month') }}</h3>
                <div class="w-9 h-9 rounded-full bg-green-50 flex items-center justify-center text-green-600">
                    <i class="ti ti-user-plus text-lg"></i>
                </div>
            </div>
            <div class="mt-3 text-3xl font-bold text-gray-900">{{ $newThisMonth }}</div>
        </div>

        <!-- Subscriber List Info Card -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition-shadow flex flex-col justify-center">
            <div class="flex items-center">
                <div class="w-9 h-9 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 mr-3">
                    <i class="ti ti-mail text-lg"></i>
                </div>
                <div>
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Subscriber List') }}</h3>
                    <div class="mt-0.5 text-base font-semibold text-gray-900">{{ __('Email Contacts') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    @if($subs->isEmpty())
        <!-- Professional Empty State -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center flex flex-col items-center justify-center">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-5">
                <i class="ti ti-mail text-4xl text-gray-300"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ __('No subscribers yet') }}</h3>
            <p class="text-base text-gray-500 mb-8 max-w-md mx-auto">{{ __('Your subscriber list will appear here when customers subscribe to your store.') }}</p>
            @can('Create Subscriber')
                <button data-url="{{ route('subscriptions.create') }}" data-title="{{ __('Add Subscriber') }}" data-ajax-popup="true" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-sm font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm hover:shadow transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    {{ __('Add Subscriber') }}
                </button>
            @endcan
        </div>
    @else
        <!-- Modern Data Table -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <!-- Custom Toolbar Header -->
            <div class="px-6 py-5 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between bg-white relative z-10">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">{{ __('Subscribers') }}</h2>
                    <p class="text-sm text-gray-500 mt-0.5">{{ __('Manage and review your store\'s subscriber list.') }}</p>
                </div>
            </div>
            
            <div class="overflow-x-auto pt-4">
                <table class="w-full text-left border-collapse dataTable">
                    <thead>
                        <tr class="bg-gray-50/50">
                            <th scope="col" class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-y border-gray-100 sort" data-sort="email">{{ __('Email') }}</th>
                            <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider border-y border-gray-100 text-right w-32">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 bg-white">
                        @foreach ($subs as $sub)
                            <tr class="hover:bg-gray-50/80 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-gray-50 border border-gray-100 flex items-center justify-center mr-3 text-gray-400">
                                            <i class="ti ti-mail"></i>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900">{{ $sub->email }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity">
                                        @can('Delete Subscriber')
                                            <a href="#" class="bs-pass-para text-gray-400 hover:text-red-600 bg-white hover:bg-red-50 border border-gray-200 hover:border-red-200 rounded-lg p-2 transition-colors"
                                                data-title="{{ __('Delete Subscriber') }}"
                                                data-confirm="{{ __('Are You Sure?') }}"
                                                data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                data-confirm-yes="delete-form-{{ $sub->id }}"
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="{{ __('Delete') }}">
                                                <i class="ti ti-trash f-18"></i>
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['subscriptions.destroy', $sub->id], 'id' => 'delete-form-' . $sub->id, 'class' => 'd-none']) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</x-ui.page-container>
@endsection
