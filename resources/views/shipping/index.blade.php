@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Shipping') }}
@endsection

@section('content')
<x-ui.page-container>
    <x-ui.page-header title="{{ __('Shipping') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Shipping') }}</span>
        </x-slot>

        <x-slot name="actions">
            <div class="flex items-center space-x-2">
                <a href="{{ route('shipping.export') }}">
                    <x-ui.button variant="secondary" title="{{ __('Export') }}">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Export
                    </x-ui.button>
                </a>
                @can('Create Shipping')
                    <a href="#!" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Import') }}" data-ajax-popup="true" data-size="lg" data-title="{{ __('Import Shipping CSV File') }}" data-url="{{ route('shipping.file.import') }}">
                        <x-ui.button variant="secondary">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            Import
                        </x-ui.button>
                    </a>
                @endcan
            </div>
        </x-slot>
    </x-ui.page-header>

    <div class="row">
        <div class="col-sm-12 col-md-4 col-xxl-3">
            <div class="p-2 card">
                <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-user-tab-1" data-bs-toggle="pill"
                            data-bs-target="#pills-user-1" type="button">
                            <i class="fas fa-location-arrow mx-2"></i>{{ __('Location') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-user-tab-2" data-bs-toggle="pill"
                            data-bs-target="#pills-user-2" type="button">
                            <i class="fas fa-shipping-fast mx-2"></i>{{ __('Shipping') }}
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="col-sm-12 col-md-12 col-xxl-12">
            <div class="card">
                <div class="card-body location-table-wrp pb-0">
                    <div class="tab-content" id="pills-tabContent">
                        
                        <!-- Location Tab -->
                        <div class="tab-pane fade show active" id="pills-user-1" role="tabpanel" aria-labelledby="pills-user-tab-1">
                            <div class="d-flex justify-content-between action-btn-wrapper align-items-center mb-3">
                                <h3 class="mb-0 text-lg font-semibold text-zinc-900">{{ __('Location') }}</h3>
                                @can('Create Location')
                                    <a href="#" data-url="{{ route('location.create') }}" data-title="{{ __('Create New Location') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create New Location') }}">
                                        <x-ui.button variant="primary">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            {{ __('Create New Location') }}
                                        </x-ui.button>
                                    </a>
                                @endcan
                            </div>
                            <div class="row">
                                <div class="card-body pb-0 table-border-style">
                                    <div class="table-responsive">
                                        <table class="table mb-0 dataTable">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Name') }}</th>
                                                    <th>{{ __('Created At') }}</th>
                                                    <th>{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($locations as $location)
                                                    <tr data-name="{{ $location->name }}">
                                                        <td>{{ $location->name }}</td>
                                                        <td>{{ \App\Models\Utility::dateFormat($location->created_at) }}</td>
                                                        <td>
                                                            <div class="d-flex action-btn-wrapper">
                                                                @can('Edit Location')
                                                                    <a href="#!" class="btn btn-sm btn-icon bg-info text-white me-2" data-title="{{ __('Edit Location') }}" data-url="{{ route('location.edit', $location->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Edit') }}">
                                                                        <i class="ti ti-pencil f-20"></i>
                                                                    </a>
                                                                @endcan
                                                                @can('Delete Location')
                                                                    <a class="bs-pass-para btn btn-sm btn-icon bg-danger text-white" href="#"
                                                                        data-title="{{ __('Delete Lead') }}"
                                                                        data-confirm="{{ __('Are You Sure?') }}"
                                                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                                        data-confirm-yes="delete-form-{{ $location->id }}"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        title="{{ __('Delete') }}">
                                                                        <i class="ti ti-trash f-20"></i>
                                                                    </a>
                                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['location.destroy', $location->id], 'id' => 'delete-form-' . $location->id]) !!}
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
                        
                        <!-- Shipping Tab -->
                        <div class="tab-pane fade" id="pills-user-2" role="tabpanel" aria-labelledby="pills-user-tab-2">
                            <div class="d-flex justify-content-between action-btn-wrapper align-items-center mb-3">
                                <h3 class="mb-0 text-lg font-semibold text-zinc-900">{{ __('Shipping') }}</h3>
                                @can('Create Shipping')
                                    <a href="#" data-url="{{ route('shipping.create') }}" data-title="{{ __('Create New Shipping') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create New Shipping') }}">
                                        <x-ui.button variant="primary">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            {{ __('Create New Shipping') }}
                                        </x-ui.button>
                                    </a>
                                @endcan
                            </div>
                            <div class="row">
                                <div class="card-body pb-0 table-border-style">
                                    <div class="table-responsive">
                                        <table class="table mb-0 dataTable1">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('Name') }}</th>
                                                    <th>{{ __('Price') }}</th>
                                                    <th>{{ __('Location') }}</th>
                                                    <th>{{ __('Created At') }}</th>
                                                    <th>{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($shippings as $shipping)
                                                    <tr data-name="{{ $shipping->name }}">
                                                        <td>{{ $shipping->name }}</td>
                                                        <td>{{ \App\Models\Utility::priceFormat($shipping->price) }}</td>
                                                        <td>{{ !empty($shipping->locationName()) ? $shipping->locationName() : '-' }}</td>
                                                        <td>{{ \App\Models\Utility::dateFormat($shipping->created_at) }}</td>
                                                        <td class="Action">
                                                            <div class="d-flex action-btn-wrapper">
                                                                @can('Edit Shipping')
                                                                    <a href="#!" class="btn btn-sm btn-icon bg-info text-white me-2" data-title="{{ __('Edit Shipping') }}" data-url="{{ route('shipping.edit', $shipping->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Edit') }}">
                                                                        <i class="ti ti-pencil f-20"></i>
                                                                    </a>
                                                                @endcan
                                                                @can('Delete Shipping')
                                                                    <a class="bs-pass-para btn btn-sm btn-icon bg-danger text-white" href="#"
                                                                        data-title="{{ __('Delete Lead') }}"
                                                                        data-confirm="{{ __('Are You Sure?') }}"
                                                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                                        data-confirm-yes="delete-form-{{ $shipping->id }}"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                                        title="{{ __('Delete') }}">
                                                                        <i class="ti ti-trash f-20"></i>
                                                                    </a>
                                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['shipping.destroy', $shipping->id], 'id' => 'delete-form-' . $shipping->id]) !!}
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
                </div>
            </div>
        </div>
    </div>
</x-ui.page-container>
@endsection
