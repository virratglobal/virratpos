@php

$logo=\App\Models\Utility::get_file('uploads/logo/');
$profile=\App\Models\Utility::get_file('uploads/profile/');
$logo1=\App\Models\Utility::get_file('uploads/is_cover_image/');
$setting = App\Models\Utility::settings();
$company_logo = \App\Models\Utility::getValByName('company_logo');
@endphp

@extends('layouts.ui-admin')
@section('page-title')
    {{ __('Dashboard') }}
@endsection

@section('breadcrumb')
    @if(\Auth::user()->type != 'super admin')
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('Home')}}</a></li>
    @endif
@endsection
@push('script-page')
    <script>
        var timezone = '{{ !empty($setting['timezone']) ? $setting['timezone'] : 'Asia/Kolkata' }}';

        let today = new Date(new Date().toLocaleString("en-US", {
            timeZone: timezone
        }));
        var curHr = today.getHours()
        var target = document.getElementById("greetings");

        if (curHr < 12) {
            target.innerHTML = "Good Morning,";
        } else if (curHr < 17) {
            target.innerHTML = "Good Afternoon,";
        } else {
            target.innerHTML = "Good Evening,";
        }

    </script>
    <script>
        $(document).on('click', '#code-generate', function() {
            var length = 10;
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            $('#auto-code').val(result);
        });
    </script>
@endpush
@section('content')
@if (\Auth::user()->type == 'super admin')

    <x-ui.page-container>
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 style="font-family: 'Geist', sans-serif; font-size: 1.5rem; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">
                    {{ __('Overview') }}
                </h1>
                <p style="font-family: 'Inter', sans-serif; font-size: 14px; color: #767586; margin-top: 4px;">
                    {{ __('Super Admin Dashboard') }}
                </p>
            </div>
            <a href="{{ route('dashboard') }}" class="btn btn-primary" style="display: flex; gap: 8px;">
                <span class="material-symbols-outlined" style="font-size: 18px;">refresh</span>
                {{ __('Refresh Data') }}
            </a>
        </div>

        <!-- 5 Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <!-- Active Plans -->
            <div style="background: #e5eeff; border-radius: 12px; padding: 24px; position: relative; overflow: hidden;" class="group">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 group-hover:scale-150" style="background: rgba(70,72,212,0.05);"></div>
                <div class="flex justify-between items-start mb-6">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #6063ee; color: #fffbff; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined">workspace_premium</span>
                    </div>
                </div>
                <div>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #464554; margin-bottom: 4px;">{{ __('Active Plans') }}</p>
                    <p style="font-family: 'Geist', sans-serif; font-size: 24px; font-weight: 600; color: #0b1c30; margin: 0;">{{ $user['active_plans'] }}</p>
                </div>
            </div>

            <!-- Pending Requests -->
            <div style="background: #e5eeff; border-radius: 12px; padding: 24px; position: relative; overflow: hidden;" class="group">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 group-hover:scale-150" style="background: rgba(70,72,212,0.05);"></div>
                <div class="flex justify-between items-start mb-6">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #6063ee; color: #fffbff; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined">pending_actions</span>
                    </div>
                </div>
                <div>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #464554; margin-bottom: 4px;">{{ __('Pending Requests') }}</p>
                    <p style="font-family: 'Geist', sans-serif; font-size: 24px; font-weight: 600; color: #0b1c30; margin: 0;">{{ $user['pending_requests'] }}</p>
                </div>
            </div>

            <!-- Monthly Growth -->
            <div style="background: #e5eeff; border-radius: 12px; padding: 24px; position: relative; overflow: hidden;" class="group">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 group-hover:scale-150" style="background: rgba(70,72,212,0.05);"></div>
                <div class="flex justify-between items-start mb-6">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #6063ee; color: #fffbff; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined">trending_up</span>
                    </div>
                    @if($user['monthly_growth'] >= 0)
                        <span style="background: #e6f6ec; color: #0f7636; padding: 4px 8px; border-radius: 16px; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                            <span class="material-symbols-outlined" style="font-size: 14px;">arrow_upward</span>
                            {{ $user['monthly_growth'] }}%
                        </span>
                    @else
                        <span style="background: #feeceb; color: #c01d14; padding: 4px 8px; border-radius: 16px; font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                            <span class="material-symbols-outlined" style="font-size: 14px;">arrow_downward</span>
                            {{ abs($user['monthly_growth']) }}%
                        </span>
                    @endif
                </div>
                <div>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #464554; margin-bottom: 4px;">{{ __('Monthly Growth') }}</p>
                    <p style="font-family: 'Geist', sans-serif; font-size: 24px; font-weight: 600; color: #0b1c30; margin: 0;">{{ $user['monthly_growth'] }}%</p>
                </div>
            </div>

            <!-- Total Stores -->
            <div style="background: #e5eeff; border-radius: 12px; padding: 24px; position: relative; overflow: hidden;" class="group">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 group-hover:scale-150" style="background: rgba(70,72,212,0.05);"></div>
                <div class="flex justify-between items-start mb-6">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #6063ee; color: #fffbff; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined">storefront</span>
                    </div>
                </div>
                <div>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #464554; margin-bottom: 4px;">{{ __('Total Stores') }}</p>
                    <p style="font-family: 'Geist', sans-serif; font-size: 24px; font-weight: 600; color: #0b1c30; margin: 0;">{{ $user->total_user }}</p>
                </div>
            </div>

            <!-- Total Revenue -->
            <div style="background: #e5eeff; border-radius: 12px; padding: 24px; position: relative; overflow: hidden;" class="group">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 group-hover:scale-150" style="background: rgba(70,72,212,0.05);"></div>
                <div class="flex justify-between items-start mb-6">
                    <div style="width: 48px; height: 48px; border-radius: 12px; background: #6063ee; color: #fffbff; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                </div>
                <div>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #464554; margin-bottom: 4px;">{{ __('Total Revenue') }}</p>
                    <p style="font-family: 'Geist', sans-serif; font-size: 24px; font-weight: 600; color: #0b1c30; margin: 0;">{{ \App\Models\Utility::priceFormat($user['total_plan_price']) }}</p>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="card mb-8">
            <div class="card-header border-b-0 pb-0">
                <h3 class="mb-0">{{ __('Recent Orders') }}</h3>
            </div>
            <div class="card-body">
                <div id="plan_order" data-color="primary" data-height="250"></div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <a class="card mb-0 hover:bg-surface-container-high transition-colors group flex-row items-center gap-4 p-6" href="{{ route('store-resource.index') }}" style="border-radius: 12px; cursor: pointer; text-decoration: none;">
                <div style="width: 48px; height: 48px; border-radius: 8px; background: #6063ee; color: #fffbff; display: flex; align-items: center; justify-content: center;" class="group-hover:scale-110 transition-transform flex-shrink-0">
                    <span class="material-symbols-outlined text-[24px]">business</span>
                </div>
                <div>
                    <h3 style="font-family: 'Geist', sans-serif; font-size: 16px; font-weight: 600; color: #0b1c30; margin: 0 0 4px;">{{ __('Company Management') }}</h3>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586; margin: 0;">{{ __('View and edit registered companies') }}</p>
                </div>
            </a>
            <a class="card mb-0 hover:bg-surface-container-high transition-colors group flex-row items-center gap-4 p-6" href="{{ route('plans.index') }}" style="border-radius: 12px; cursor: pointer; text-decoration: none;">
                <div style="width: 48px; height: 48px; border-radius: 8px; background: #dae2fd; color: #131b2e; display: flex; align-items: center; justify-content: center;" class="group-hover:scale-110 transition-transform flex-shrink-0">
                    <span class="material-symbols-outlined text-[24px]">subscriptions</span>
                </div>
                <div>
                    <h3 style="font-family: 'Geist', sans-serif; font-size: 16px; font-weight: 600; color: #0b1c30; margin: 0 0 4px;">{{ __('Plan Management') }}</h3>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586; margin: 0;">{{ __('Configure subscription tiers and pricing') }}</p>
                </div>
            </a>
            <a class="card mb-0 hover:bg-surface-container-high transition-colors group flex-row items-center gap-4 p-6" href="{{ route('coupons.index') }}" style="border-radius: 12px; cursor: pointer; text-decoration: none;">
                <div style="width: 48px; height: 48px; border-radius: 8px; background: #ffdcc5; color: #301400; display: flex; align-items: center; justify-content: center;" class="group-hover:scale-110 transition-transform flex-shrink-0">
                    <span class="material-symbols-outlined text-[24px]">local_activity</span>
                </div>
                <div>
                    <h3 style="font-family: 'Geist', sans-serif; font-size: 16px; font-weight: 600; color: #0b1c30; margin: 0 0 4px;">{{ __('Coupon Management') }}</h3>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586; margin: 0;">{{ __('Create and track promotional codes') }}</p>
                </div>
            </a>
        </div>
    </x-ui.page-container>

@else


    <!-- Header Section -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-[1.5rem] font-semibold text-gray-900" style="font-family: 'Geist', sans-serif; line-height: 40px; letter-spacing: -0.04em;">{{ __('Your overview') }}</h1>
        <div class="relative">
            <select class="appearance-none bg-white border border-gray-200 rounded-md py-1.5 pl-3 pr-8 text-sm font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                <option>{{ __('Lifetime') }}</option>
                <option>{{ __('Today') }}</option>
                <option>{{ __('Yesterday') }}</option>
                <option>{{ __('This Week') }}</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Total Sales Card -->
        <x-ui.card class="p-6">
            <div class="flex justify-between items-start mb-2">
                <div class="flex items-center text-sm font-medium text-gray-600">
                    {{ __('Total sales') }}
                    <svg class="w-4 h-4 ml-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                </div>
            </div>
            <div class="flex items-end justify-between mb-6">
                <h3 class="text-3xl font-bold text-gray-900">{{ \App\Models\Utility::priceFormat($totle_sale) }}</h3>
                <span class="text-sm text-gray-500 mb-1">{{ $totle_order }} {{ __('orders') }}</span>
            </div>
            
            <div class="h-24 w-full">
                <div id="traffic-chart" style="min-height: 100px;"></div>
            </div>
            
            <div class="mt-4 text-center">
                <a href="{{ route('orders.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-800">{{ __('View more') }} &rarr;</a>
            </div>
        </x-ui.card>

        <!-- Store Conversion Rate Card -->
        <x-ui.card class="p-6">
            <div class="flex justify-between items-start mb-2">
                <div class="flex items-center text-sm font-medium text-gray-600">
                    {{ __('Store conversion rate') }}
                    <svg class="w-4 h-4 ml-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>
                </div>
            </div>
            <div class="flex items-end justify-between mb-6">
                <h3 class="text-3xl font-bold text-gray-900">0%</h3>
                <span class="text-sm text-gray-500 mb-1">0 {{ __('sessions') }}</span>
            </div>
            
            <div class="h-24 w-full flex flex-col justify-end">
                <!-- Static placeholder chart lines for empty state -->
                <div class="border-t border-gray-100 flex items-end justify-between pb-1 text-xs text-gray-400"><span class="w-4 text-right">4</span></div>
                <div class="border-t border-gray-100 flex items-end justify-between pb-1 text-xs text-gray-400"><span class="w-4 text-right">3</span></div>
                <div class="border-t border-gray-100 flex items-end justify-between pb-1 text-xs text-gray-400"><span class="w-4 text-right">2</span></div>
                <div class="border-t border-gray-100 flex items-end justify-between pb-1 text-xs text-gray-400"><span class="w-4 text-right">1</span></div>
                <div class="border-t border-gray-200 mt-2 text-center text-xs text-gray-400 pt-1">
                    <div class="w-2 h-2 rounded-full bg-primary-600 mx-auto -mt-2"></div>
                    Aug 26
                </div>
            </div>
            
            <div class="mt-4 text-center">
                <a href="{{ route('storeanalytic') }}" class="text-sm font-medium text-primary-600 hover:text-primary-800">{{ __('View more') }} &rarr;</a>
            </div>
        </x-ui.card>

        <!-- Store Link & Quick Status -->
        <div class="flex flex-col space-y-4">
            <x-ui.card class="p-6">
                <div class="flex justify-between items-start mb-2">
                    <div class="text-sm font-medium text-gray-600">{{ __('Store link') }}</div>
                    <a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-800">{{ __('Link domain') }}</a>
                </div>
                <div class="flex items-center">
                    <a href="{{ $store_id['store_url'] ?? '' }}" target="_blank" class="text-sm text-orange-500 hover:text-orange-600 hover:underline flex items-center">
                        {{ $store_id['store_url'] ?? 'mydukaan.io/virrat' }}
                        <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </div>
            </x-ui.card>
            
            <!-- List items -->
            <x-ui.card class="py-2">
                <div class="divide-y divide-gray-100">
                    <a href="#" class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            <span class="text-sm text-gray-700 font-medium">{{ __('No new orders pending') }}</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="#" class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                            <span class="text-sm text-gray-700 font-medium">{{ __('No order to ship today') }}</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="#" class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span class="text-sm text-gray-700 font-medium">{{ __('No abandoned order') }}</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </x-ui.card>
        </div>
    </div>

    <!-- Shortcuts -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-900">{{ __('Shortcuts') }}</h2>
            <button class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
            </button>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            <a href="{{ route('product.create') }}" class="flex items-center justify-center p-6 border border-dashed border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-gray-600 bg-white">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span class="font-medium text-sm">{{ __('Add new shortcut') }}</span>
            </a>
        </div>
    </div>

@endif
@endsection
@push('script-page')
@if (\Auth::user()->type == 'super admin')
<script>
    (function() {
        var options = {
            chart: {
                height: 250,
                type: 'area',
                toolbar: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2,
                curve: 'smooth'
            },


            series: [{
                name: "{{ __('Order') }}",
                data: {!! json_encode($chartData['data']) !!}
            }],

            xaxis: {
                axisBorder: {
                    show: !1
                },
                type: "MMM",
                categories: {!! json_encode($chartData['label']) !!},
                title: {
                    text: '{{ __("Days") }}'
                }
            },
            colors: ['#e83e8c'],

            grid: {
                strokeDashArray: 4,
            },
            legend: {
                show: false,
            },
            // markers: {
            //     size: 4,
            //     colors: ['#FFA21D'],
            //     opacity: 0.9,
            //     strokeWidth: 2,
            //     hover: {
            //         size: 7,
            //     }
            // },
            yaxis: {
                tickAmount: 3,
                title: {
                text: '{{ __("Amount") }}'
            },
            }
        };
        var chart = new ApexCharts(document.querySelector("#plan_order"), options);
        chart.render();
    })();

</script>
@else
<script>
    $(document).ready(function() {
        $('.cp_link').on('click', function() {
            var value = $(this).attr('data-link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();
            show_toastr('Success', '{{ __('Link copied') }}', 'success')
        });
    });
    (function () {
        var options = {
            chart: {
                height: 250,
                type: 'area',
                toolbar: {
                    show: false,
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2,
                curve: 'smooth'
            },
            series: [{
                name: "{{ __('Order') }}",
                data: {!! json_encode($chartData['data']) !!}
            }],
            xaxis: {
                axisBorder: {
                    show: !1
                },
                type: "MMM",
                categories: {!! json_encode($chartData['label']) !!},
                title: {
                    text: '{{ __("Days") }}'
                }
            },
            colors: ['#ffa21d', '#FF3A6E'],

            grid: {
                strokeDashArray: 4,
            },
            legend: {
                show: false,
            },
            yaxis: {
                tickAmount: 3,
                title: {
                text: '{{ __("Amount") }}'
            },
            }
        };
        var chart = new ApexCharts(document.querySelector("#traffic-chart"), options);
        chart.render();
    })();


    (function () {
        var options = {
            series: [{{ round($storage_limit,2) }}],
            chart: {
                height: 600,
                type: 'radialBar',
                offsetY: -20,
                sparkline: {
                    enabled: true
                }
            },
            plotOptions: {
                radialBar: {
                    startAngle: -90,
                    endAngle: 90,
                    track: {
                        background: "#e7e7e7",
                        strokeWidth: '97%',
                        margin: 5, // margin is in pixels
                    },
                    dataLabels: {
                        name: {
                            show: true
                        },
                        value: {
                            offsetY: -50,
                            fontSize: '20px'
                        }
                    }
                }
            },
            grid: {
                padding: {
                    top: -10
                }
            },
            colors: ["#6FD943"],
            labels: ['Used'],
            responsive: [{
                breakpoint: 1300, // Maximum screen width for this rule
                options: {
                    chart: {
                        width: '100%',
                        height:'400px'// Set width to 100% for responsiveness
                    },
                    legend: {
                        position: 'bottom' // Position legend at the bottom
                    }
                },
                // breakpoint: 380, // Maximum screen width for this rule
                // options: {
                //     chart: {
                //         width: '100%',
                //         height:'300px'// Set width to 100% for responsiveness
                //     },
                //     legend: {
                //         position: 'bottom' // Position legend at the bottom
                //     }
                // },

            }]
        };
        var chart = new ApexCharts(document.querySelector("#device-chart"), options);
        chart.render();
    })();


    //social sharing
    $(document).ready(function() {
        var customURL = {!! json_encode(url('/store/' . $store_id->slug)) !!};
        $('.Demo1').socialSharingPlugin({
            url: customURL,
            title: $('meta[property="og:title"]').attr('content'),
            description: $('meta[property="og:description"]').attr('content'),
            img: $('meta[property="og:image"]').attr('content'),
            enable: ['whatsapp', 'facebook', 'twitter', 'pinterest', 'linkedin']
        });

        $('.socialShareButton').click(function(e) {
            e.preventDefault();
            $('.sharingButtonsContainer').toggle();
        });
    });
</script>
@endif
@endpush

