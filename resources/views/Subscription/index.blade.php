@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Subscriber') }}
@endsection

@section('content')
<x-ui.page-container>
    <x-ui.page-header title="{{ __('Subscriber') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Subscriber') }}</span>
        </x-slot>

        <x-slot name="actions">
            @can('Create Subscriber')
                <a href="#" data-url="{{ route('subscriptions.create') }}" data-title="{{ __('Add Subscriber') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Add Subscriber') }}">
                    <x-ui.button variant="primary">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        {{ __('Add Subscriber') }}
                    </x-ui.button>
                </a>
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
                                    <th>{{ __('Email') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subs as $sub)
                                    <tr data-name="{{ $sub->email }}">
                                        <td>{{ $sub->email }}</td>
                                        <td class="Action">
                                            @can('Delete Subscriber')
                                                <div class="d-flex action-btn-wrapper">
                                                    <a class="bs-pass-para btn btn-sm btn-icon bg-danger text-white" href="#"
                                                        data-title="{{ __('Delete Lead') }}"
                                                        data-confirm="{{ __('Are You Sure?') }}"
                                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                        data-confirm-yes="delete-form-{{ $sub->id }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('Delete') }}">
                                                        <i class="ti ti-trash f-20"></i>
                                                    </a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['subscriptions.destroy', $sub->id], 'id' => 'delete-form-' . $sub->id]) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            @endcan
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
