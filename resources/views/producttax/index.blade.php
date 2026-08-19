@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Product Tax') }}
@endsection

@section('content')
<x-ui.page-container>
    <x-ui.page-header title="{{ __('Product Tax') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Product Tax') }}</span>
        </x-slot>

        <x-slot name="actions">
            @can('Create Product Tax')
                <x-ui.button variant="primary" data-url="{{ route('product_tax.create') }}" data-title="{{ __('Create New Product Tax') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create') }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    {{ __('Create New Product Tax') }}
                </x-ui.button>
            @endcan
        </x-slot>
    </x-ui.page-header>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body pb-0 table-border-style">
                    <div class="table-responsive order-table-wrp">
                        <table class="table mb-0 dataTable">
                            <thead>
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">{{ __('Tax Name') }}</th>
                                    <th scope="col" class="sort" data-sort="name">{{ __('Rate %') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product_taxs as $product_tax)
                                    <tr data-name="{{ $product_tax->name }}">
                                        <td>{{ $product_tax->name }}</td>
                                        <td>{{ $product_tax->rate }}</td>
                                        <td class="Action">
                                            <div class="d-flex action-btn-wrapper">
                                                @can('Edit Product Tax')
                                                    <a href="#!" class="btn btn-sm btn-icon bg-info text-white me-2" data-url="{{ route('product_tax.edit', $product_tax->id) }}" data-tooltip="Edit" data-ajax-popup="true" data-title="{{ __('Edit Tax') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil f-20"></i>
                                                    </a>
                                                @endcan
                                                @can('Delete Product Tax')
                                                    <a class="bs-pass-para btn btn-sm btn-icon bg-danger text-white" href="#"
                                                        data-title="{{ __('Delete Tax') }}"
                                                        data-confirm="{{ __('Are You Sure?') }}"
                                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                        data-confirm-yes="delete-form-{{ $product_tax->id }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('Delete') }}">
                                                        <i class="ti ti-trash f-20"></i>
                                                    </a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['product_tax.destroy', $product_tax->id], 'id' => 'delete-form-' . $product_tax->id]) !!}
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
