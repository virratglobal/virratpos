@extends('layouts.ui-admin')

@section('page-title', __('Order Details'))

@push('scripts')
    <script type="text/javascript" src="{{ asset('custom/js/html2pdf.bundle.min.js') }}"></script>
    <script>
        function copyToClipboard(element) {
            var copyText = element.id;
            document.addEventListener('copy', function (e) {
                e.clipboardData.setData('text/plain', copyText);
                e.preventDefault();
            }, true);
            document.execCommand('copy');
            show_toastr('success', 'Url copied to clipboard', 'success');
        }

        var filename = $('#filesname').val();
        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: { type: 'jpeg', quality: 1 },
                html2canvas: { scale: 4, dpi: 72, letterRendering: true },
                jsPDF: { unit: 'in', format: 'A2' }
            };
            html2pdf().set(opt).from(element).save();
        }

        $("#deliver_btn").on('click', '#delivered', function() {
            var status = $(this).attr('data-value');
            var data = { delivered: status }
            $.ajax({
                url: '{{ route('orders.update', $order->id) }}',
                method: 'PUT',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    show_toastr('success', data.success, 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            });
        });
    </script>
@endpush

@section('content')
<x-ui.page-container>
    <!-- Header -->
    <x-ui.page-header title="{{ __('Order') }} {{ $order->order_id }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <a href="{{ route('orders.index') }}" class="hover:text-gray-900">{{ __('Orders') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Order') }} {{ $order->order_id }}</span>
        </x-slot>

        <x-slot name="actions">
            <div class="flex items-center space-x-2">
                <x-ui.button variant="secondary" id="{{ env('APP_URL') .'/' . $store->slug . '/order/' . trim($order->order_id,'#') }}" onclick="copyToClipboard(this)" title="{{__('Click to copy')}}" data-bs-toggle="tooltip">
                    <span class="material-symbols-outlined text-[18px]">link</span>
                </x-ui.button>
                <a href="{{ route('order.receipt', $order->id) }}">
                    <x-ui.button variant="secondary" title="{{ __('Receipt') }}">
                        <span class="material-symbols-outlined text-[18px]">receipt</span>
                    </x-ui.button>
                </a>
                <a href="{{ route('invoice.pdf', \Crypt::encrypt($order->id)) }}" target="_blank">
                    <x-ui.button variant="secondary" title="{{ __('Print') }}">
                        <span class="material-symbols-outlined text-[18px]">print</span>
                    </x-ui.button>
                </a>
                <div class="relative" x-data="{ open: false }" id="deliver_btn">
                    <x-ui.button variant="primary" @click="open = !open" @click.away="open = false">
                        {{ __('Status') }} : {{ __(ucfirst($order->status)) }}
                        <span class="material-symbols-outlined text-[16px] ml-1">arrow_drop_down</span>
                    </x-ui.button>
                    <div x-show="open" style="display: none; position: absolute; right: 0; margin-top: 4px; width: 180px; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 24px rgba(0,0,0,0.1); border: 1px solid rgba(199,196,215,0.2); padding: 4px;" class="z-50">
                        <span class="block px-3 py-1.5 text-[10px] font-semibold text-gray-400 uppercase tracking-wider">{{ __('Set order status') }}</span>
                        <a class="flex items-center gap-2 px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 rounded no-underline" href="#" id="delivered" data-value="delivered">
                            <span class="material-symbols-outlined text-[16px] text-green-600">done</span>
                            <span>{{ __('Delivered') }}</span>
                        </a>
                        <a class="flex items-center gap-2 px-3 py-2 text-xs text-red-600 hover:bg-red-50 rounded no-underline" href="#" id="delivered" data-value="Cancel Order">
                            <span class="material-symbols-outlined text-[16px] text-red-600">close</span>
                            <span>{{ __('Cancel Order') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </x-slot>
    </x-ui.page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8" id="printableArea">
        {{-- Left: Items & Info --}}
        <div class="lg:col-span-2 flex flex-col space-y-6">
            {{-- Items Card --}}
            <div class="bg-white rounded-xl border border-gray-150 p-6 shadow-sm">
                <h3 class="text-base font-semibold text-gray-900 mb-4">{{ __('Order Items') }}</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-sm">
                        <thead>
                            <tr>
                                <th class="py-2 text-left font-medium text-gray-400">{{ __('Item') }}</th>
                                <th class="py-2 text-left font-medium text-gray-400">{{ __('Quantity') }}</th>
                                <th class="py-2 text-left font-medium text-gray-400">{{ __('Price') }}</th>
                                <th class="py-2 text-left font-medium text-gray-400">{{ __('Total') }}</th>
                                <th class="py-2 text-right font-medium text-gray-400">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php
                                $sub_tax = 0;
                                $total = 0;
                                $order_id = trim($order->order_id,'#');
                            @endphp
                            @foreach ($order_products as $key => $product)
                                @if (isset($product->variant_id) && $product->variant_id != 0)
                                    <tr>
                                        <td class="py-3">
                                            @if (isset($product->product_name))
                                                <a href="{{ route('product.show', $product->id) }}" class="no-underline font-medium text-gray-900 hover:text-indigo-600">{{ $product->product_name . ' - ( ' . $product->variant_name . ' )' }}</a>
                                            @else
                                                <a href="{{ route('product.show', $product->id) }}" class="no-underline font-medium text-gray-900 hover:text-indigo-600">{{ $product->name }}</a>
                                            @endif
                                            @if (!empty($product->tax))
                                                @php $total_tax = 0; @endphp
                                                <span class="block text-[10px] text-gray-400 mt-1">
                                                    @foreach ($product->tax as $tax)
                                                        @php
                                                            $sub_tax = ($product->variant_price * $product->quantity * $tax->tax) / 100;
                                                            $total_tax += $sub_tax;
                                                        @endphp
                                                        {{ $tax->tax_name . ' ' . $tax->tax . '%' . ' (' . $sub_tax . ')' }}
                                                    @endforeach
                                                </span>
                                            @else
                                                @php $total_tax = 0; @endphp
                                            @endif
                                        </td>
                                        <td class="py-3 text-gray-500">{{ $product->quantity }}</td>
                                        <td class="py-3 text-gray-500">{{ App\Models\Utility::priceFormat($product->variant_price) }}</td>
                                        <td class="py-3 text-gray-900 font-medium">{{ App\Models\Utility::priceFormat($product->variant_price * $product->quantity + $total_tax) }}</td>
                                        <td class="py-3 text-right">
                                            @can('Delete Orders')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['delete.order_item', $product->id , $product->variant_id,$order_id,$key]]) !!}
                                                <x-ui.button variant="danger" size="sm" type="submit" class="show_confirm" title="{{__('Delete')}}">
                                                    <span class="material-symbols-outlined text-[14px]">delete</span>
                                                </x-ui.button>
                                                {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    </tr>
                                @else
                                    <tr>
                                        <td class="py-3">
                                            @if (isset($product->product_name))
                                                <a href="{{ route('product.show', $product->id) }}" class="no-underline font-medium text-gray-900 hover:text-indigo-600">{{ $product->product_name }}</a>
                                            @else
                                                <a href="{{ route('product.show', $product->id) }}" class="no-underline font-medium text-gray-900 hover:text-indigo-600">{{ $product->name }}</a>
                                            @endif
                                            @if (!empty($product->tax))
                                                @php $total_tax = 0; @endphp
                                                <span class="block text-[10px] text-gray-400 mt-1">
                                                    @foreach ($product->tax as $tax)
                                                        @php
                                                            $sub_tax = ($product->price * $product->quantity * $tax->tax) / 100;
                                                            $total_tax += $sub_tax;
                                                        @endphp
                                                        {{ $tax->tax_name . ' ' . $tax->tax . '%' . ' (' . $sub_tax . ')' }}
                                                    @endforeach
                                                </span>
                                            @else
                                                @php $total_tax = 0; @endphp
                                            @endif
                                        </td>
                                        <td class="py-3 text-gray-500">{{ $product->quantity }}</td>
                                        <td class="py-3 text-gray-500">{{ App\Models\Utility::priceFormat($product->price) }}</td>
                                        <td class="py-3 text-gray-900 font-medium">{{ App\Models\Utility::priceFormat($product->price * $product->quantity + $total_tax) }}</td>
                                        <td class="py-3 text-right">
                                            @can('Delete Orders')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['delete.order_item', $product->id , $product->variant_id,$order_id,$key]]) !!}
                                                <x-ui.button variant="danger" size="sm" type="submit" class="show_confirm" title="{{__('Delete')}}">
                                                    <span class="material-symbols-outlined text-[14px]">delete</span>
                                                </x-ui.button>
                                                {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Shipping & Billing Information --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Shipping Information --}}
                <div class="bg-white rounded-xl border border-gray-150 p-6 shadow-sm">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">{{ __('Shipping Information') }}</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">{{ __('Name') }}</span>
                            <span class="font-medium text-gray-900">{{ !empty($user_details->name) ? $user_details->name : '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">{{ __('Company') }}</span>
                            <span class="font-medium text-gray-900">{{ !empty($user_details->shipping_address) ? $user_details->shipping_address : '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">{{ __('City') }}</span>
                            <span class="font-medium text-gray-900">{{ !empty($user_details->shipping_city) ? $user_details->shipping_city : '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">{{ __('Country') }}</span>
                            <span class="font-medium text-gray-900">{{ !empty($user_details->shipping_country) ? $user_details->shipping_country : '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">{{ __('Postal Code') }}</span>
                            <span class="font-medium text-gray-900">{{ !empty($user_details->shipping_postalcode) ? $user_details->shipping_postalcode : '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">{{ __('Phone') }}</span>
                            <span class="font-medium text-gray-900">
                                @if(!empty($user_details->phone))
                                    <a href="https://api.whatsapp.com/send?phone={{ str_replace(' ', '', $user_details->phone) }}&text=Hi" target="_blank" class="text-indigo-600 no-underline hover:underline">{{ $user_details->phone }}</a>
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                        @if (!empty($location_data && $shipping_data))
                            <div class="flex justify-between border-t border-gray-100 pt-3">
                                <span class="text-gray-400">{{ __('Location') }}</span>
                                <span class="font-medium text-gray-900">{{ $location_data->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">{{ __('Shipping Method') }}</span>
                                <span class="font-medium text-gray-900">{{ $shipping_data->shipping_name }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Billing Information --}}
                <div class="bg-white rounded-xl border border-gray-150 p-6 shadow-sm">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">{{ __('Billing Information') }}</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-400">{{ __('Name') }}</span>
                            <span class="font-medium text-gray-900">{{ !empty($user_details->name) ? $user_details->name : '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">{{ __('Company') }}</span>
                            <span class="font-medium text-gray-900">{{ !empty($user_details->billing_address) ? $user_details->billing_address : '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">{{ __('City') }}</span>
                            <span class="font-medium text-gray-900">{{ !empty($user_details->billing_city) ? $user_details->billing_city : '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">{{ __('Country') }}</span>
                            <span class="font-medium text-gray-900">{{ !empty($user_details->billing_country) ? $user_details->billing_country : '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">{{ __('Postal Code') }}</span>
                            <span class="font-medium text-gray-900">{{ !empty($user_details->billing_postalcode) ? $user_details->billing_postalcode : '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">{{ __('Phone') }}</span>
                            <span class="font-medium text-gray-900">
                                @if(!empty($user_details->phone))
                                    <a href="https://api.whatsapp.com/send?phone={{ str_replace(' ', '', $user_details->phone) }}&text=Hi" target="_blank" class="text-indigo-600 no-underline hover:underline">{{ $user_details->phone }}</a>
                                @else
                                    -
                                @endif
                            </span>
                        </div>
                        @if (!empty($location_data && $shipping_data))
                            <div class="flex justify-between border-t border-gray-100 pt-3">
                                <span class="text-gray-400">{{ __('Location') }}</span>
                                <span class="font-medium text-gray-900">{{ $location_data->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-400">{{ __('Shipping Method') }}</span>
                                <span class="font-medium text-gray-900">{{ $shipping_data->shipping_name }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Right: Order Summary --}}
        <div class="flex flex-col space-y-6">
            <div class="bg-white rounded-xl border border-gray-150 p-6 shadow-sm">
                <h3 class="text-base font-semibold text-gray-900 mb-4">{{ __('Order Summary') }}</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-400">{{ __('Sub Total') }}</span>
                        <span class="font-semibold text-gray-900">{{ App\Models\Utility::priceFormat($sub_total) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">{{ __('Estimated Tax') }}</span>
                        <span class="font-semibold text-gray-900">{{ App\Models\Utility::priceFormat($total_taxs) }}</span>
                    </div>
                    @if (!empty($discount_price))
                        <div class="flex justify-between">
                            <span class="text-gray-400">{{ __('Apply Coupon') }}</span>
                            <span class="font-semibold text-gray-900">
                                @if($order->payment_type == 'POS')
                                    {{ App\Models\Utility::priceFormat($discount_price) }}
                                @else
                                    {{ $discount_price }}
                                @endif
                            </span>
                        </div>
                    @endif
                    @if (!empty($shipping_data))
                        <div class="flex justify-between">
                            <span class="text-gray-400">{{ __('Shipping Price') }}</span>
                            <span class="font-semibold text-gray-900">{{ App\Models\Utility::priceFormat($shipping_data->shipping_price) }}</span>
                        </div>
                        <div class="flex justify-between border-t border-gray-100 pt-3">
                            <span class="text-base font-semibold text-gray-900">{{ __('Grand Total') }}</span>
                            @if (!empty($discount_value))
                                <span class="text-base font-bold text-indigo-600">{{ App\Models\Utility::priceFormat($grand_total + $shipping_data->shipping_price - $discount_value) }}</span>
                            @else
                                <span class="text-base font-bold text-indigo-600">{{ App\Models\Utility::priceFormat($sub_total + $shipping_data->shipping_price + $total_taxs) }}</span>
                            @endif
                        </div>
                    @elseif(!empty($discount_value))
                        <div class="flex justify-between border-t border-gray-100 pt-3">
                            <span class="text-base font-semibold text-gray-900">{{ __('Grand Total') }}</span>
                            <span class="text-base font-bold text-indigo-600">{{ App\Models\Utility::priceFormat($grand_total - $discount_value) }}</span>
                        </div>
                    @else
                        <div class="flex justify-between border-t border-gray-100 pt-3">
                            <span class="text-base font-semibold text-gray-900">{{ __('Grand Total') }}</span>
                            <span class="text-base font-bold text-indigo-600">
                                @if($order->payment_type == 'POS')
                                    @php $discount = !empty($discount_price) ? $discount_price : 0; @endphp
                                    {{ App\Models\Utility::priceFormat($grand_total - $discount) }}
                                @else
                                    {{ App\Models\Utility::priceFormat($grand_total) }}
                                @endif
                            </span>
                        </div>
                    @endif
                    <div class="flex justify-between border-t border-gray-100 pt-3">
                        <span class="text-gray-400">{{ __('Payment Type') }}</span>
                        <span class="font-medium text-gray-900">{{ $order['payment_type'] }}</span>
                    </div>
                </div>
            </div>

            @if((!empty($store_payment_setting['custom_field_title_1']) && !empty($user_details->custom_field_title_1)) ||
                (!empty($store_payment_setting['custom_field_title_2']) && !empty($user_details->custom_field_title_2)) ||
                (!empty($store_payment_setting['custom_field_title_3']) && !empty($user_details->custom_field_title_3)) ||
                (!empty($store_payment_setting['custom_field_title_4']) && !empty($user_details->custom_field_title_4)))
                <div class="bg-white rounded-xl border border-gray-150 p-6 shadow-sm">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">{{ __('Extra Information') }}</h3>
                    <div class="space-y-3 text-sm">
                        @if(!empty($user_details->custom_field_title_1))
                            <div class="flex justify-between">
                                <span class="text-gray-400">{{ isset($store_payment_setting['custom_field_title_1']) ? $store_payment_setting['custom_field_title_1'] : '' }}</span>
                                <span class="font-medium text-gray-900">{{ $user_details->custom_field_title_1 }}</span>
                            </div>
                        @endif
                        @if(!empty($user_details->custom_field_title_2))
                            <div class="flex justify-between">
                                <span class="text-gray-400">{{ isset($store_payment_setting['custom_field_title_2']) ? $store_payment_setting['custom_field_title_2'] : '' }}</span>
                                <span class="font-medium text-gray-900">{{ $user_details->custom_field_title_2 }}</span>
                            </div>
                        @endif
                        @if(!empty($user_details->custom_field_title_3))
                            <div class="flex justify-between">
                                <span class="text-gray-400">{{ isset($store_payment_setting['custom_field_title_3']) ? $store_payment_setting['custom_field_title_3'] : '' }}</span>
                                <span class="font-medium text-gray-900">{{ $user_details->custom_field_title_3 }}</span>
                            </div>
                        @endif
                        @if(!empty($user_details->custom_field_title_4))
                            <div class="flex justify-between">
                                <span class="text-gray-400">{{ isset($store_payment_setting['custom_field_title_4']) ? $store_payment_setting['custom_field_title_4'] : '' }}</span>
                                <span class="font-medium text-gray-900">{{ $user_details->custom_field_title_4 }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-ui.page-container>
@endsection
