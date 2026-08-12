@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Referral Program') }}
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/summernote/summernote-bs4.css') }}">
@endpush

@section('content')
    <x-ui.page-container>
        <x-ui.page-header title="{{ __('Referral Program') }}">
        </x-ui.page-header>

        <div class="flex flex-col gap-6 lg:flex-row">
            <!-- Sidebar Navigation -->
            <div class="w-full lg:w-1/4">
                <x-ui.card class="sticky top-6">
                    <nav class="flex flex-col space-y-1" id="useradd-sidenav">
                        <a href="#guideline" data-tab="guideline" class="tab-link flex items-center justify-between px-4 py-3 text-sm font-medium transition-colors rounded-lg bg-primary-50 text-primary-700 hover:bg-primary-50 hover:text-primary-700">
                            {{ __('GuideLine') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                        <a href="#referral-transaction" data-tab="referral-transaction" class="tab-link flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-700 transition-colors rounded-lg hover:bg-gray-50 hover:text-gray-900">
                            {{ __('Referral Transaction') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                        <a href="#payout" data-tab="payout" class="tab-link flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-700 transition-colors rounded-lg hover:bg-gray-50 hover:text-gray-900">
                            {{ __('Payout') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </nav>
                </x-ui.card>
            </div>

            <!-- Main Content Area -->
            <div class="w-full lg:w-3/4">
                @php
                    $settings = Utility::getAdminPaymentSetting();
                    $currency = isset($settings['currency_symbol']) ? $settings['currency_symbol'] : '$';
                @endphp

                <!-- GuideLine Tab -->
                <div id="guideline" class="tab-content">
                    <x-ui.card>
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h5 class="text-lg font-medium text-gray-900">{{ __('GuideLine') }}</h5>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                                <div class="p-6 border-2 border-gray-200 rounded-xl bg-gray-50">
                                    <h4 class="mb-4 text-xl font-bold text-primary-600">{{ __('Refer ') . \Auth::user()->name . __(' and earn ') . $currency . (isset($setting) ? $setting->minimum_threshold_amount : '') . __(' per paid signup!') }}</h4>
                                    <div class="prose prose-sm max-w-none text-gray-700">
                                        {!! isset($setting) ? $setting->guideline : '' !!}
                                    </div>
                                </div>
                                <div class="flex flex-col justify-center">
                                    <h4 class="mb-4 text-xl font-bold text-center text-gray-900">{{ __('Share Your Link') }}</h4>
                                    <button class="cp_link flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-primary-700 bg-primary-50 border border-primary-200 rounded-lg hover:bg-primary-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors" data-link="{{ route('register', ['ref_id' => \Auth::user()->referral_code]) }}" title="{{ __('Click to copy referral link') }}">
                                        <span class="truncate mr-2">{{ route('register', ['ref' => \Auth::user()->referral_code]) }}</span>
                                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path></svg>
                                    </button>
                                    
                                    @if(isset($setting) && $setting->is_enable == 0 || !isset($setting))
                                        <div class="mt-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700">
                                            <p class="text-sm font-medium">{{ __('Note : super admin has disabled the referral program.') }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </x-ui.card>
                </div>

                <!-- Referral Transaction Tab -->
                <div id="referral-transaction" class="hidden tab-content">
                    <x-ui.card>
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h5 class="text-lg font-medium text-gray-900">{{ __('Referral Transaction') }}</h5>
                        </div>
                        <div class="overflow-x-auto">
                            <x-ui.table>
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">#</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">{{ __('Referral Owner') }}</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">{{ __('Plan Name') }}</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">{{ __('Plan Price') }}</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">{{ __('Commission (%)') }}</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">{{ __('Commission Amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @if(isset($setting))
                                        @foreach ($transactions as $key => $transaction)
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ ++$key }}</td>
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">{{ !empty($transaction->getUser) ? $transaction->getUser->name : '-' }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ !empty($transaction->getPlan) ? $transaction->getPlan->name : '-' }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $currency . $transaction->plan_price }}</td>
                                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $transaction->commission }}</td>
                                                <td class="px-6 py-4 text-sm font-medium text-green-600 whitespace-nowrap">{{ $currency . ($transaction->plan_price * $transaction->commission) / 100 }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </x-ui.table>
                        </div>
                    </x-ui.card>
                </div>

                <!-- Payout Tab -->
                <div id="payout" class="hidden space-y-6 tab-content">
                    <x-ui.card>
                        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200">
                            <h5 class="text-lg font-medium text-gray-900">{{ __('Payout') }}</h5>
                            @if (\Auth::user()->commission_amount > $paidAmount)
                                @if ($paymentRequest == null)
                                    <a href="#" data-url="{{ route('request.amount.sent', [$paidAmount]) }}" data-ajax-popup="true" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors border border-transparent rounded-md shadow-sm bg-primary-600 hover:bg-primary-700" data-title="{{ __('Send Request') }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                                        {{ __('Send Request') }}
                                    </a>
                                @else
                                    <a href="{{ route('request.amount.cancel', \Auth::user()->id) }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700" data-title="{{ __('Cancel Request') }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        {{ __('Cancel Request') }}
                                    </a>
                                @endif
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div class="flex items-center justify-between p-6 border border-gray-200 rounded-xl bg-gray-50">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-primary-100 text-primary-600">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-500">{{ __('Total') }}</p>
                                            <p class="text-lg font-bold text-gray-900">{{ __('Commission Amount') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-2xl font-bold text-primary-600">{{ $currency . \Auth::user()->commission_amount }}</div>
                                </div>

                                <div class="flex items-center justify-between p-6 border border-gray-200 rounded-xl bg-gray-50">
                                    <div class="flex items-center">
                                        <div class="flex items-center justify-center w-12 h-12 text-green-600 bg-green-100 rounded-lg">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-500">{{ __('Paid') }}</p>
                                            <p class="text-lg font-bold text-gray-900">{{ __('Commission Amount') }}</p>
                                        </div>
                                    </div>
                                    <div class="text-2xl font-bold text-green-600">{{ $currency . $paidAmount }}</div>
                                </div>
                            </div>
                        </div>
                    </x-ui.card>

                    <x-ui.card>
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h5 class="text-lg font-medium text-gray-900">{{ __('Payout History') }}</h5>
                        </div>
                        <div class="overflow-x-auto">
                            <x-ui.table>
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">#</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">{{ __('Owner Name') }}</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">{{ __('Requested Date') }}</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">{{ __('Status') }}</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">{{ __('Requested Amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($transactionsOrder as $key => $transaction)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ ++$key }}</td>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">{{ \Auth::user()->name }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $transaction->date }}</td>
                                            <td class="px-6 py-4 text-sm whitespace-nowrap">
                                                @if ($transaction->status == 0)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        {{ __(\App\Models\ReferralTransactionOrder::$status[$transaction->status]) }}
                                                    </span>
                                                @elseif($transaction->status == 1)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                        {{ __(\App\Models\ReferralTransactionOrder::$status[$transaction->status]) }}
                                                    </span>
                                                @elseif($transaction->status == 2)
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        {{ __(\App\Models\ReferralTransactionOrder::$status[$transaction->status]) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $currency . $transaction->req_amount }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </x-ui.table>
                        </div>
                    </x-ui.card>
                </div>
            </div>
        </div>
    </x-ui.page-container>
@endsection

@push('scripts')
    <script src="{{ asset('css/summernote/summernote-bs4.js') }}"></script>
    <script>
        $('.cp_link').on('click', function() {
            var value = $(this).attr('data-link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();
            
            // Replaced toastr with simple alert if toastr is not loaded, but show_toastr is standard here
            if (typeof show_toastr === 'function') {
                show_toastr('Success', '{{ __('Link Copy on Clipboard') }}', 'success');
            } else {
                alert('{{ __('Link Copy on Clipboard') }}');
            }
        });

        // Tab Switching Logic
        $('.tab-link').on('click', function (e) {
            e.preventDefault();
            var tabId = $(this).data('tab');
            
            // Hide all tabs
            $('.tab-content').addClass('hidden');
            // Show selected tab
            $('#' + tabId).removeClass('hidden');

            // Reset all link styles
            $('.tab-link').removeClass('bg-primary-50 text-primary-700').addClass('text-gray-700 hover:bg-gray-50 hover:text-gray-900');
            // Style active link
            $(this).removeClass('text-gray-700 hover:bg-gray-50 hover:text-gray-900').addClass('bg-primary-50 text-primary-700');
        });
    </script>
@endpush
