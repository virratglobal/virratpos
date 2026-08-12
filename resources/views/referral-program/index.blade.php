@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Referral Program') }}
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('css/summernote/summernote-bs4.css') }}">
@endpush

@section('content')
    <x-ui.page-container>
        <div class="flex items-center justify-between mb-8 mt-4">
            <div class="flex flex-col gap-1 relative z-10">
                <h1 style="font-family: 'Geist', sans-serif; font-size: 1.5rem; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('Referral Program') }}</h1>
                <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #767586; margin-top: 4px; max-width: 42rem;">{{ __('Manage referral settings, payouts, and view all referral transactions.') }}</p>
            </div>
        </div>

        <div class="flex flex-col gap-6 lg:flex-row">
            <!-- Sidebar Navigation -->
            <div class="w-full lg:w-1/4">
                <x-ui.card class="sticky top-6 overflow-hidden">
                    <nav class="flex flex-col p-2 space-y-1" id="useradd-sidenav">
                        <a href="#transaction" data-tab="transaction" class="tab-link flex items-center justify-between px-4 py-3 text-sm font-medium transition-colors rounded-lg" style="background-color: #e5eeff; color: #4648d4;">
                            {{ __('Transaction') }}
                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </a>
                        <a href="#payout-request" data-tab="payout-request" class="tab-link flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-700 transition-colors rounded-lg hover:bg-gray-50 hover:text-gray-900">
                            {{ __('Payout Request') }}
                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </a>
                        <a href="#settings" data-tab="settings" class="tab-link flex items-center justify-between px-4 py-3 text-sm font-medium text-gray-700 transition-colors rounded-lg hover:bg-gray-50 hover:text-gray-900">
                            {{ __('Settings') }}
                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </a>
                    </nav>
                </x-ui.card>
            </div>

            <!-- Main Content Area -->
            <div class="w-full lg:w-3/4">
                
                <!-- Transaction Tab -->
                <div id="transaction" class="tab-content">
                    <x-ui.card class="overflow-hidden">
                        <div class="px-6 py-4 border-b" style="border-color: #dce9ff;">
                            <h5 style="font-family: 'Geist', sans-serif; font-size: 20px; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('Transaction') }}</h5>
                        </div>
                        <div class="overflow-x-auto">
                            <x-ui.table>
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase" style="color: #767586; font-family: 'Geist', sans-serif;">#</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Owner Name') }}</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Referral Owner') }}</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Plan Name') }}</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Plan Price') }}</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Commission (%)') }}</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Commission Amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @php
                                        $settings = Utility::getAdminPaymentSetting();
                                        $currency = isset($settings['currency_symbol']) ? $settings['currency_symbol'] : '$';
                                    @endphp
                                    @foreach($transactions as $key => $transaction)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ ++$key }}</td>
                                            @php
                                                $owner = \App\Models\User::where('type','Owner')->where('referral_code',$transaction->referral_code)->first();
                                            @endphp
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">{{ !empty($owner->name) ? $owner->name : '-'}}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ !empty($transaction->getUser) ? $transaction->getUser->name : '-' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ !empty($transaction->getPlan) ? $transaction->getPlan->name : '-' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $currency . $transaction->plan_price }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $transaction->commission ? $transaction->commission : '' }}</td>
                                            <td class="px-6 py-4 text-sm font-medium text-green-600 whitespace-nowrap">{{ $currency . ($transaction->plan_price * $transaction->commission) / 100 }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </x-ui.table>
                        </div>
                    </x-ui.card>
                </div>

                <!-- Payout Request Tab -->
                <div id="payout-request" class="hidden tab-content">
                    <x-ui.card class="overflow-hidden">
                        <div class="px-6 py-4 border-b" style="border-color: #dce9ff;">
                            <h5 style="font-family: 'Geist', sans-serif; font-size: 20px; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('Payout Request') }}</h5>
                        </div>
                        <div class="overflow-x-auto">
                            <x-ui.table>
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase" style="color: #767586; font-family: 'Geist', sans-serif;">#</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Owner Name') }}</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Requested Date')}}</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Requested Amount') }}</th>
                                        <th class="px-6 py-3 text-xs font-medium tracking-wider text-left uppercase" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($payRequests as $key => $transaction)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{( ++ $key)}}</td>
                                            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">{{ !empty( $transaction->getCompany) ? $transaction->getCompany->name : '-'}}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $transaction->date }}</td>
                                            <td class="px-6 py-4 text-sm font-medium text-green-600 whitespace-nowrap">{{ $currency . $transaction->req_amount }}</td>
                                            <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{route('amount.request',[$transaction->id,1])}}" class="text-green-600 hover:text-green-900 p-1.5 rounded hover:bg-green-50 transition-colors" title="{{ __('Approve') }}">
                                                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                                    </a>
                                                    <a href="{{route('amount.request',[$transaction->id,0])}}" class="text-red-600 hover:text-red-900 p-1.5 rounded hover:bg-red-50 transition-colors" title="{{ __('Reject') }}">
                                                        <span class="material-symbols-outlined text-[18px]">cancel</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </x-ui.table>
                        </div>
                    </x-ui.card>
                </div>

                <!-- Settings Tab -->
                <div id="settings" class="hidden tab-content">
                    {{ Form::open(['route' => 'referral-program.store', 'method' => 'POST', 'enctype' => 'multipart/form-data','class'=>'needs-validation','novalidate']) }}
                    <x-ui.card class="overflow-hidden">
                        <div class="flex flex-col items-center justify-between px-6 py-4 border-b border-gray-200 lg:flex-row gap-y-4" style="border-color: #dce9ff;">
                            <h5 style="font-family: 'Geist', sans-serif; font-size: 20px; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('Settings') }}</h5>
                            <div class="flex items-center space-x-3">
                                <label for="is_enable" class="text-sm font-medium text-gray-700">{{__('Enable')}}</label>
                                <div class="relative inline-block w-10 mr-2 align-middle select-none">
                                    <input type="checkbox" name="is_enable" id="is_enable" class="absolute block w-6 h-6 transition-all duration-200 ease-in-out bg-white border-4 appearance-none rounded-full cursor-pointer focus:outline-none is_enable right-4 checked:right-0" style="border-color: #4648d4;" {{ isset($setting) && $setting->is_enable == '1' ? 'checked' : ''}}>
                                    <label for="is_enable" class="block h-6 overflow-hidden bg-gray-300 rounded-full cursor-pointer transition-colors duration-200 toggle-label"></label>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="space-y-6 referral-settings">
                                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                    <div>
                                        <label for="percentage" class="block text-sm font-medium text-gray-700">{{ __('Commission Percentage (%)') }}<span class="text-red-500">*</span></label>
                                        <div class="mt-1">
                                            <input type="number" name="percentage" id="percentage" value="{{ isset($setting) ? $setting->percentage : '' }}" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm" placeholder="{{ __('Enter Commission Percentage') }}" min="0" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="minimum_threshold_amount" class="block text-sm font-medium text-gray-700">{{ __('Minimum Threshold Amount') }}<span class="text-red-500">*</span></label>
                                        <div class="flex mt-1 rounded-md shadow-sm">
                                            <span class="inline-flex items-center px-3 text-sm text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50">{{ $currency }}</span>
                                            <input type="number" name="minimum_threshold_amount" id="minimum_threshold_amount" value="{{ isset($setting) ? $setting->minimum_threshold_amount : '' }}" class="flex-1 block w-full border-gray-300 rounded-none focus:ring-primary-500 focus:border-primary-500 rounded-r-md sm:text-sm" placeholder="{{ __('Enter Minimum Payout') }}" min="0" required>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label for="guideline" class="block mb-2 text-sm font-medium text-gray-700">{{ __('GuideLines') }}<span class="text-red-500">*</span></label>
                                    <textarea name="guideline" class="summernote-simple">{{isset($setting) ? $setting->guideline : ''}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 border-t text-right rounded-b-lg" style="border-color: #dce9ff;">
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors border border-transparent rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2" style="background-color: #4648d4;">
                                {{ __('Save Changes') }}
                            </button>
                        </div>
                    </x-ui.card>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </x-ui.page-container>
@endsection

@push('scripts')
    <script src="{{ asset('css/summernote/summernote-bs4.js') }}"></script>
    <script>
        // Custom Tailwind Toggle for checkbox visual state
        $('.is_enable').on('change', function() {
            if($(this).is(':checked')) {
                $(this).addClass('checked:right-0');
                $(this).next('label').css('background-color', '#4648d4');
            } else {
                $(this).next('label').css('background-color', '');
            }
        });
        // Run once on load
        if($('.is_enable').is(':checked')) {
            $('.is_enable').next('label').css('background-color', '#4648d4');
        }

        // Tab Switching Logic
        $('.tab-link').on('click', function (e) {
            e.preventDefault();
            var tabId = $(this).data('tab');
            
            // Hide all tabs
            $('.tab-content').addClass('hidden');
            // Show selected tab
            $('#' + tabId).removeClass('hidden');

            // Reset all link styles
            $('.tab-link').removeAttr('style').addClass('text-gray-700 hover:bg-gray-50 hover:text-gray-900');
            // Style active link
            $(this).removeClass('text-gray-700 hover:bg-gray-50 hover:text-gray-900').css({
                'background-color': '#e5eeff',
                'color': '#4648d4'
            });
        });

        if ($('.is_enable').is(':checked')) {
            $('.referral-settings').removeClass('opacity-50 pointer-events-none');
        } else {
            $('.referral-settings').addClass('opacity-50 pointer-events-none');
        }

        $('.is_enable').on('change', function() {
            if ($('.is_enable').is(':checked')) {
                $('.referral-settings').removeClass('opacity-50 pointer-events-none');
            } else {
                $('.referral-settings').addClass('opacity-50 pointer-events-none');
            }
        });
    </script>
@endpush
