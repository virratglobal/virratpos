@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Location') }}
@endsection

@section('content')
<x-ui.page-container>
    <x-ui.page-header title="{{ __('Location') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Location') }}</span>
        </x-slot>

        <x-slot name="actions">
            <x-ui.button variant="primary" data-size="lg" data-url="{{ route('location.create') }}" data-ajax-popup="true" data-title="{{ __('Create New Location') }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                {{ __('Create New Location') }}
            </x-ui.button>
        </x-slot>
    </x-ui.page-header>

    <div class="card">
        <div class="table-responsive">
            <div class="employee_menu view_employee">
                <div class="card-header actions-toolbar border-0">
                    <div class="row justify-content-between align-items-center">
                        <div class="col">
                            <h6 class="d-inline-block mb-0 text-capitalize">{{ __('Location List') }}</h6>
                        </div>
                        <div class="col text-right">
                            <div class="actions">
                                <div class="rounded-pill d-inline-block search_round">
                                    <div class="input-group input-group-sm input-group-merge input-group-flush">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent"><i class="fas fa-search"></i></span>
                                        </div>
                                        <input type="text" id="user_keyword" class="form-control form-control-flush search-user" placeholder="{{ __('Search Location') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Table -->
                <div class="table-responsive">
                    <table class="table align-items-center employee_tableese">
                        <thead>
                            <tr>
                                <th scope="col" class="sort" data-sort="name">{{ __('Name') }}</th>
                                <th scope="col" class="sort" data-sort="name">{{ __('Created At') }}</th>
                                <th class="text-right">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($locations as $location)
                                <tr data-name="{{$location->name}}">
                                    <td class="sorting_1">{{$location->name}}</td>
                                    <td class="sorting_1">{{\App\Models\Utility::dateFormat($location->created_at)}}</td>
                                    <td class="action text-right">
                                        <div class="d-flex justify-content-end action-btn-wrapper">
                                            <a href="#" data-size="lg" data-url="{{ route('location.edit',$location->id) }}" data-toggle="tooltip" data-original-title="{{ __('Edit') }}" data-ajax-popup="true" data-title="{{ __('Edit Location') }}" class="btn btn-sm btn-icon bg-info text-white me-2">
                                                <i class="ti ti-pencil"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-icon bg-danger text-white" data-toggle="tooltip" data-original-title="{{ __('Delete') }}" data-confirm="{{ __('Are You Sure?').' | '.__('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="document.getElementById('delete-form-{{$location->id}}').submit();">
                                                <i class="ti ti-trash"></i>
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['location.destroy', $location->id],'id'=>'delete-form-'.$location->id]) !!}
                                            {!! Form::close() !!}
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
</x-ui.page-container>
@endsection

@push('script-page')
    <script>
        $(document).ready(function () {
            $(document).on('keyup', '.search-user', function () {
                var value = $(this).val();
                $('.employee_tableese tbody>tr').each(function (index) {
                    var name = $(this).attr('data-name');
                    if (name.includes(value)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
@endpush
