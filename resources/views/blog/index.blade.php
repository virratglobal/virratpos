@php
$store_logo = \App\Models\Utility::get_file('uploads/blog_cover_image/');
@endphp

@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Blog') }}
@endsection

@push('css-page')
    <link rel="stylesheet" href="{{ asset('custom/libs/summernote/summernote-bs4.css') }}">
@endpush

@push('script-page')
    <script src="{{ asset('custom/libs/summernote/summernote-bs4.js') }}"></script>
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

@section('content')
<x-ui.page-container>
    <x-ui.page-header title="{{ __('Blog') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Blog') }}</span>
        </x-slot>

        <x-slot name="actions">
            @can('Create Blog')
                <a href="#" data-url="{{ route('blog.create') }}" data-title="{{ __('Create New Blog') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create') }}">
                    <x-ui.button variant="primary">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        {{ __('Create New Blog') }}
                    </x-ui.button>
                </a>
            @endcan
        </x-slot>
    </x-ui.page-header>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body pb-0 table-border-style">
                    <div class="table-responsive">
                        <table class="table mb-0 dataTable">
                            <thead>
                                <tr>
                                    <th>{{ __('Blog Cover Image') }}</th>
                                    <th>{{ __('Title') }}</th>
                                    <th>{{ __('Created At') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $blog)
                                    <tr data-name="{{ $blog->title }}">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if (!empty($blog->blog_cover_image))
                                                    <a href="{{ $store_logo . $blog->blog_cover_image }}" target="_blank">
                                                        <img alt="Image placeholder" src="{{ $store_logo . $blog->blog_cover_image }}" class="border border-2 border-primary rounded theme-avtar" style="width: 40px; height: 40px; object-fit: cover;">
                                                    </a>
                                                @else
                                                    <a href="{{ $store_logo . '/avatar.png' }}" target="_blank">
                                                        <img alt="Image placeholder" src="{{ $store_logo . '/avatar.png' }}" class="border border-2 border-primary rounded theme-avtar" style="width: 40px; height: 40px; object-fit: cover;">
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $blog->title }}</td>
                                        <td>{{ \App\Models\Utility::dateFormat($blog->created_at) }}</td>
                                        <td class="Action">
                                            <div class="d-flex action-btn-wrapper">
                                                @can('Edit Blog')
                                                    <a href="#!" class="btn btn-sm btn-icon bg-info text-white me-2" data-url="{{ route('blog.edit', $blog->id) }}" data-title="{{ __('Edit Blog') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil f-20"></i>
                                                    </a>
                                                @endcan
                                                @can('Delete Blog')
                                                    <a class="bs-pass-para btn btn-sm btn-icon bg-danger text-white" href="#"
                                                        data-title="{{ __('Delete Lead') }}"
                                                        data-confirm="{{ __('Are You Sure?') }}"
                                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                        data-confirm-yes="delete-form-{{ $blog->id }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="{{ __('Delete') }}">
                                                        <i class="ti ti-trash f-20"></i>
                                                    </a>
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['blog.destroy', $blog->id], 'id' => 'delete-form-' . $blog->id]) !!}
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
