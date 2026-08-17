@php
$store_logo=\App\Models\Utility::get_file('uploads/product_image/');
@endphp

@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Product Category') }}
@endsection

@section('content')
<x-ui.page-container>
    <x-ui.page-header title="{{ __('Product Category') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Product Category') }}</span>
        </x-slot>

        <x-slot name="actions">
            @can('Create Product category')
                <a href="#" data-ajax-popup="true" data-url="{{ route('product_categorie.create') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create') }}" data-title="{{ __('Create New Product Category') }}">
                    <x-ui.button variant="primary">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        {{ __('Create New Product Category') }}
                    </x-ui.button>
                </a>
            @endcan
        </x-slot>
    </x-ui.page-header>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body pb-0 table-border-style">
                    <div class="table-responsive order-table-wrp">
                        <table class="table dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('Product Image') }}</th>
                                    <th>{{ __('Category Name') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product_categorys as $product_category)
                                    <tr data-name="{{ $product_category->name }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($product_category->categorie_img)
                                                    <img src="{{ $store_logo }}/{{ $product_category->categorie_img }}" alt="" class="theme-avtar border border-2 border-primary rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <img src="{{ $store_logo }}/default.jpg" alt="" class="theme-avtar border border-2 border-primary rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $product_category->name }}</td>
                                        <td>
                                            <div class="d-flex action-btn-wrapper">
                                                @can('Edit Product category')
                                                    <a href="#!" class="btn btn-sm btn-icon bg-info text-white me-2" data-url="{{ route('product_categorie.edit', $product_category->id) }}" data-ajax-popup="true" data-title="{{ __('Edit Category') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Edit') }}" data-tooltip="Edit">
                                                        <i class="ti ti-pencil f-20"></i>
                                                    </a>
                                                @endcan
                                                @can('Delete Product category')
                                                    <a href="#!" class="bs-pass-para btn btn-sm btn-icon bg-danger text-white" data-title="{{ __('Delete Lead') }}" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="delete-form-{{ $product_category->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Delete') }}">
                                                        <i class="ti ti-trash f-20"></i>
                                                    </a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['product_categorie.destroy', $product_category->id], 'id' => 'delete-form-' . $product_category->id]) !!}
                                                    {!! Form::close() !!}
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-ui.page-container>
@endsection

@push('script-page')
    <script>
        $(document).ready(function() {
            $(document).on('keyup', '.search-user', function() {
                var value = $(this).val();
                $('.employee_tableese tbody>tr').each(function(index) {
                    var name = $(this).attr('data-name').toLowerCase();
                    if (name.includes(value.toLowerCase())) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
@endpush
