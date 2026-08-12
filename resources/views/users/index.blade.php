@extends('layouts.ui-admin')

@section('page-title', __('Users'))

@php
$profile = \App\Models\Utility::get_file('uploads/profile/');
$logo = \App\Models\Utility::get_file('uploads/profile/');
@endphp

@section('content')
<x-ui.page-container>
    
    <x-ui.page-header title="{{ __('Users') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Users') }}</span>
        </x-slot>

        <x-slot name="actions">
            <div class="flex items-center space-x-2">
                @can('Create User')
                    <a href="#" data-url="{{ route('users.create') }}" data-title="{{ __('Add User') }}" data-ajax-popup="true">
                        <x-ui.button variant="primary">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            {{ __('Add User') }}
                        </x-ui.button>
                    </a>
                @endcan
            </div>
        </x-slot>
    </x-ui.page-header>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($users as $user)
            <x-ui.card class="text-center relative hover:shadow-md transition-shadow">
                <div class="p-6">
                    <div class="absolute top-4 left-4">
                        <x-ui.badge variant="info">{{ ucfirst($user->type) }}</x-ui.badge>
                    </div>

                    @if (Gate::check('Edit User') || Gate::check('Delete User'))
                        <div class="absolute top-4 right-4" x-data="{ open: false }">
                            @if($user->is_active == 1)
                                <button @click="open = !open" @click.away="open = false" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                </button>
                            @else
                                <div class="text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </div>
                            @endif

                            <div x-show="open" style="display: none;" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10 text-left">
                                <div class="py-1">
                                    @can('Edit User')
                                        <a href="#" data-url="{{ route('users.edit', $user->id) }}" data-size="md" data-ajax-popup="true" data-title="{{ __('Update User') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            {{ __('Edit') }}
                                        </a>
                                    @endcan
                                    @can('Reset Password')
                                        <a href="#" data-url="{{ route('users.reset', \Crypt::encrypt($user->id)) }}" data-ajax-popup="true" data-size="md" data-title="{{ __('Change Password') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            {{ __('Reset Password') }}
                                        </a>
                                    @endcan
                                    @can('Delete User')
                                        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 bs-pass-para"
                                            data-confirm="{{ __('Are You Sure?') }}"
                                            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                            data-confirm-yes="delete-form-{{ $user->id }}">
                                            {{ __('Delete') }}
                                        </a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'id' => 'delete-form-' . $user->id, 'class' => 'hidden']) !!}
                                        {!! Form::close() !!}
                                    @endcan

                                    <div class="border-t border-gray-100"></div>

                                    @if ($user->is_enable_login == 1)
                                        <a href="{{ route('owner.users.login', \Crypt::encrypt($user->id)) }}" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                            {{ __('Login Disable') }}
                                        </a>
                                    @elseif ($user->is_enable_login == 0 && $user->password == null)
                                        <a href="#" data-url="{{ route('users.reset', \Crypt::encrypt($user->id)) }}"
                                            data-ajax-popup="true" data-size="md" class="block px-4 py-2 text-sm text-green-600 hover:bg-gray-100 login_enable"
                                            data-title="{{ __('New Password') }}">
                                            {{ __('Login Enable') }}
                                        </a>
                                    @else
                                        <a href="{{ route('owner.users.login', \Crypt::encrypt($user->id)) }}" class="block px-4 py-2 text-sm text-green-600 hover:bg-gray-100">
                                            {{ __('Login Enable') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mt-4 flex justify-center">
                        <a href="{{ !empty($user->avatar) ? ($profile . $user->avatar) : $logo.'avatar.png' }}" target="_blank">
                            <img src="{{ !empty($user->avatar) ? ($profile . $user->avatar) : $logo.'avatar.png' }}" class="h-24 w-24 rounded-full object-cover border-4 border-gray-50" alt="{{ $user->name }}">
                        </a>
                    </div>
                    
                    <h3 class="mt-4 text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $user->email }}</p>
                </div>
            </x-ui.card>
        @endforeach

        @can('Create User')
            <a href="#" data-url="{{ route('users.create') }}" data-title="{{ __('Add User') }}" data-ajax-popup="true" class="block">
                <div class="h-full border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors flex flex-col items-center justify-center p-6 min-h-[250px]">
                    <div class="bg-primary-100 text-primary-600 rounded-full p-3 mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">{{ __('New User') }}</h3>
                    <p class="text-sm text-gray-500 mt-1 text-center">{{ __('Click here to add New User') }}</p>
                </div>
            </a>
        @endcan
    </div>

</x-ui.page-container>

@endsection

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
        $(document).on('click', '.login_enable', function() {
            setTimeout(function() {
                $('.login_field').append($('<input>', {
                    type: 'hidden',
                    val: 'true',
                    name: 'login_enable'
                }));
            }, 2000);
        });
    </script>
@endpush
