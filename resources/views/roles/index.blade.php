@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Roles') }}
@endsection

@section('content')
<x-ui.page-container>
    <x-ui.page-header title="{{ __('Roles') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Roles') }}</span>
        </x-slot>

        <x-slot name="actions">
            <a href="#" data-url="{{ route('roles.create') }}" data-title="{{ __('Add Role') }}" data-size="lg" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create') }}">
                <x-ui.button variant="primary">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    {{ __('Add Role') }}
                </x-ui.button>
            </a>
        </x-slot>
    </x-ui.page-header>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pb-0 table-border-style">
                    <div class="table-responsive">
                        <table class="table" id="pc-dt-simple">
                            <thead>
                                <tr>
                                    <th>{{ __('Role') }}</th>
                                    <th>{{ __('Permissions') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->name }}</td>
                                        <td class="permissions-item-wrp" style="white-space: inherit">
                                            @foreach ($role->permissions()->pluck('name') as $permission)
                                                <span class="badge p-2 m-1 px-3 bg-primary text-white">
                                                    {{ $permission }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="d-flex action-btn-wrapper">
                                                @can('Edit Role')
                                                    <a href="#!" class="btn btn-sm btn-icon bg-info text-white me-2"
                                                        data-url="{{ URL::to('roles/' . $role->id . '/edit')}}"
                                                        data-ajax-popup="true" data-size="lg" data-bs-toggle="tooltip" title=""
                                                        data-title="{{ __('Edit Role') }}"
                                                        data-bs-original-title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil"></i>
                                                    </a>
                                                @endcan
                                                @can('Delete Role')
                                                    <a class="bs-pass-para btn btn-sm btn-icon bg-danger text-white" href="#"
                                                        data-title="{{ __('Delete Role') }}"
                                                        data-confirm="{{ __('Are You Sure?') }}"
                                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                        data-confirm-yes="delete-form-{{ $role->id }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('Delete') }}">
                                                        <i class="ti ti-trash f-20"></i>
                                                    </a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id], 'id' => 'delete-form-' . $role->id]) !!}
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
