@extends('layouts.ui-admin')

@section('page-title', __('Sub Domain'))

@push('scripts')
<script>
    $(document).on('change', '#password_switch', function() {
        if ($(this).is(':checked')) {
            $('.ps_div').removeClass('d-none');
            $('#password').attr("required", true);
        } else {
            $('.ps_div').addClass('d-none');
            $('#password').val(null);
            $('#password').removeAttr("required");
        }
    });
</script>
@endpush

@section('content')
<x-ui.page-container>
    <x-ui.page-header title="{{ __('Sub Domain') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <a href="{{ route('store-resource.index') }}" class="hover:text-gray-900">{{ __('Store') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Sub Domain') }}</span>
        </x-slot>

        <x-slot name="actions">
            <div class="flex items-center space-x-2">
                <a href="{{ route('store.customDomain') }}">
                    <x-ui.button variant="secondary">
                        {{ __('Custom Domain') }}
                    </x-ui.button>
                </a>
                <a href="{{ route('store.grid') }}">
                    <x-ui.button variant="secondary" title="{{ __('Grid View') }}">
                        <span class="material-symbols-outlined text-[16px]">grid_on</span>
                    </x-ui.button>
                </a>
                <a href="{{ route('store-resource.index') }}">
                    <x-ui.button variant="secondary" title="{{ __('List View') }}">
                        <span class="material-symbols-outlined text-[16px]">list</span>
                    </x-ui.button>
                </a>
                @can('Create Store')
                    <x-ui.button variant="primary" data-size="md" data-url="{{ route('store-resource.create') }}" data-ajax-popup="true" data-title="{{__('Create New Store')}}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Create New Store') }}">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        {{ __('Create Store') }}
                    </x-ui.button>
                @endcan
            </div>
        </x-slot>
    </x-ui.page-header>

    <x-ui.table>
        <x-slot name="head">
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Sub Domain Name') }}</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Store Name') }}</th>
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Email') }}</th>
        </x-slot>
        <x-slot name="body">
            @foreach($stores as $store)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $store->subdomain }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $store->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $store->email }}
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-ui.table>
</x-ui.page-container>
@endsection
