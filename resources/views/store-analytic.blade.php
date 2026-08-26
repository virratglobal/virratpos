@extends('layouts.ui-admin')

@section('page-title', __('Store Analytics'))

@section('content')
<x-ui.page-container>
    
    <!-- Modern Header -->
    <div class="page-header flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-[#111827] tracking-tight" style="font-family: 'Geist', sans-serif;">
                {{ __('Store Analytics') }}
            </h1>
            <nav class="flex items-center text-[13px] text-[#6B7280] mt-1 space-x-2 font-medium" style="font-family: 'Inter', sans-serif;">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">{{ __('Home') }}</a>
                <span class="text-gray-300">/</span>
                <span class="text-[#111827]">{{ __('Store Analytics') }}</span>
            </nav>
        </div>
        <div class="mt-4 sm:mt-0 flex items-center bg-white border border-[#E8EAF0] rounded-xl shadow-sm px-4 py-2">
            <i class="ti ti-calendar text-[#6B7280] mr-2 text-[15px]"></i>
            <span class="text-[13px] font-semibold text-[#111827]">{{ __('Last 15 Days') }}</span>
        </div>
    </div>

    @php
        $current_store_id = \Auth::user()->current_store;
        $total_visitors = $visitor_url->sum('total');
        $total_orders = \App\Models\Order::where('user_id', $current_store_id)->count();
        $total_revenue = \App\Models\Order::where('user_id', $current_store_id)->sum('price');
        $conversion_rate = $total_visitors > 0 ? number_format(($total_orders / $total_visitors) * 100, 2) : '0.00';
        
        // Order status breakdown for Order Performance Card
        $order_statuses = \App\Models\Order::select('status', \DB::raw('count(*) as total'))
                                ->where('user_id', $current_store_id)
                                ->groupBy('status')
                                ->get();
                                
        // Helper to format average order value safely
        $aov = $total_orders > 0 ? $total_revenue / $total_orders : 0;
    @endphp

    <!-- 1. KPI Cards Row (Grid: 4 cols) -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 mb-5">
        <!-- KPI Card 1: Visitors -->
        <div class="bg-white rounded-2xl border border-[#E8EAF0] shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-[11px] font-semibold text-[#6B7280] uppercase tracking-wider">{{ __('Visitors') }}</h3>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i class="ti ti-users text-[15px]"></i>
                </div>
            </div>
            <h3 class="text-[28px] font-bold text-[#111827] mb-1">{{ number_format($total_visitors) }}</h3>
            <p class="text-[12px] font-medium text-[#6B7280]">{{ __('Total store visitors') }}</p>
        </div>

        <!-- KPI Card 2: Orders -->
        <div class="bg-white rounded-2xl border border-[#E8EAF0] shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-[11px] font-semibold text-[#6B7280] uppercase tracking-wider">{{ __('Orders') }}</h3>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i class="ti ti-shopping-cart text-[15px]"></i>
                </div>
            </div>
            <h3 class="text-[28px] font-bold text-[#111827] mb-1">{{ number_format($total_orders) }}</h3>
            <p class="text-[12px] font-medium text-[#6B7280]">{{ __('Completed orders') }}</p>
        </div>

        <!-- KPI Card 3: Revenue -->
        <div class="bg-white rounded-2xl border border-[#E8EAF0] shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-[11px] font-semibold text-[#6B7280] uppercase tracking-wider">{{ __('Revenue') }}</h3>
                <div class="w-8 h-8 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
                    <i class="ti ti-cash text-[15px]"></i>
                </div>
            </div>
            <h3 class="text-[28px] font-bold text-[#111827] mb-1">{{ \App\Models\Utility::priceFormat($total_revenue) }}</h3>
            <p class="text-[12px] font-medium text-[#6B7280]">{{ __('Gross revenue') }}</p>
        </div>

        <!-- KPI Card 4: Conversion Rate -->
        <div class="bg-white rounded-2xl border border-[#E8EAF0] shadow-sm p-5 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-[11px] font-semibold text-[#6B7280] uppercase tracking-wider">{{ __('Conversion Rate') }}</h3>
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i class="ti ti-trending-up text-[15px]"></i>
                </div>
            </div>
            <h3 class="text-[28px] font-bold text-[#111827] mb-1">{{ $conversion_rate }}%</h3>
            <p class="text-[12px] font-medium text-[#6B7280]">{{ __('Visitor conversion') }}</p>
        </div>
    </div>

    <!-- 2. Row 2: Main Analytics (8 cols) + Visitor Sources (4 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 mb-5">
        <!-- Store Performance -->
        <div class="lg:col-span-8 bg-white rounded-2xl border border-[#E8EAF0] shadow-sm p-5 flex flex-col h-[300px]">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-2 shrink-0">
                <div>
                    <h2 class="text-[15px] font-bold text-[#111827]">{{ __('Store Performance') }}</h2>
                    <p class="text-[12px] text-[#6B7280] mt-0.5">{{ __('Visitor trends over the last 15 days') }}</p>
                </div>
            </div>
            <div class="flex-grow w-full relative">
                <div id="Analytics" class="w-full h-full"></div>
            </div>
        </div>

        <!-- Visitor Sources (Platform) -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-[#E8EAF0] shadow-sm p-5 flex flex-col h-[300px]">
            <div class="mb-2 shrink-0">
                <h3 class="text-[15px] font-bold text-[#111827]">{{ __('Visitor Sources') }}</h3>
                <p class="text-[12px] text-[#6B7280] mt-0.5">{{ __('Visits by platform') }}</p>
            </div>
            <div class="flex-grow flex flex-col justify-center">
                @if(count($platformarray['data']) > 0)
                    <div id="PlatformChart" class="w-full flex justify-center items-center h-[140px]"></div>
                    <div class="mt-3 grid grid-cols-2 gap-2 px-1 shrink-0">
                        @foreach(array_slice($platformarray['label'], 0, 4) as $index => $label)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="w-2.5 h-2.5 rounded-full mr-2" style="background-color: {{ ['#4f46e5', '#818cf8', '#c7d2fe', '#e2e8f0'][$index % 4] }}"></span>
                                    <span class="text-[12px] text-[#6B7280]">{{ $label }}</span>
                                </div>
                                <span class="text-[12px] font-bold text-[#111827]">{{ $platformarray['data'][$index] }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center text-center text-[#6B7280] h-full">
                        <i class="ti ti-chart-donut text-4xl mb-3 text-gray-200"></i>
                        <p class="text-sm font-semibold text-[#111827]">{{ __('No Source Data') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- 3. Row 3: Top URLs (4 cols) + Order Performance (4 cols) + Device Stats (4 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 mb-8">
        
        <!-- Left: Top URLs (4 cols) -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-[#E8EAF0] shadow-sm flex flex-col h-[300px]">
            <div class="p-5 pb-2 flex items-center justify-between shrink-0">
                <h3 class="text-[15px] font-bold text-[#111827]">{{ __('Top Pages') }}</h3>
            </div>
            <div class="flex-grow overflow-y-auto custom-scrollbar">
                @if(count($visitor_url) > 0)
                    <div class="px-5 py-2 space-y-2">
                        @foreach ($visitor_url->take(8) as $index => $url)
                            <div class="flex items-center justify-between group">
                                <div class="flex items-center">
                                    <span class="text-[12px] font-bold text-[#6B7280] w-6">{{ sprintf('%02d', $index + 1) }}</span>
                                    <a href="{{ $url->url }}" target="_blank" class="text-[13px] font-medium text-[#111827] hover:text-indigo-600 truncate max-w-[170px] transition-colors" title="{{ $url->url }}">
                                        {{ Str::limit(str_replace(env('APP_URL'), '', $url->url) ?: '/', 30) }}
                                    </a>
                                </div>
                                <span class="text-[12px] font-semibold text-[#111827]">{{ number_format($url->total) }} <span class="text-[#6B7280] font-normal ml-0.5">visits</span></span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center text-center text-[#6B7280] h-full p-5">
                        <i class="ti ti-link text-4xl mb-3 text-gray-200"></i>
                        <p class="text-[13px] font-semibold text-[#111827]">{{ __('No URL Data') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Middle: Order Performance (4 cols) -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-[#E8EAF0] shadow-sm flex flex-col h-[300px]">
            <div class="p-5 pb-3 flex items-center justify-between shrink-0">
                <h3 class="text-[15px] font-bold text-[#111827]">{{ __('Order Performance') }}</h3>
            </div>
            <div class="flex-grow px-5 pb-5 flex flex-col">
                <div class="flex gap-3 mb-4">
                    <div class="flex-1 bg-[#F7F8FC] p-3 rounded-xl border border-[#E8EAF0]">
                        <p class="text-[11px] font-medium text-[#6B7280] mb-0.5">{{ __('Total Orders') }}</p>
                        <h4 class="text-lg font-bold text-[#111827]">{{ number_format($total_orders) }}</h4>
                    </div>
                    <div class="flex-1 bg-[#F7F8FC] p-3 rounded-xl border border-[#E8EAF0]">
                        <p class="text-[11px] font-medium text-[#6B7280] mb-0.5">{{ __('Avg. Order') }}</p>
                        <h4 class="text-lg font-bold text-[#111827]">{{ \App\Models\Utility::priceFormat($aov) }}</h4>
                    </div>
                </div>
                
                <div class="mt-1">
                    @if(count($order_statuses) > 0)
                        <div class="space-y-3">
                            @foreach($order_statuses as $status_group)
                                @php
                                    $percentage = $total_orders > 0 ? ($status_group->total / $total_orders) * 100 : 0;
                                    $color = 'bg-indigo-500';
                                    if(strtolower($status_group->status) == 'completed' || strtolower($status_group->status) == 'delivered') $color = 'bg-[#10b981]';
                                    if(strtolower($status_group->status) == 'pending') $color = 'bg-[#f59e0b]';
                                    if(strtolower($status_group->status) == 'cancelled' || strtolower($status_group->status) == 'cancel') $color = 'bg-[#ef4444]';
                                @endphp
                                <div>
                                    <div class="flex justify-between items-center mb-1.5 text-[12px] font-medium">
                                        <span class="text-[#6B7280] capitalize">{{ $status_group->status }}</span>
                                        <span class="text-[#111827] font-bold">{{ $status_group->total }}</span>
                                    </div>
                                    <div class="w-full bg-[#E8EAF0] rounded-full h-1">
                                        <div class="{{ $color }} h-1 rounded-full" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-[#6B7280] py-6">
                            <i class="ti ti-shopping-cart-x text-3xl mb-2 text-gray-200"></i>
                            <p class="text-[13px] font-medium text-[#111827]">{{ __('No Orders Yet') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right: Device Stats (4 cols) -->
        <div class="lg:col-span-4 bg-white rounded-2xl border border-[#E8EAF0] shadow-sm flex flex-col h-[300px]">
            <div class="p-5 pb-1 flex items-center justify-between shrink-0">
                <h3 class="text-[15px] font-bold text-[#111827]">{{ __('Device Stats') }}</h3>
            </div>
            <div class="flex-grow flex flex-col justify-center px-5 pb-5">
                @if(count($devicearray['data']) > 0)
                    <div id="DeviceChart" class="w-full flex justify-center items-center h-[140px]"></div>
                    <div class="mt-2 grid grid-cols-1 gap-1.5 px-4 shrink-0">
                        @foreach(array_slice($devicearray['label'], 0, 3) as $index => $label)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="w-2.5 h-2.5 rounded-full mr-2" style="background-color: {{ ['#4f46e5', '#818cf8', '#c7d2fe'][$index % 3] }}"></span>
                                    <span class="text-[12px] text-[#6B7280]">{{ $label }}</span>
                                </div>
                                @php
                                    $total_devices = array_sum($devicearray['data']);
                                    $percent = $total_devices > 0 ? ($devicearray['data'][$index] / $total_devices) * 100 : 0;
                                @endphp
                                <span class="text-[12px] font-bold text-[#111827]">{{ number_format($percent, 0) }}%</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center text-center text-[#6B7280] h-full">
                        <i class="ti ti-devices text-4xl mb-3 text-gray-200"></i>
                        <p class="text-[13px] font-medium text-[#111827]">{{ __('No Data Available') }}</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-ui.page-container>
@endsection

@push('style-page')
<style>
    /* Neutralize legacy dash-container layout flow bug */
    .dash-container {
        position: static !important;
        top: auto !important;
        margin-left: 0 !important;
        min-height: auto !important;
    }
    .dash-content {
        padding: 0 !important;
    }
    
    body {
        background-color: #F7F8FC !important;
    }
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #E8EAF0;
        border-radius: 10px;
    }
    .custom-scrollbar:hover::-webkit-scrollbar-thumb {
        background-color: #d1d5db;
    }
    /* Make ApexCharts tooltips look premium */
    .apexcharts-tooltip {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03) !important;
        border: 1px solid #E8EAF0 !important;
        border-radius: 8px !important;
        background: #fff !important;
    }
    .apexcharts-tooltip-title {
        background: #F7F8FC !important;
        border-bottom: 1px solid #E8EAF0 !important;
        font-family: 'Inter', sans-serif !important;
        font-weight: 600 !important;
        font-size: 11px !important;
        color: #111827 !important;
    }
</style>
@endpush

@push('script-page')
    <script>
        // Main Store Performance Chart (Visitors)
        (function () {
            var options = {
                chart: {
                    type: 'area',
                    height: '100%',
                    parentHeightOffset: 0,
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif'
                },
                dataLabels: { enabled: false },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: "{{ __('Total Visitors') }}",
                    data: {!! json_encode($chartData['data']) !!}
                }, {
                    name: "{{ __('Unique Visitors') }}",
                    data: {!! json_encode($chartData['unique_data']) !!}
                }],
                xaxis: {
                    categories: {!! json_encode($chartData['label']) !!},
                    labels: {
                        style: { colors: '#6B7280', fontSize: '10px', fontWeight: 500 },
                        offsetY: 0
                    },
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    crosshairs: {
                        stroke: { color: '#E8EAF0', width: 1, dashArray: 4 }
                    }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#6B7280', fontSize: '10px', fontWeight: 500 },
                        offsetX: -10
                    }
                },
                colors: ['#4f46e5', '#818cf8'],
                grid: {
                    borderColor: '#E8EAF0',
                    strokeDashArray: 3,
                    xaxis: { lines: { show: true } },
                    yaxis: { lines: { show: true } },
                    padding: { top: 0, right: 0, bottom: 0, left: 10 }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    offsetY: -10,
                    itemMargin: { horizontal: 10, vertical: 0 },
                    markers: { width: 6, height: 6, radius: 12 },
                    fontSize: '11px',
                    labels: { colors: '#6B7280' }
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

        // Platform Donut Chart
        @if(count($platformarray['data']) > 0)
        (function () {
            var options = {
                series: {!! json_encode($platformarray['data']) !!},
                chart: {
                    type: 'donut',
                    width: '100%',
                    height: 140,
                    fontFamily: 'Inter, sans-serif'
                },
                labels: {!! json_encode($platformarray['label']) !!},
                colors: ['#4f46e5', '#818cf8', '#c7d2fe', '#e2e8f0'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '75%',
                            labels: {
                                show: true,
                                name: { fontSize: '11px', color: '#6B7280', fontWeight: 500 },
                                value: { fontSize: '20px', color: '#111827', fontWeight: 700 }
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                stroke: { width: 0 },
                legend: { show: false } // Legend is built in HTML
            };
            var chart = new ApexCharts(document.querySelector("#PlatformChart"), options);
            chart.render();
        })();
        @endif

        // Device Donut Chart
        @if(count($devicearray['data']) > 0)
        (function () {
            var options = {
                series: {!! json_encode($devicearray['data']) !!},
                chart: {
                    type: 'donut',
                    width: '100%',
                    height: 140,
                    fontFamily: 'Inter, sans-serif'
                },
                labels: {!! json_encode($devicearray['label']) !!},
                colors: ['#4f46e5', '#818cf8', '#c7d2fe'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '75%',
                            labels: {
                                show: true,
                                name: { fontSize: '11px', color: '#6B7280', fontWeight: 500 },
                                value: { fontSize: '20px', color: '#111827', fontWeight: 700 }
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                stroke: { width: 0 },
                legend: { show: false } // Legend is built in HTML
            };
            var chart = new ApexCharts(document.querySelector("#DeviceChart"), options);
            chart.render();
        })();
        @endif
    </script>
@endpush
