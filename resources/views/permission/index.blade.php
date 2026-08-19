@extends('layouts.ui-admin')

@section('page-title', __('Permission'))

@section('content')
<x-ui.page-container>
    <x-ui.page-header title="{{ __('Permission') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Dashboard') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Permission') }}</span>
        </x-slot>

        <x-slot name="actions">
            <x-ui.button variant="primary" data-url="{{ route('permissions.create') }}" data-ajax-popup="true" data-title="{{ __('Add Permission') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ __('Add Permission') }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                {{ __('Add Permission') }}
            </x-ui.button>
        </x-slot>
    </x-ui.page-header>

    <x-ui.table>
        <x-slot name="head">
            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 85%;">{{ __('Title') }}</th>
            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider" style="width: 15%;">{{ __('Action') }}</th>
        </x-slot>
        <x-slot name="body">
            @foreach ($permissions as $permission)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                        {{ $permission->name }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end space-x-2">
                            <x-ui.button variant="secondary" size="sm" data-url="{{ route('permissions.edit', $permission->id) }}" data-size="lg" data-ajax-popup="true" data-title="{{ __('Update permission') }}" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ __('Edit') }}">
                                <span class="material-symbols-outlined text-[16px]">edit</span>
                            </x-ui.button>
                            <x-ui.button variant="danger" size="sm" class="bs-pass-para" data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ __('Delete') }}" data-confirm="{{ __('Are You Sure?') . '|' . __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="document.getElementById('delete-form-{{ $permission->id }}').submit();">
                                <span class="material-symbols-outlined text-[16px]">delete</span>
                            </x-ui.button>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['permissions.destroy', $permission->id], 'id' => 'delete-form-' . $permission->id]) !!}
                            {!! Form::close() !!}
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-ui.table>
</x-ui.page-container>
@endsection
