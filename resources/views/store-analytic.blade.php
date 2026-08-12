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

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Visitors Chart -->
        <div class="col-span-1 lg:col-span-12">
            <x-ui.card>
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Visitor') }}</h3>
                    <div class="mt-2 flex items-baseline">
                        <p class="text-2xl font-semibold text-gray-900">4,354</p>
                    </div>
                    <div class="mt-4">
                        <div id="Analytics" class="w-full"></div>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <!-- Top URL -->
        <div class="col-span-1 lg:col-span-4">
            <x-ui.card class="h-full">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Top URL') }}</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Url') }}</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Views') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($visitor_url as $url)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-primary-600 hover:text-primary-900">
                                        <a href="{{ $url->url }}">{{ $slug }}</a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $url->total }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-ui.card>
        </div>

        <!-- Platform Chart -->
        <div class="col-span-1 lg:col-span-8">
            <x-ui.card class="h-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Platform') }}</h3>
                    <div class="mt-4">
                        <div id="user-chart" class="w-full"></div>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <!-- Device Chart -->
        <div class="col-span-1 lg:col-span-6">
            <x-ui.card class="h-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Device') }}</h3>
                    <div class="mt-4">
                        <div id="WebKit" class="w-full"></div>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <!-- Browser Chart -->
        <div class="col-span-1 lg:col-span-6">
            <x-ui.card class="h-full">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900">{{ __('Browser') }}</h3>
                    <div class="mt-4">
                        <div id="Safari" class="w-full"></div>
                    </div>
                </div>
            </x-ui.card>
        </div>

    </div>

</x-ui.page-container>
@endsection
@push('script-page')
    <script>
        (function () {
                var options = {
                    chart: {
                        height: 300,
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
                        name: "{{ __('Refferal') }}",
                        data: {!! json_encode($chartData['data']) !!}
                    }, {
                        name: "{{ __('Organic search') }}",
                        data: {!! json_encode($chartData['unique_data']) !!}
                    }],
                    xaxis: {
                        categories: {!! json_encode($chartData['label']) !!},
                        title: {
                            text: 'Days'
                        }
                    },
                    colors: ['#ffa21d', '#FF3A6E'],

                    grid: {
                        strokeDashArray: 4,
                        show: false,
                    },
                    legend: {
                        show: false,
                    },
                    {{--  markers: {
                        size: 4,
                        colors: ['#ffa21d', '#FF3A6E'],
                        opacity: 0.9,
                        strokeWidth: 2,
                        hover: {
                            size: 7,
                        }
                    },  --}}
                    yaxis: {
                        tickAmount: 3,
                    },

                    fill: {
                        type: 'gradient',
                        gradient: {
                            shade: 'dark',
                            type: "horizontal",
                            shadeIntensity: 0,
                            gradientToColors: undefined,
                            inverseColors: true,
                            opacityFrom: 0,
                            opacityTo: 0,
                            stops: [0, 50, 100],
                            colorStops: []
                        }
                    }
                };
                var chart = new ApexCharts(document.querySelector("#Analytics"), options);
                chart.render();
            })();
            (function () {
                var options = {
                    chart: {
                        type: 'bar',
                        height: 300,
                        zoom: {
                            enabled: false
                        },
                        toolbar: {
                            show: false,
                        },
                    },
                    dataLabels: {
                        enabled: false,
                    },

                    plotOptions: {
                        bar: {
                            color: '#fff',
                            columnWidth: '20%',
                        }
                    },
                    fill: {
                        type: 'solid',
                        opacity: 1,
                    },
                    series: [{
                        name: "{{ __('Platform') }}",
                        data: {!! json_encode($platformarray['data']) !!},
                    }],
                    colors: ['#6FD943','#162C4E','#DAE0E0','#316849','#1A3C4E','#203E4C'],
                    xaxis: {
                        labels: {
                            // format: 'MMM',
                            style: {
                                colors: PurposeStyle.colors.gray[600],
                                fontSize: '14px',
                                fontFamily: PurposeStyle.fonts.base,
                                cssClass: 'apexcharts-xaxis-label',
                            },
                        },
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: true,
                            borderType: 'solid',
                            color: PurposeStyle.colors.gray[300],
                            height: 6,
                            offsetX: 0,
                            offsetY: 0
                        },
                        title: {
                            text: '{{ __('Platform') }}'
                        },
                        categories: {!! json_encode($platformarray['label']) !!},
                    },
                    yaxis: {
                        tickAmount: 4,
                        labels: {
                            style: {
                                colors: "#000",
                            }
                        },
                    },
                    grid: {
                        borderColor: '#ffffff00',
                        padding: {
                            bottom: 0,
                            left: 10,
                        }
                    },
                    tooltip: {
                        fixed: {
                            enabled: false
                        },
                        x: {
                            show: false
                        },
                        y: {
                            title: {
                                formatter: function (seriesName) {
                                    return 'Total Earnings'
                                }
                            }
                        },
                        marker: {
                            show: false
                        }
                    }
                };
                var chart = new ApexCharts(document.querySelector("#user-chart"), options);
                chart.render();
            })();

            var options = {
                    series: {!! json_encode($devicearray['data']) !!},
                    chart: {
                        width: 450,
                        type: 'donut',
                    },
                    colors: ["#6FD943", "#316849", "#1A3C4E", "#EBF7E7", " #EBEDEF"],
                    labels: {!! json_encode($devicearray['label']) !!},
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 300
                            },
                            legend: {
                                position: 'bottom',
                            }
                        }
                    }]
                };
                var chart = new ApexCharts(document.querySelector("#WebKit"), options);
                chart.render();
                var options = {
                    series: {!! json_encode($browserarray['data']) !!},
                    chart: {
                        width: 450,
                        type: 'donut',
                    },
                    colors: ["#6FD943", "#316849", "#1A3C4E", "#EBF7E7", " #EBEDEF"],
                    labels: {!! json_encode($browserarray['label']) !!},
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 300
                            },
                            legend: {
                                position: 'bottom',
                            }
                        }
                    }]
                };
                var chart = new ApexCharts(document.querySelector("#Safari"), options);
                chart.render();
        </script>
@endpush
