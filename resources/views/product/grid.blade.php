@extends('layouts.ui-admin')

@section('page-title', __('Product Grid'))

@section('content')
<x-ui.page-container>
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 style="font-family: 'Geist', sans-serif; font-size: 1.5rem; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">
                {{ __('Products') }}
            </h1>
            <p style="font-family: 'Inter', sans-serif; font-size: 14px; color: #767586; margin-top: 4px;">
                {{ __('Grid overview and management of your product catalog.') }}
            </p>
        </div>
        <div class="flex items-center space-x-2 mt-4 sm:mt-0">
            <a href="{{ route('product.export') }}">
                <x-ui.button variant="secondary" title="{{ __('Export') }}">
                    <span class="material-symbols-outlined text-[18px]">download</span>
                </x-ui.button>
            </a>
            @can('Create Products')
                <a href="#!" data-ajax-popup="true" data-size="lg" data-title="{{ __('Import Product CSV File') }}" data-url="{{ route('product.file.import') }}">
                    <x-ui.button variant="secondary" title="{{ __('Import') }}">
                        <span class="material-symbols-outlined text-[18px]">upload</span>
                    </x-ui.button>
                </a>
            @endcan
            <a href="{{ route('product.index') }}">
                <x-ui.button variant="secondary" title="{{ __('List View') }}">
                    <span class="material-symbols-outlined text-[18px]">list</span>
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
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
        @foreach ($products as $product)
            <div class="bg-white rounded-xl border border-gray-150 p-5 flex flex-col justify-between shadow-sm relative group">
                <div>
                    {{-- Dropdown options --}}
                    <div class="absolute top-4 right-4 z-10" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="text-gray-400 hover:text-gray-600 bg-transparent border-none cursor-pointer p-1 rounded">
                            <span class="material-symbols-outlined text-[20px]">more_vert</span>
                        </button>
                        <div x-show="open" style="display: none; position: absolute; right: 0; margin-top: 4px; width: 150px; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 24px rgba(0,0,0,0.1); border: 1px solid rgba(199,196,215,0.2); padding: 4px;" class="z-50">
                            @can('Show Products')
                                <a href="{{ route('product.show', $product->id) }}" class="flex items-center gap-2 px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 rounded no-underline">
                                    <span class="material-symbols-outlined text-[16px]">visibility</span>
                                    <span>{{ __('View') }}</span>
                                </a>
                            @endcan
                            @can('Edit Products')
                                <a href="{{ route('product.edit', $product->id) }}" class="flex items-center gap-2 px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 rounded no-underline">
                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                    <span>{{ __('Edit') }}</span>
                                </a>
                            @endcan
                            @can('Delete Products')
                                <a href="#" class="bs-pass-para flex items-center gap-2 px-3 py-2 text-xs text-red-600 hover:bg-red-50 rounded no-underline" data-title="{{ __('Delete Lead') }}" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="delete-form-{{ $product->id }}">
                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                    <span>{{ __('Delete') }}</span>
                                </a>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['product.destroy', $product->id], 'id' => 'delete-form-' . $product->id]) !!}
                                {!! Form::close() !!}
                            @endcan
                        </div>
                    </div>

                    {{-- Image container --}}
                    <div class="w-full h-40 bg-gray-50 rounded-lg overflow-hidden mb-4 border border-gray-100 flex items-center justify-center">
                        @if (!empty($product->is_cover))
                            <a href="{{ asset(Storage::url('uploads/is_cover_image/' . $product->is_cover)) }}" target="_blank" class="w-full h-full block">
                                <img alt="{{ $product->name }}" src="{{ asset(Storage::url('uploads/is_cover_image/' . $product->is_cover)) }}" class="w-full h-full object-cover">
                            </a>
                        @else
                            <a href="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" target="_blank" class="w-full h-full block">
                                <img alt="{{ $product->name }}" src="{{ asset(Storage::url('uploads/is_cover_image/default.jpg')) }}" class="w-full h-full object-cover">
                            </a>
                        @endif
                    </div>

                    {{-- Product Info --}}
                    <h3 class="text-sm font-semibold text-gray-900 m-0">
                        <a href="{{ route('product.show', $product->id) }}" class="no-underline text-gray-900 hover:text-indigo-600 transition-colors">{{ $product->name }}</a>
                    </h3>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-sm font-bold text-indigo-600">{{ \App\Models\Utility::priceFormat($product->price) }}</span>
                        @if ($product->enable_product_variant != 'on')
                            @if ($product->quantity == 0)
                                <span class="px-2 py-0.5 text-[10px] font-semibold rounded bg-red-50 text-red-600 border border-red-200">
                                    {{ __('Out of stock') }}
                                </span>
                            @else
                                <span class="px-2 py-0.5 text-[10px] font-semibold rounded bg-green-50 text-green-600 border border-green-200">
                                    {{ __('In stock') }}
                                </span>
                            @endif
                        @endif
                    </div>
                </div>

                {{-- Rating & Footer --}}
                <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
                    <div class="flex items-center space-x-0.5 text-amber-400">
                        @for ($i = 1; $i <= 5; $i++)
                            @php
                                $icon = 'star';
                                $isHalf = false;
                                $newVal1 = $i - 0.5;
                                if ($product->product_rating() < $i && $product->product_rating() >= $newVal1) {
                                    $icon = 'star_half';
                                }
                                $colorClass = ($product->product_rating() >= $newVal1) ? 'text-amber-400' : 'text-gray-300';
                            @endphp
                            <span class="material-symbols-outlined {{ $colorClass }} text-[18px] select-none">{{ $icon }}</span>
                        @endfor
                    </div>
                    <span class="text-xs text-gray-400">({{ $product->product_rating() }})</span>
                </div>
            </div>
        @endforeach

        @can('Create Products')
            <a href="{{ route('product.create') }}" class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200 border-2 border-dashed border-gray-300 rounded-xl p-6 flex flex-col items-center justify-center text-center cursor-pointer no-underline">
                <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-[24px]">add</span>
                </div>
                <h3 class="text-sm font-semibold text-gray-900 m-0">{{ __('New Product') }}</h3>
                <p class="text-xs text-gray-500 mt-2 max-w-[200px]">{{ __('Click here to add a new product page instantly.') }}</p>
            </a>
        @endcan
    </div>
</x-ui.page-container>
@endsection
