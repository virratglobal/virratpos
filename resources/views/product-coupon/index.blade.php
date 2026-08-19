@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Product Coupons') }}
@endsection

@push('script-page')
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

    <script>
        $(document).on('change', '#enable_flat', function() {
            if ($(this).is(':checked')) {
                $('#pro_flat_discount').attr("required", true);
                $('#discount').removeAttr("required");

            } else {
                $('#discount').attr("required", true);
                $('#pro_flat_discount').removeAttr("required");
            }
        });
    </script>
@endpush

@section('content')
<x-ui.page-container>
    <x-ui.page-header title="{{ __('Product Coupons') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Product Coupons') }}</span>
        </x-slot>

        <x-slot name="actions">
            <div class="flex items-center space-x-2">
                <a href="{{ route('productcoupon.export') }}">
                    <x-ui.button variant="secondary" title="{{ __('Export') }}">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Export
                    </x-ui.button>
                @can('Create Product Coupan')
                    <x-ui.button variant="secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Import') }}" data-ajax-popup="true" data-size="lg" data-title="{{ __('Import Product-coupan CSV File') }}" data-url="{{ route('productcoupon.file.import') }}">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Import
                    </x-ui.button>
                @endcan
                @can('Create Product Coupan')
                    <x-ui.button variant="primary" data-url="{{ route('product-coupon.create') }}" data-title="{{ __('Add Coupon') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create') }}">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        {{ __('Add Coupon') }}
                    </x-ui.button>
                @endcan
            </div>
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
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Code') }}</th>
                                    <th>{{ __('Discount') }}</th>
                                    <th>{{ __('Limit') }}</th>
                                    <th>{{ __('Used') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productcoupons as $coupon)
                                    <tr>
                                        <td>{{ $coupon->name }}</td>
                                        <td>{{ $coupon->code }}</td>
                                        @if ($coupon->enable_flat == 'off')
                                            <td>{{ $coupon->discount . '%' }}</td>
                                        @elseif ($coupon->enable_flat == 'on')
                                            <td>{{ $coupon->flat_discount . ' ' . '(Flat)' }}</td>
                                        @else
                                            <td>{{ $coupon->discount . '%' }}</td>
                                        @endif
                                        <td>{{ $coupon->limit }}</td>
                                        <td>{{ $coupon->product_coupon() }}</td>
                                        <td class="Action">
                                            <div class="d-flex action-btn-wrapper">
                                                @can('Show Product Coupan')
                                                    <a href="{{ route('product-coupon.show', $coupon->id) }}" class="btn btn-sm btn-icon bg-warning text-white me-2" data-tooltip="view" data-original-title="{{ __('View') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('View Coupon') }}">
                                                        <i class="ti ti-eye f-20"></i>
                                                    </a>
                                                @endcan
                                                @can('Edit Product Coupan')
                                                    <a href="#!" class="btn btn-sm btn-icon bg-info text-white me-2" data-title="{{ __('Edit Coupon') }}" data-url="{{ route('product-coupon.edit', $coupon->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil f-20"></i>
                                                    </a>
                                                @endcan
                                                @can('Delete Product Coupan')
                                                    <a class="bs-pass-para btn btn-sm btn-icon bg-danger text-white" href="#"
                                                        data-title="{{ __('Delete Lead') }}"
                                                        data-confirm="{{ __('Are You Sure?') }}"
                                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                        data-confirm-yes="delete-form-{{ $coupon->id }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('Delete') }}">
                                                        <i class="ti ti-trash f-20"></i>
                                                    </a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['product-coupon.destroy', $coupon->id], 'id' => 'delete-form-' . $coupon->id]) !!}
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
