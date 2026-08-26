@extends('layouts.ui-admin')

@section('page-title', __('Products'))

@php
    $logo = \App\Models\Utility::get_file('uploads/is_cover_image/');
@endphp

@section('content')
<x-ui.page-container>
    
    <x-ui.page-header title="{{ __('Products') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Products') }}</span>
        </x-slot>

        <x-slot name="actions">
            <div class="flex items-center space-x-2">
                <a href="{{ route('product.export') }}">
                    <x-ui.button variant="secondary" title="{{ __('Export') }}">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Export
                    </x-ui.button>
                </a>
                
                @can('Create Products')
                    <a href="#" data-ajax-popup="true" data-size="lg" data-title="{{ __('Import Product CSV File') }}" data-url="{{ route('product.file.import') }}">
                        <x-ui.button variant="secondary" title="{{ __('Import') }}">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Import
                        </x-ui.button>
                    </a>
                @endcan

                <a href="{{ route('product.grid') }}">
                    <x-ui.button variant="secondary" title="{{ __('Grid View') }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    </x-ui.button>
                </a>

                @can('Create Products')
                    <a href="{{ route('product.create') }}">
                        <x-ui.button variant="primary">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            {{ __('Add new product') }}
                        </x-ui.button>
                    </a>
                @endcan
            </div>
        </x-slot>
    </x-ui.page-header>

    @if (count($products) > 0)
        <x-ui.table>
            <x-slot name="head">
                <th scope="col" class="!px-4 !py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Product') }}</th>
                <th scope="col" class="!px-4 !py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Category') }}</th>
                <th scope="col" class="!px-4 !py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Price') }}</th>
                <th scope="col" class="!px-4 !py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Quantity') }}</th>
                <th scope="col" class="!px-4 !py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Status') }}</th>
                <th scope="col" class="relative !px-4 !py-2"><span class="sr-only">{{ __('Action') }}</span></th>
            </x-slot>

            <x-slot name="body">
                @foreach ($products as $product)
                    <tr>
                        <td class="!px-4 !py-2 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-md object-cover border border-gray-200" src="{{ $logo.(isset($product->is_cover) && !empty($product->is_cover) ? $product->is_cover : 'default.jpg') }}" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-primary-600 hover:text-primary-900">
                                        <a href="{{ route('product.show', $product->id) }}">{{ $product->name }}</a>
                                    </div>
                                    <div class="text-sm text-gray-500 mt-1 flex items-center">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @php
                                                $newVal1 = $i - 0.5;
                                                $fill = ($product->product_rating() >= $newVal1) ? 'text-yellow-400' : 'text-gray-300';
                                            @endphp
                                            <svg class="h-4 w-4 {{ $fill }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="!px-4 !py-2 whitespace-nowrap text-sm text-gray-500">
                            {{ !empty($product->product_category()) ? $product->product_category() : '-' }}
                        </td>
                        <td class="!px-4 !py-2 whitespace-nowrap text-sm text-gray-900 font-medium">
                            @if ($product->enable_product_variant == 'on')
                                {{ __('In Variant') }}
                            @else
                                {{ \App\Models\Utility::priceFormat($product->price) }}
                            @endif
                        </td>
                        <td class="!px-4 !py-2 whitespace-nowrap text-sm text-gray-500">
                            @if ($product->enable_product_variant == 'on')
                                {{ __('In Variant') }}
                            @else
                                {{ $product->quantity }}
                            @endif
                        </td>
                        <td class="!px-4 !py-2 whitespace-nowrap">
                            @if ($product->enable_product_variant == 'on')
                                <x-ui.badge variant="info">{{ __('In Variant') }}</x-ui.badge>
                            @else
                                @if ($product->quantity == 0)
                                    <x-ui.badge variant="danger">{{ __('Out of stock') }}</x-ui.badge>
                                @else
                                    <x-ui.badge variant="success">{{ __('In stock') }}</x-ui.badge>
                                @endif
                            @endif
                        </td>
                        <td class="!px-4 !py-2 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                @can('Show Products')
                                    <a href="{{ route('product.show', $product->id) }}" class="text-gray-400 hover:text-primary-600" title="{{ __('View') }}">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                @endcan
                                @can('Edit Products')
                                    <a href="{{ route('product.edit', $product->id) }}" class="text-gray-400 hover:text-primary-600" title="{{ __('Edit') }}">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                @endcan
                                @can('Delete Products')
                                    <a href="#" class="text-gray-400 hover:text-red-600 bs-pass-para"
                                        data-confirm="{{ __('Are You Sure?') }}"
                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                        data-confirm-yes="delete-form-{{ $product->id }}"
                                        title="{{ __('Delete') }}">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['product.destroy', $product->id], 'id' => 'delete-form-' . $product->id, 'class' => 'hidden']) !!}
                                    {!! Form::close() !!}
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-ui.table>
    @else
        <x-ui.card>
            <x-ui.empty-state 
                title="{{ __('No products found') }}" 
                description="{{ __('Get started by creating your first product.') }}"
            >
                <x-slot name="icon">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </x-slot>
                @can('Create Products')
                    <x-slot name="action">
                        <a href="{{ route('product.create') }}">
                            <x-ui.button variant="primary">{{ __('Add new product') }}</x-ui.button>
                        </a>
                    </x-slot>
                @endcan
            </x-ui.empty-state>
        </x-ui.card>
    @endif

</x-ui.page-container>

@endsection

@push('scripts')
    <script>
        $(document).on('click', '#billing_data', function() {
            $("[name='shipping_address']").val($("[name='billing_address']").val());
            $("[name='shipping_city']").val($("[name='billing_city']").val());
            $("[name='shipping_state']").val($("[name='billing_state']").val());
            $("[name='shipping_country']").val($("[name='billing_country']").val());
            $("[name='shipping_postalcode']").val($("[name='billing_postalcode']").val());
        })
    </script>
    <style>
        .dataTable-top, .dataTable-bottom {
            padding: 4px 10px !important;
        }
        .dataTable-container {
            margin-bottom: 0 !important;
        }
        .dataTable-wrapper {
            padding-bottom: 0 !important;
        }
    </style>
@endpush
