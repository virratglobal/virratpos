@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Store Customers') }}
@endsection

@php
    $store_id = \Auth::user()->current_store;
    $storeCustomersIds = $customers->pluck('id')->toArray();

    // Stats calculations using real database data
    $totalCustomers = $customers->count();

    if ($totalCustomers > 0) {
        $activeCustomers = \App\Models\Order::where('user_id', $store_id)
            ->whereIn('customer_id', $storeCustomersIds)
            ->distinct('customer_id')
            ->count('customer_id');

        $totalCustomerValue = \App\Models\Order::where('user_id', $store_id)
            ->whereIn('customer_id', $storeCustomersIds)
            ->sum('price');

        $customerStats = \App\Models\Order::where('user_id', $store_id)
            ->whereIn('customer_id', $storeCustomersIds)
            ->selectRaw('customer_id, count(*) as order_count, sum(price) as total_spent, max(created_at) as last_order_date')
            ->groupBy('customer_id')
            ->get()
            ->keyBy('customer_id');
    } else {
        $activeCustomers = 0;
        $totalCustomerValue = 0;
        $customerStats = collect();
    }

    $newThisMonth = $customers->filter(function($c) {
        return $c->created_at && $c->created_at->format('Y-m') === date('Y-m');
    })->count();

    $customer_avatar = \App\Models\Utility::get_file('uploads/customerprofile/');
@endphp

@section('content')
<x-ui.page-container>

    {{-- ===================== PAGE HEADER ===================== --}}
    <div style="display: flex; flex-direction: column; gap: 4px; margin-bottom: 28px;">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div>
                <h1 style="font-family: 'Geist', sans-serif; font-size: 1.5rem; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">
                    {{ __('Store Customers') }}
                </h1>
                <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586; margin: 4px 0 0;">
                    {{ __('Manage your store customers, contact details and purchase activity.') }}
                </p>
            </div>
            <a href="{{ route('customer.export') }}" style="text-decoration: none;">
                <button type="button"
                        style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; background: #e5eeff; color: #4648d4; border: none; border-radius: 10px; font-family: 'Geist', sans-serif; font-size: 13px; font-weight: 500; cursor: pointer; letter-spacing: 0.01em; transition: background 0.2s;"
                        onmouseover="this.style.background='#dce9ff'" onmouseout="this.style.background='#e5eeff'">
                    <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    {{ __('Export') }}
                </button>
            </a>
        </div>
    </div>

    {{-- ===================== STAT CARDS ===================== --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5" style="margin-bottom: 28px;">

        {{-- Total Customers --}}
        <div style="background: #fff; border: 1px solid rgba(199,196,215,0.2); border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 16px; box-shadow: 0 1px 8px rgba(0,0,0,0.04);">
            <div style="width: 44px; height: 44px; border-radius: 10px; background: #eff0fe; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <span class="material-symbols-outlined" style="font-size: 22px; color: #4648d4;">group</span>
            </div>
            <div>
                <p style="font-family: 'Geist', sans-serif; font-size: 22px; font-weight: 700; color: #0b1c30; margin: 0; line-height: 1.1;">{{ $totalCustomers }}</p>
                <p style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586; margin: 3px 0 0; letter-spacing: 0.01em;">{{ __('Total Customers') }}</p>
            </div>
        </div>

        {{-- Active Customers --}}
        <div style="background: #fff; border: 1px solid rgba(199,196,215,0.2); border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 16px; box-shadow: 0 1px 8px rgba(0,0,0,0.04);">
            <div style="width: 44px; height: 44px; border-radius: 10px; background: #e8f5e9; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <span class="material-symbols-outlined" style="font-size: 22px; color: #1a7431;">person_play</span>
            </div>
            <div>
                <p style="font-family: 'Geist', sans-serif; font-size: 22px; font-weight: 700; color: #0b1c30; margin: 0; line-height: 1.1;">{{ $activeCustomers }}</p>
                <p style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586; margin: 3px 0 0; letter-spacing: 0.01em;">{{ __('Active Customers') }}</p>
            </div>
        </div>

        {{-- New This Month --}}
        <div style="background: #fff; border: 1px solid rgba(199,196,215,0.2); border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 16px; box-shadow: 0 1px 8px rgba(0,0,0,0.04);">
            <div style="width: 44px; height: 44px; border-radius: 10px; background: #fff3e0; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <span class="material-symbols-outlined" style="font-size: 22px; color: #904900;">calendar_today</span>
            </div>
            <div>
                <p style="font-family: 'Geist', sans-serif; font-size: 22px; font-weight: 700; color: #0b1c30; margin: 0; line-height: 1.1;">{{ $newThisMonth }}</p>
                <p style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586; margin: 3px 0 0; letter-spacing: 0.01em;">{{ __('New This Month') }}</p>
            </div>
        </div>

        {{-- Total Customer Value --}}
        <div style="background: #fff; border: 1px solid rgba(199,196,215,0.2); border-radius: 12px; padding: 20px; display: flex; align-items: center; gap: 16px; box-shadow: 0 1px 8px rgba(0,0,0,0.04);">
            <div style="width: 44px; height: 44px; border-radius: 10px; background: #e0f2f1; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <span class="material-symbols-outlined" style="font-size: 22px; color: #00796b;">payments</span>
            </div>
            <div>
                <p style="font-family: 'Geist', sans-serif; font-size: 22px; font-weight: 700; color: #0b1c30; margin: 0; line-height: 1.1;">{{ \App\Models\Utility::priceFormat($totalCustomerValue) }}</p>
                <p style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586; margin: 3px 0 0; letter-spacing: 0.01em;">{{ __('Total Value') }}</p>
            </div>
        </div>

    </div>

    {{-- ===================== CUSTOMERS CONTAINER CARD ===================== --}}
    <div style="background: #fff; border: 1px solid rgba(199,196,215,0.2); border-radius: 14px; box-shadow: 0 1px 8px rgba(0,0,0,0.04); overflow: hidden;">

        {{-- Card Header: Title + Toolbar --}}
        <div style="padding: 18px 24px; border-bottom: 1px solid rgba(199,196,215,0.15); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
            <div>
                <h2 style="font-family: 'Geist', sans-serif; font-size: 15px; font-weight: 600; color: #0b1c30; margin: 0; letter-spacing: -0.01em;">
                    {{ __('Customers') }}
                </h2>
                <p style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586; margin: 2px 0 0;">
                    {{ __('View and manage customers registered with your store.') }}
                </p>
            </div>

            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                {{-- Search Input --}}
                <div style="position: relative;">
                    <span class="material-symbols-outlined" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); font-size: 16px; color: #a0a0b0; pointer-events: none;">search</span>
                    <input
                        type="text"
                        id="customers-search-input"
                        placeholder="{{ __('Search name, email, phone...') }}"
                        style="padding: 8px 12px 8px 34px; border: 1px solid rgba(199,196,215,0.4); border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 13px; color: #0b1c30; outline: none; width: 220px; transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='#4648d4'" onblur="this.style.borderColor='rgba(199,196,215,0.4)'"
                    >
                </div>

                {{-- Status Filter --}}
                <select id="customers-status-filter"
                    style="padding: 8px 12px; border: 1px solid rgba(199,196,215,0.4); border-radius: 8px; font-family: 'Inter', sans-serif; font-size: 13px; color: #464554; background: #fff; outline: none; cursor: pointer; transition: border-color 0.2s;"
                    onfocus="this.style.borderColor='#4648d4'" onblur="this.style.borderColor='rgba(199,196,215,0.4)'">
                    <option value="all">{{ __('All Status') }}</option>
                    <option value="active">{{ __('Active') }}</option>
                </select>
            </div>
        </div>

        {{-- Table or Empty State --}}
        @if($customers->isEmpty())
            {{-- Empty State --}}
            <div style="text-align: center; padding: 64px 24px;">
                <div style="width: 64px; height: 64px; background: #eff0fe; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                    <span class="material-symbols-outlined" style="font-size: 32px; color: #4648d4;">group</span>
                </div>
                <h3 style="font-family: 'Geist', sans-serif; font-size: 16px; font-weight: 600; color: #0b1c30; margin: 0 0 8px;">
                    {{ __('No customers yet') }}
                </h3>
                <p style="font-family: 'Inter', sans-serif; font-size: 14px; color: #767586; margin: 0; max-width: 380px; margin-left: auto; margin-right: auto;">
                    {{ __('Customers will appear here when they register or place an order.') }}
                </p>
            </div>
        @else
            {{-- Table --}}
            <div style="overflow-x: auto;">
                <table class="table" style="width: 100%; border-collapse: collapse; min-width: 720px;">
                    <thead>
                        <tr style="border-bottom: 1px solid rgba(199,196,215,0.2);">
                            <th style="padding: 12px 24px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #767586; text-transform: uppercase; letter-spacing: 0.07em; text-align: left; background: #fafafa; white-space: nowrap;">
                                {{ __('Customer') }}
                            </th>
                            <th style="padding: 12px 24px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #767586; text-transform: uppercase; letter-spacing: 0.07em; text-align: left; background: #fafafa; white-space: nowrap;">
                                {{ __('Contact') }}
                            </th>
                            <th style="padding: 12px 24px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #767586; text-transform: uppercase; letter-spacing: 0.07em; text-align: center; background: #fafafa; white-space: nowrap;">
                                {{ __('Orders') }}
                            </th>
                            <th style="padding: 12px 24px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #767586; text-transform: uppercase; letter-spacing: 0.07em; text-align: right; background: #fafafa; white-space: nowrap;">
                                {{ __('Total Spent') }}
                            </th>
                            <th style="padding: 12px 24px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #767586; text-transform: uppercase; letter-spacing: 0.07em; text-align: left; background: #fafafa; white-space: nowrap;">
                                {{ __('Last Order') }}
                            </th>
                            <th style="padding: 12px 24px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #767586; text-transform: uppercase; letter-spacing: 0.07em; text-align: left; background: #fafafa; white-space: nowrap;">
                                {{ __('Status') }}
                            </th>
                            <th style="padding: 12px 24px; font-family: 'Inter', sans-serif; font-size: 11px; font-weight: 600; color: #767586; text-transform: uppercase; letter-spacing: 0.07em; text-align: right; background: #fafafa; white-space: nowrap;">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody id="customers-table-body">
                        @foreach ($customers as $customer)
                            @php
                                $stats = $customerStats->get($customer->id);
                                $orderCount = $stats ? $stats->order_count : 0;
                                $totalSpent = $stats ? $stats->total_spent : 0;
                                $lastOrderDate = $stats && $stats->last_order_date ? date('M d, Y', strtotime($stats->last_order_date)) : '—';

                                // Initials for Avatar Fallback
                                $words = explode(' ', trim($customer->name));
                                $initials = '';
                                foreach ($words as $w) {
                                    $initials .= strtoupper(substr($w, 0, 1));
                                }
                                $initials = substr($initials, 0, 2);
                                if (empty($initials)) {
                                    $initials = strtoupper(substr($customer->email, 0, 2));
                                }

                                // Custom Avatar colors mapped to customer ID
                                $bgColors = ['#eff0fe', '#e8f5e9', '#fff3e0', '#efebe9', '#f3e5f5', '#e1f5fe'];
                                $textColors = ['#4648d4', '#1a7431', '#904900', '#4e342e', '#6a1b9a', '#0277bd'];
                                $colorIndex = $customer->id % count($bgColors);
                                $bgColor = $bgColors[$colorIndex];
                                $textColor = $textColors[$colorIndex];
                            @endphp
                            <tr class="customers-row"
                                data-search-name="{{ strtolower($customer->name) }}"
                                data-search-email="{{ strtolower($customer->email) }}"
                                data-search-phone="{{ strtolower($customer->phone_number) }}"
                                style="border-bottom: 1px solid rgba(199,196,215,0.12); transition: background 0.15s;"
                                onmouseover="this.style.background='#fafbff'" onmouseout="this.style.background='transparent'">

                                {{-- Customer profile & basic details --}}
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        @if(!empty($customer->avatar) && file_exists(public_path('uploads/customerprofile/' . $customer->avatar)))
                                            <a href="{{ $customer_avatar }}/{{ $customer->avatar }}" target="_blank" style="flex-shrink: 0; display: block; border-radius: 50%; overflow: hidden; border: 1.5px solid rgba(199,196,215,0.3);">
                                                <img src="{{ $customer_avatar }}/{{ $customer->avatar }}" alt="{{ $customer->name }}" style="width: 36px; height: 36px; object-fit: cover;">
                                            </a>
                                        @else
                                            <div style="width: 36px; height: 36px; border-radius: 50%; background: {{ $bgColor }}; color: {{ $textColor }}; display: flex; align-items: center; justify-content: center; font-family: 'Geist', sans-serif; font-size: 12px; font-weight: 600; flex-shrink: 0; border: 1.5px solid rgba(199,196,215,0.15);">
                                                {{ $initials }}
                                            </div>
                                        @endif
                                        <div>
                                            <p style="font-family: 'Geist', sans-serif; font-size: 14px; font-weight: 600; color: #0b1c30; margin: 0; white-space: nowrap;">
                                                {{ $customer->name }}
                                            </p>
                                            <p style="font-family: 'Inter', sans-serif; font-size: 12px; color: #767586; margin: 2px 0 0; white-space: nowrap;">
                                                {{ $customer->email }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                {{-- Contact Phone --}}
                                <td style="padding: 16px 24px; vertical-align: middle; white-space: nowrap;">
                                    @if(!empty($customer->phone_number))
                                        <span style="font-family: 'Inter', sans-serif; font-size: 13px; color: #464554; display: inline-flex; align-items: center; gap: 4px;">
                                            <span class="material-symbols-outlined" style="font-size: 14px; color: #a0a0b0;">call</span>
                                            {{ $customer->phone_number }}
                                        </span>
                                    @else
                                        <span style="font-family: 'Inter', sans-serif; font-size: 13px; color: #b0afc0; font-style: italic;">
                                            {{ __('No phone') }}
                                        </span>
                                    @endif
                                </td>

                                {{-- Orders Count --}}
                                <td style="padding: 16px 24px; vertical-align: middle; text-align: center; white-space: nowrap;">
                                    <span style="font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 600; color: #0b1c30; background: #f1f2fe; padding: 4px 10px; border-radius: 12px;">
                                        {{ $orderCount }}
                                    </span>
                                </td>

                                {{-- Total Spent --}}
                                <td style="padding: 16px 24px; vertical-align: middle; text-align: right; white-space: nowrap; font-family: 'Geist', sans-serif; font-size: 14px; font-weight: 600; color: #0b1c30;">
                                    {{ \App\Models\Utility::priceFormat($totalSpent) }}
                                </td>

                                {{-- Last Order Date --}}
                                <td style="padding: 16px 24px; vertical-align: middle; white-space: nowrap; font-family: 'Inter', sans-serif; font-size: 13px; color: #464554;">
                                    {{ $lastOrderDate }}
                                </td>

                                {{-- Status (Active) --}}
                                <td style="padding: 16px 24px; vertical-align: middle; white-space: nowrap;">
                                    <span style="display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 20px; background: #e8f5e9; color: #1a7431; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: 500;">
                                        <span style="width: 6px; height: 6px; border-radius: 50%; background: #1a7431; display: inline-block;"></span>
                                        {{ __('Active') }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td style="padding: 16px 24px; vertical-align: middle;">
                                    <div style="display: flex; align-items: center; justify-content: flex-end; gap: 6px;">
                                        @can('Show Customers')
                                            <a href="{{ route('customer.show', $customer->id) }}"
                                               title="{{ __('View') }}"
                                               style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; border-radius: 8px; background: #eff0fe; color: #4648d4; text-decoration: none; transition: background 0.15s;"
                                               onmouseover="this.style.background='#e2e3fd'" onmouseout="this.style.background='#eff0fe'">
                                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- No search results --}}
                <div id="customers-no-results" style="display: none; text-align: center; padding: 48px 24px;">
                    <span class="material-symbols-outlined" style="font-size: 40px; color: #c7c4d7; display: block; margin-bottom: 12px;">search_off</span>
                    <p style="font-family: 'Inter', sans-serif; font-size: 14px; color: #767586; margin: 0;">{{ __('No customers match your search.') }}</p>
                </div>
            </div>
        @endif
    </div>

</x-ui.page-container>
@endsection

@push('script-page')
<script>
    (function () {
        var searchInput = document.getElementById('customers-search-input');
        var statusFilter = document.getElementById('customers-status-filter');
        var noResults = document.getElementById('customers-no-results');

        function filterCustomers() {
            var query = searchInput ? searchInput.value.toLowerCase().trim() : '';
            var rows = document.querySelectorAll('.customers-row');
            var shown = 0;

            rows.forEach(function (row) {
                var name = (row.getAttribute('data-search-name') || '').toLowerCase();
                var email = (row.getAttribute('data-search-email') || '').toLowerCase();
                var phone = (row.getAttribute('data-search-phone') || '').toLowerCase();

                var matchSearch = query === '' ||
                                  name.includes(query) ||
                                  email.includes(query) ||
                                  phone.includes(query);

                // All registered store customers are Active
                var matchStatus = true;

                if (matchSearch && matchStatus) {
                    row.style.display = '';
                    shown++;
                } else {
                    row.style.display = 'none';
                }
            });

            if (noResults) {
                noResults.style.display = (shown === 0 && rows.length > 0) ? 'block' : 'none';
            }
        }

        if (searchInput) searchInput.addEventListener('input', filterCustomers);
        if (statusFilter) statusFilter.addEventListener('change', filterCustomers);
    })();
</script>
@endpush
