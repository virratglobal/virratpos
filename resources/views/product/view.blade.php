@extends('layouts.ui-admin')

@section('page-title', __('Product'))

@php
    $logo=\App\Models\Utility::get_file('uploads/is_cover_image/');
    $p_logo=\App\Models\Utility::get_file('uploads/product_image/');
@endphp

@push('scripts')
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

        $(document).on('change', '.rating_view', function() {
            var id = $(this).attr('data-id');
            var status = 'off';
            if ($(this).is(":checked")) {
                status = 'on';
            }
            var data = {
                id: id,
                status: status
            }

            $.ajax({
                url: '{{ route('rating.rating_view') }}',
                method: 'POST',
                data: data,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    show_toastr('success', data.success, 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            });
        });

        $(document).on('change', '.change_price', function () {
            var variants = [];
            $(".change_price").each(function (index, element) {
                variants.push(element.value);
            });
            if (variants.length > 0) {
                $.ajax({
                    url: '{{route('get.products.variant.quantity')}}',
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        variants: variants.join(' : '),
                        product_id: $('#product_id').val()
                    },
                    success: function (data) {
                        $('.variasion_price').html(data.price);
                        $('#variant_id').val(data.variant_id);
                        $('.variant_qty').html(data.quantity);
                    }
                });
            }
        });
    </script>
@endpush

@section('content')
<x-ui.page-container>
    <!-- Header -->
    <x-ui.page-header title="{{ $product->name }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <a href="{{ route('product.index') }}" class="hover:text-gray-900">{{ __('Product') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ $product->name }}</span>
        </x-slot>

        <x-slot name="actions">
            <div class="flex items-center space-x-2">
                @can('Create Ratting')
                    <x-ui.button variant="secondary" data-bs-toggle="tooltip" data-size="md" data-toggle="modal" data-url="{{ route('rating', [$store->slug, $product->id]) }}" data-ajax-popup="true" data-title="{{ __('Create New Rating') }}" data-bs-placement="top" title="{{ __('Create New Rating') }}">
                        <span class="material-symbols-outlined text-[18px]">star</span>
                        {{ __('Add Rating') }}
                    </x-ui.button>
                @endcan
                @can('Edit Products')
                    <a href="{{ route('product.edit', $product->id) }}">
                        <x-ui.button variant="primary">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                            {{ __('Edit Product') }}
                        </x-ui.button>
                    </a>
                @endcan
            </div>
        </x-slot>
    </x-ui.page-header>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        {{-- Left Column: Product Info --}}
        <div class="flex flex-col space-y-6">
            <div class="bg-white rounded-xl border border-gray-150 p-6 shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 m-0">{{ $product->name }}</h2>
                    <div class="flex items-center space-x-3 mt-2 sm:mt-0">
                        @if($product->enable_product_variant =='on')
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">
                                <span class="variant_qty font-bold">0</span> {{ __('Total Avl. Quantity') }}
                            </span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100">
                                <span class="font-bold">{{ $product->quantity }}</span> {{ __('Total Avl. Quantity') }}
                            </span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 border-t border-b border-gray-100 py-4 mb-6">
                    <div>
                        <span class="text-xs text-gray-400 block">{{ __('Categories') }}</span>
                        <span class="text-sm font-medium text-gray-900 block mt-1">{{ $product->categories->name ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 block">{{ __('SKU') }}</span>
                        <span class="text-sm font-medium text-gray-900 block mt-1">{{ $product->SKU ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-gray-400 block">{{ __('Price') }}</span>
                        <span class="text-sm font-bold text-indigo-600 block mt-1 variasion_price">
                            @if ($product->enable_product_variant == 'on')
                                {{ \App\Models\Utility::priceFormat(0) }}
                            @else
                                {{ \App\Models\Utility::priceFormat($product->price) }}
                            @endif
                        </span>
                    </div>
                </div>

                <div class="flex items-center space-x-2 mb-6">
                    <div class="flex items-center text-amber-400">
                        @for ($i = 1; $i <= 5; $i++)
                            @php
                                $icon = 'star';
                                $newVal1 = $i - 0.5;
                                if ($avg_rating < $i && $avg_rating >= $newVal1) {
                                    $icon = 'star_half';
                                }
                                $color = ($avg_rating >= $newVal1) ? 'text-amber-400' : 'text-gray-300';
                            @endphp
                            <span class="material-symbols-outlined {{ $color }} text-[20px] select-none">{{ $icon }}</span>
                        @endfor
                    </div>
                    <span class="text-xs text-gray-500 font-medium">{{ __('Rating') }}: {{ $avg_rating }} ({{ $user_count }} {{ __('reviews') }})</span>
                </div>

                <div class="w-full h-80 rounded-xl overflow-hidden mb-6 border border-gray-150 bg-gray-50">
                    @if (!empty($product->is_cover))
                        <img src="{{ asset(Storage::url('uploads/is_cover_image/' . $product->is_cover)) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <img src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @endif
                </div>

                @if(!empty($product->description))
                    <h4 class="text-sm font-semibold text-gray-900 mb-2">{{ __('Description') }}</h4>
                    <div class="text-sm text-gray-600 leading-relaxed prose max-w-none">
                        {!! $product->description !!}
                    </div>
                @endif
            </div>
        </div>

        {{-- Right Column: Actions / Checkout / Variants --}}
        <div class="flex flex-col space-y-6">
            {{-- Express Checkout --}}
            <div class="bg-white rounded-xl border border-gray-150 p-6 shadow-sm">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-base font-semibold text-gray-900 m-0">{{ __('Express Checkout') }}</h3>
                        <p class="text-xs text-gray-500 mt-1 m-0">{{ __('Generate express URL for direct ordering') }}</p>
                    </div>
                    <x-ui.button variant="secondary" size="sm" data-ajax-popup="true" data-url="{{ route('expresscheckout.create',[$product->id]) }}" data-title="{{ __('Add Product') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create') }}">
                        <span class="material-symbols-outlined text-[16px]">add</span>
                        {{ __('Add') }}
                    </x-ui.button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100 text-sm">
                        <thead>
                            <tr>
                                <th class="py-2 text-left font-medium text-gray-400">{{ __('Name') }}</th>
                                <th class="py-2 text-left font-medium text-gray-400">{{ __('Qty') }}</th>
                                <th class="py-2 text-left font-medium text-gray-400">{{ __('Variant') }}</th>
                                <th class="py-2 text-left font-medium text-gray-400">{{ __('URL') }}</th>
                                <th class="py-2 text-right font-medium text-gray-400">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @if(count($expresscheckout) > 0)
                                @foreach($expresscheckout as $key => $value)
                                    <tr>
                                        <td class="py-3 font-medium text-gray-900">{{ $value->product->name }}</td>
                                        <td class="py-3 text-gray-500">{{ $value->quantity }}</td>
                                        <td class="py-3 text-gray-500">{{ isset($value->variant_name) ? $value->variant_name : '-' }}</td>
                                        <td class="py-3">
                                            <a href="#" class="cp_link text-xs px-2.5 py-1 bg-indigo-50 text-indigo-600 rounded-md font-semibold no-underline" data-link="{{ env('APP_URL') . '/' . $value->url }}">
                                                {{ __('Copy') }}
                                            </a>
                                        </td>
                                        <td class="py-3 text-right">
                                            <div class="flex items-center justify-end space-x-1.5">
                                                <x-ui.button variant="ghost" size="sm" data-ajax-popup="true" data-url="{{ route('expresscheckout.edit',[$value->id]) }}" data-title="{{ __('Edit Expresscheckout') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Edit') }}">
                                                    <span class="material-symbols-outlined text-[14px]">edit</span>
                                                </x-ui.button>
                                                <x-ui.button variant="danger" size="sm" class="bs-pass-para" data-title="{{ __('Delete Checkout Link') }}" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="delete-form-{{ $value->id }}">
                                                    <span class="material-symbols-outlined text-[14px]">delete</span>
                                                </x-ui.button>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['expresscheckout.destroy', $value->id], 'id' => 'delete-form-' . $value->id]) !!}
                                                {!! Form::close() !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-xs text-gray-400">
                                        {{ __('No express checkout URLs generated yet.') }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Variants selection if active --}}
            @if ($product->enable_product_variant == 'on')
                <div class="bg-white rounded-xl border border-gray-150 p-6 shadow-sm">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">{{ __('Variants Availability') }}</h3>
                    <input type="hidden" id="product_id" value="{{ $product->id }}">
                    <input type="hidden" id="variant_id" value="">
                    <input type="hidden" id="variant_qty" value="">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($product_variant_names as $key => $variant)
                            <div class="flex flex-col">
                                <label class="text-xs font-semibold text-gray-500 mb-1.5">{{ ucfirst($variant->variant_name) }}</label>
                                <select name="product[{{$key}}]" id='choices-multiple-2-{{$key}}' class="form-control pro_variants_name{{$key}} change_price pc-input" style="padding: 8px 12px; border-radius: 6px; border: 1px solid #c7c4d7; font-size: 13px;">
                                    <option value="">{{ __('Select')  }}</option>
                                    @foreach ($variant->variant_options as $option_val)
                                        <option value="{{$option_val}}">{{$option_val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Gallery Sub-Images --}}
            @if(count($product_image) > 0)
                <div class="bg-white rounded-xl border border-gray-150 p-6 shadow-sm">
                    <h3 class="text-base font-semibold text-gray-900 mb-4">{{ __('Gallery') }}</h3>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach ($product_image as $key => $image_obj)
                            <div class="aspect-square bg-gray-50 rounded-lg overflow-hidden border border-gray-150">
                                <img src="{{ $p_logo . (!empty($image_obj->product_images) ? $image_obj->product_images : 'is_cover_image.png') }}" alt="" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Ratings --}}
            <div class="bg-white rounded-xl border border-gray-150 p-6 shadow-sm">
                <h3 class="text-base font-semibold text-gray-900 mb-4">{{ __('Customer Reviews') }}</h3>
                <div class="space-y-4 divide-y divide-gray-100">
                    @if(count($product_ratings) > 0)
                        @foreach ($product_ratings as $product_key => $product_rating)
                            <div class="pt-4 first:pt-0">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900 m-0">{{ $product_rating->title }}</h4>
                                        <div class="flex items-center space-x-1.5 text-amber-400 mt-1 mb-2">
                                            @for ($i = 0; $i < 5; $i++)
                                                <span class="material-symbols-outlined text-[16px] select-none">{{ $product_rating->ratting > $i ? 'star' : 'star_border' }}</span>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="flex items-center space-x-1">
                                            <input type="checkbox" class="rating_view w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" name="rating_view" id="enable_rating{{ $product_key }}" data-id="{{ $product_rating['id'] }}" {{ $product_rating->rating_view == 'on' ? 'checked' : '' }}>
                                            <label class="text-[10px] font-semibold text-gray-400" for="enable_rating{{ $product_key }}">{{ __('Publish') }}</label>
                                        </div>
                                        @can('Edit Ratting')
                                            <x-ui.button variant="ghost" size="sm" data-url="{{ route('rating.edit', $product_rating->id) }}" data-ajax-popup="true" data-title="{{ __('Edit Rating') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Edit Rating') }}">
                                                <span class="material-symbols-outlined text-[14px]">edit</span>
                                            </x-ui.button>
                                        @endcan
                                        @can('Delete Ratting')
                                            <x-ui.button variant="danger" size="sm" class="bs-pass-para" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Delete') }}" data-title="{{__('Delete Lead')}}" data-confirm="{{__('Are You Sure?')}}" data-text="{{__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="delete-form-{{$product_rating->id}}">
                                                <span class="material-symbols-outlined text-[14px]">delete</span>
                                            </x-ui.button>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['rating.destroy', $product_rating->id],'id'=>'delete-form-'.$product_rating->id]) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    </div>
                                </div>
                                <p class="text-xs text-gray-600 m-0">{{ $product_rating->description }}</p>
                                <span class="text-[10px] text-gray-400 block mt-2">{{ __('by') }} {{ $product_rating->name }} &bull; {{ $product_rating->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-xs text-gray-400 py-4 text-center">{{ __('No reviews submitted yet for this product.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-ui.page-container>
@endsection
