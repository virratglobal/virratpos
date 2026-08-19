@extends('layouts.ui-admin')

@section('page-title', __('Store Analytics'))

@section('content')
<x-ui.page-container>
    
    <x-ui.page-header title="{{ __('Store Analytics') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Store Analytics') }}</span>
        </x-slot>
    </x-ui.page-header>

    @php
        $current_store_id = \Auth::user()->current_store;
        $total_visitors = $visitor_url->sum('total');
        $total_orders = \App\Models\Order::where('user_id', $current_store_id)->count();
        $total_revenue = \App\Models\Order::where('user_id', $current_store_id)->sum('price');
        $conversion_rate = $total_visitors > 0 ? number_format(($total_orders / $total_visitors) * 100, 2) : '0.00';
    @endphp

    <!-- 1. KPI Cards Row (Grid: 4 cols) -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
        <!-- KPI Card 1: Visitors -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Visitors') }}</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($total_visitors) }}</h3>
                <span class="text-[11px] text-indigo-600 font-medium bg-indigo-50 px-2 py-0.5 rounded-full">{{ __('All time traffic') }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">visibility</span>
            </div>
        </div>

        <!-- KPI Card 2: Orders -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Orders') }}</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ number_format($total_orders) }}</h3>
                <span class="text-[11px] text-purple-600 font-medium bg-purple-50 px-2 py-0.5 rounded-full">{{ __('Completed orders') }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">shopping_bag</span>
            </div>
        </div>

        <!-- KPI Card 3: Revenue -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Revenue') }}</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ \App\Models\Utility::priceFormat($total_revenue) }}</h3>
                <span class="text-[11px] text-blue-600 font-medium bg-blue-50 px-2 py-0.5 rounded-full">{{ __('Gross earnings') }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">payments</span>
            </div>
        </div>

        <!-- KPI Card 4: Conversion Rate -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex items-center justify-between">
            <div class="space-y-1">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">{{ __('Conversion Rate') }}</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $conversion_rate }}%</h3>
                <span class="text-[11px] text-rose-600 font-medium bg-rose-50 px-2 py-0.5 rounded-full">{{ __('Visitor conversion') }}</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                <span class="material-symbols-outlined text-2xl">trending_up</span>
            </div>
        </div>
    </div>

    <!-- 2. Visitors Line Chart (Full Width) -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">{{ __('Visitor Analytics') }}</h3>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($total_visitors) }} <span class="text-xs font-medium text-slate-400 ml-1">{{ __('Total Visits') }}</span></p>
            </div>
            <div class="text-xs text-slate-400 bg-slate-100 px-2.5 py-1 rounded-lg font-medium">
                {{ __('Last 15 Days') }}
            </div>
        </div>
        <div id="Analytics" class="w-full"></div>
    </div>

    <!-- 3. Second Row (Top URLs [4 cols] | Platform [8 cols]) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
        
        <!-- Left: Top URLs (col-span-4) -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-slate-200 shadow-sm flex flex-col overflow-hidden">
            <div class="p-5 border-b border-slate-100 shrink-0">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">{{ __('Top URLs') }}</h3>
            </div>
            <div class="flex-grow overflow-x-auto">
                @if(count($visitor_url) > 0)
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 font-semibold uppercase">
                                <th class="px-5 py-3">{{ __('URL') }}</th>
                                <th class="px-5 py-3 text-right">{{ __('Views') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach ($visitor_url as $url)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-5 py-3 text-indigo-600 truncate max-w-[200px]" title="{{ $url->url }}">
                                        <a href="{{ $url->url }}" target="_blank" class="hover:underline">{{ $url->url }}</a>
                                    </td>
                                    <td class="px-5 py-3 text-right font-medium text-slate-700">
                                        {{ number_format($url->total) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center text-slate-400 h-full">
                        <span class="material-symbols-outlined text-4xl mb-2 text-slate-300">link</span>
                        <p class="text-sm font-semibold">{{ __('No URL Data Available') }}</p>
                        <p class="text-xs text-slate-400 max-w-[200px] mt-1">{{ __('Data will appear here once your store receives traffic.') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Platform (col-span-8) -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col">
            <div class="mb-4 shrink-0">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">{{ __('Platform') }}</h3>
            </div>
            <div class="flex-grow flex items-center justify-center">
                @if(count($platformarray['data']) > 0)
                    <div id="user-chart" class="w-full"></div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center text-slate-400 h-full">
                        <span class="material-symbols-outlined text-4xl mb-2 text-slate-300">bar_chart</span>
                        <p class="text-sm font-semibold">{{ __('No Platform Data Available') }}</p>
                        <p class="text-xs text-slate-400 max-w-[200px] mt-1">{{ __('Data will appear here once your store receives traffic.') }}</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

    <!-- 4. Third Row (Device [6 cols] | Browser [6 cols]) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Left: Device -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col">
            <div class="mb-4 shrink-0">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">{{ __('Device') }}</h3>
            </div>
            <div class="flex-grow flex items-center justify-center">
                @if(count($devicearray['data']) > 0)
                    <div id="WebKit" class="w-full"></div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center text-slate-400 h-full">
                        <span class="material-symbols-outlined text-4xl mb-2 text-slate-300">donut_large</span>
                        <p class="text-sm font-semibold">{{ __('No Device Data Available') }}</p>
                        <p class="text-xs text-slate-400 max-w-[200px] mt-1">{{ __('Data will appear here once your store receives traffic.') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Browser -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-col">
            <div class="mb-4 shrink-0">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">{{ __('Browser') }}</h3>
            </div>
            <div class="flex-grow flex items-center justify-center">
                @if(count($browserarray['data']) > 0)
                    <div id="Safari" class="w-full"></div>
                @else
                    <div class="flex flex-col items-center justify-center py-12 text-center text-slate-400 h-full">
                        <span class="material-symbols-outlined text-4xl mb-2 text-slate-300">browser_updated</span>
                        <p class="text-sm font-semibold">{{ __('No Browser Data Available') }}</p>
                        <p class="text-xs text-slate-400 max-w-[200px] mt-1">{{ __('Data will appear here once your store receives traffic.') }}</p>
                    </div>
                @endif
            </div>
        </div>

    </div>

</x-ui.page-container>
@endsection

@push('script-page')
    <script>
        (function () {
            var options = {
                chart: {
                    height: 280,
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
                    name: "{{ __('Referral') }}",
                    data: {!! json_encode($chartData['data']) !!}
                }, {
                    name: "{{ __('Organic Search') }}",
                    data: {!! json_encode($chartData['unique_data']) !!}
                }],
                xaxis: {
                    categories: {!! json_encode($chartData['label']) !!},
                    labels: {
                        style: {
                            colors: '#64748b',
                            fontSize: '11px',
                            fontFamily: 'Inter, sans-serif'
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                colors: ['#584ED2', '#818cf8'],
                grid: {
                    strokeDashArray: 4,
                    show: true,
                    borderColor: '#f1f5f9',
                },
                legend: {
                    show: true,
                    position: 'top',
                    horizontalAlign: 'right',
                    fontSize: '11px',
                    fontFamily: 'Inter, sans-serif'
                },
                yaxis: {
                    tickAmount: 4,
                    labels: {
                        style: {
                            colors: '#64748b',
                            fontSize: '11px',
                            fontFamily: 'Inter, sans-serif'
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.15,
                        opacityTo: 0.02,
                        stops: [0, 90, 100]
                    }
                }
            };
            var chart = new ApexCharts(document.querySelector("#Analytics"), options);
            chart.render();
        })();

        @if(count($platformarray['data']) > 0)
        (function () {
            var options = {
                chart: {
                    type: 'bar',
                    height: 260,
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false,
                },
                plotOptions: {
                    bar: {
                        columnWidth: '35%',
                        borderRadius: 4
                    }
                },
                series: [{
                    name: "{{ __('Platform') }}",
                    data: {!! json_encode($platformarray['data']) !!},
                }],
                colors: ['#584ED2'],
                xaxis: {
                    labels: {
                        style: {
                            colors: '#64748b',
                            fontSize: '11px',
                            fontFamily: 'Inter, sans-serif'
                        },
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    categories: {!! json_encode($platformarray['label']) !!},
                },
                yaxis: {
                    tickAmount: 4,
                    labels: {
                        style: {
                            colors: '#64748b',
                            fontSize: '11px',
                            fontFamily: 'Inter, sans-serif'
                        }
                    },
                },
                grid: {
                    strokeDashArray: 4,
                    show: true,
                    borderColor: '#f1f5f9',
                }
            };
            var chart = new ApexCharts(document.querySelector("#user-chart"), options);
            chart.render();
        })();
        @endif

        @if(count($devicearray['data']) > 0)
        (function () {
            var options = {
                series: {!! json_encode($devicearray['data']) !!},
                chart: {
                    height: 260,
                    type: 'donut',
                    width: '100%'
                },
                colors: ["#584ED2", "#818cf8", "#a5b4fc", "#cbd5e1", "#e2e8f0"],
                labels: {!! json_encode($devicearray['label']) !!},
                legend: {
                    position: 'bottom',
                    fontSize: '11px',
                    fontFamily: 'Inter, sans-serif'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            height: 220
                        }
                    }
                }]
            };
            var chart = new ApexCharts(document.querySelector("#WebKit"), options);
            chart.render();
        })();
        @endif

        @if(count($browserarray['data']) > 0)
        (function () {
            var options = {
                series: {!! json_encode($browserarray['data']) !!},
                chart: {
                    height: 260,
                    type: 'donut',
                    width: '100%'
                },
                colors: ["#584ED2", "#818cf8", "#a5b4fc", "#cbd5e1", "#e2e8f0"],
                labels: {!! json_encode($browserarray['label']) !!},
                legend: {
                    position: 'bottom',
                    fontSize: '11px',
                    fontFamily: 'Inter, sans-serif'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            height: 220
                        }
                    }
                }]
            };
            var chart = new ApexCharts(document.querySelector("#Safari"), options);
            chart.render();
        })();
        @endif
    </script>
@endpush
