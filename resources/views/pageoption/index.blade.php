@extends('layouts.ui-admin')

@section('page-title', __('Custom Page'))

@push('style')
    <link rel="stylesheet" href="{{ asset('custom/libs/summernote/summernote-bs4.css') }}">
@endpush

@push('scripts')
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
    <script src="{{ asset('assets/js/plugins/tinymce/tinymce.min.js') }}"></script>
    <script>
        if ($(".pc-tinymce-2").length) {
            tinymce.init({
                selector: '.pc-tinymce-2',
                height: "400",
                content_style: 'body { font-family: "Inter", sans-serif; }',
                menubar:false,
                statusbar: false,
            });
        }
    </script>
@endpush

@section('content')
<x-ui.page-container>
    <x-ui.page-header title="{{ __('Custom Page') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Custom Page') }}</span>
        </x-slot>

        <x-slot name="actions">
            @can('Create Custom Page')
                <x-ui.button variant="primary" data-url="{{ route('custom-page.create') }}" data-title="{{ __('Create New Page') }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create') }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    {{ __('Create Page') }}
                </x-ui.button>
            @endcan
        </x-slot>
    </x-ui.page-header>

    <x-ui.table>
        <x-slot name="head">
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Name') }}</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Page Slug') }}</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Header') }}</th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Action') }}</th>
        </x-slot>
        <x-slot name="body">
            @foreach ($pageoptions as $pageoption)
                <tr data-name="{{ $pageoption->name }}">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $pageoption->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        @if ($store && $store->enable_domain == 'on')
                            {{ $store->domains . '/page/' . $pageoption->slug }}
                        @elseif($sub_store && $sub_store->enable_subdomain == 'on')
                            {{ $sub_store->subdomain . '/page/' . $pageoption->slug }}
                        @else
                            {{ env('APP_URL') . '/page/' . $pageoption->slug }}
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ ucfirst($pageoption->enable_page_header == 'on' ? $pageoption->enable_page_header : 'Off') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            @can('Edit Custom Page')
                                <x-ui.button variant="secondary" size="sm" data-title="{{ __('Edit Page') }}" data-url="{{ route('custom-page.edit', $pageoption->id) }}" data-ajax-popup="true" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Edit') }}">
                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                </x-ui.button>
                            @endcan
                            @can('Delete Custom Page')
                                <x-ui.button variant="danger" size="sm" class="bs-pass-para" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Delete') }}" data-title="{{ __('Delete Lead') }}" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="delete-form-{{ $pageoption->id }}">
                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                </x-ui.button>
                                {!! Form::open(['method' => 'DELETE', 'route' => ['custom-page.destroy', $pageoption->id], 'id' => 'delete-form-' . $pageoption->id]) !!}
                                {!! Form::close() !!}
                            @endcan
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-ui.table>
</x-ui.page-container>
@endsection
