@extends('layouts.ui-admin')

@section('page-title', __('Store Grid'))

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

@section('content')
<x-ui.page-container>
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div>
            <h1 style="font-family: 'Geist', sans-serif; font-size: 1.5rem; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">
                {{ __('Stores Management') }}
            </h1>
            <p style="font-family: 'Inter', sans-serif; font-size: 14px; color: #767586; margin-top: 4px;">
                {{ __('Grid overview and control of all active merchant storefronts on the platform.') }}
            </p>
        </div>
        <div class="flex items-center space-x-2 mt-4 sm:mt-0">
            <a href="{{ route('store.subDomain') }}">
                <x-ui.button variant="secondary">
                    {{ __('Sub Domain') }}
                </x-ui.button>
            </a>
            <a href="{{ route('store.customDomain') }}">
                <x-ui.button variant="secondary">
                    {{ __('Custom Domain') }}
                </x-ui.button>
            </a>
            <a href="{{ route('store-resource.index') }}">
                <x-ui.button variant="secondary" title="{{ __('List View') }}">
                    <span class="material-symbols-outlined text-[18px]">list</span>
                </x-ui.button>
            </a>
            @can('Create Store')
                <x-ui.button variant="primary" data-size="md" data-url="{{ route('store-resource.create') }}" data-ajax-popup="true" data-title="{{ __('Create New Store') }}" title="{{ __('Create') }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    {{ __('New Store') }}
                </x-ui.button>
            @endcan
        </div>
    </div>

    @if(\Auth::user()->type == 'super admin')
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            @foreach($users as $user)
                <div class="bg-white rounded-xl border border-gray-150 p-6 flex flex-col justify-between shadow-sm relative group">
                    <div>
                        {{-- Card Header Options --}}
                        <div class="absolute top-4 right-4 z-10" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" class="text-gray-400 hover:text-gray-600 bg-transparent border-none cursor-pointer p-1 rounded">
                                <span class="material-symbols-outlined text-[20px]">more_vert</span>
                            </button>
                            <div x-show="open" style="display: none; position: absolute; right: 0; margin-top: 4px; width: 180px; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 24px rgba(0,0,0,0.1); border: 1px solid rgba(199,196,215,0.2); padding: 4px;" class="z-50">
                                @can('Edit Store')
                                    <a href="#" data-size="md" data-url="{{ route('store-resource.edit',$user->id) }}" data-ajax-popup="true" data-title="{{ __('Edit Store') }}" class="flex items-center gap-2 px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 rounded no-underline">
                                        <span class="material-symbols-outlined text-[16px]">edit</span>
                                        <span>{{ __('Edit') }}</span>
                                    </a>
                                @endcan
                                @can('Upgrade Plans')
                                    <a href="#" data-size="md" data-url="{{ route('plan.upgrade',$user->id) }}" data-ajax-popup="true" data-title="{{ __('Upgrade Plan') }}" class="flex items-center gap-2 px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 rounded no-underline">
                                        <span class="material-symbols-outlined text-[16px]">military_tech</span>
                                        <span>{{ __('Upgrade Plan') }}</span>
                                    </a>
                                @endcan
                                @can('Reset Password')
                                    <a href="#" data-size="md" data-url="{{ route('user.reset', \Crypt::encrypt($user->id)) }}" data-ajax-popup="true" data-title="{{ __('Reset Password') }}" class="flex items-center gap-2 px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 rounded no-underline">
                                        <span class="material-symbols-outlined text-[16px]">key</span>
                                        <span>{{ __('Reset Password') }}</span>
                                    </a>
                                @endcan
                                @if(Auth::user()->type == "super admin")
                                    <a href="{{ route('login.with.owner', $user->id) }}" class="flex items-center gap-2 px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 rounded no-underline">
                                        <span class="material-symbols-outlined text-[16px]">login</span>
                                        <span>{{ __('Login As Owner') }}</span>
                                    </a>
                                    <a href="#" data-size="lg" data-url="{{ route('store.links', $user->id) }}" data-ajax-popup="true" data-title="{{ __('Store Links') }}" class="flex items-center gap-2 px-3 py-2 text-xs text-gray-700 hover:bg-gray-50 rounded no-underline">
                                        <span class="material-symbols-outlined text-[16px]">link</span>
                                        <span>{{ __('Store Links') }}</span>
                                    </a>
                                @endif
                                @if($user->id != 2)
                                    @can('Delete Store')
                                        <a href="#" class="bs-pass-para flex items-center gap-2 px-3 py-2 text-xs text-red-600 hover:bg-red-50 rounded no-underline" data-title="{{ __('Delete') }}" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="delete-form-{{ $user->id }}">
                                            <span class="material-symbols-outlined text-[16px]">delete</span>
                                            <span>{{ __('Delete') }}</span>
                                        </a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['store-resource.destroy', $user->id], 'id' => 'delete-form-' . $user->id]) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                @endif
                                @if ($user->is_enable_login == 1)
                                    <a href="{{ route('users.login', \Crypt::encrypt($user->id)) }}" class="flex items-center gap-2 px-3 py-2 text-xs text-red-600 hover:bg-red-50 rounded no-underline">
                                        <span class="material-symbols-outlined text-[16px]">block</span>
                                        <span>{{ __('Login Disable') }}</span>
                                    </a>
                                @elseif ($user->is_enable_login == 0 && $user->password == null)
                                    <a href="#" data-url="{{ route('user.reset', \Crypt::encrypt($user->id)) }}" data-ajax-popup="true" data-size="md" data-title="{{ __('New Password') }}" class="flex items-center gap-2 px-3 py-2 text-xs text-green-600 hover:bg-green-50 rounded no-underline login_enable">
                                        <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                        <span>{{ __('Login Enable') }}</span>
                                    </a>
                                @else
                                    <a href="{{ route('users.login', \Crypt::encrypt($user->id)) }}" class="flex items-center gap-2 px-3 py-2 text-xs text-green-600 hover:bg-green-50 rounded no-underline">
                                        <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                        <span>{{ __('Login Enable') }}</span>
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Card Content --}}
                        <div class="flex flex-col items-center text-center mt-4">
                            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-gray-100 flex-shrink-0 mb-3 bg-gray-50 flex items-center justify-center">
                                <img alt="" src="{{ asset(Storage::url("uploads/profile/")).'/'}}{{ !empty($user->avatar)?$user->avatar:'avatar.png' }}" class="w-full h-full object-cover">
                            </div>
                            <h3 class="text-sm font-semibold text-gray-900 m-0">{{ $user->name }}</h3>
                            <span class="text-xs text-gray-500 mt-1 block truncate max-w-full" title="{{ $user->email }}">{{ $user->email }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-4 border-t border-b border-gray-100 py-3 my-4">
                            <div class="text-center border-r border-gray-100">
                                <span class="text-lg font-bold text-gray-900 block">{{ $user->countProducts($user->id) }}</span>
                                <span class="text-[10px] text-gray-500 uppercase tracking-wider block mt-0.5">{{ __('Products') }}</span>
                            </div>
                            <div class="text-center">
                                <span class="text-lg font-bold text-gray-900 block">{{ $user->countStores($user->id) }}</span>
                                <span class="text-[10px] text-gray-500 uppercase tracking-wider block mt-0.5">{{ __('Stores') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col justify-end mt-auto pt-2">
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-3">
                            <div class="flex flex-col">
                                <span class="text-[10px] uppercase text-gray-400 font-medium">{{ __('Plan') }}</span>
                                <span class="font-medium text-gray-700">{{ !empty($user->currentPlan->name ) ? $user->currentPlan->name : "N/A"}}</span>
                            </div>
                            <div class="flex flex-col text-right">
                                <span class="text-[10px] uppercase text-gray-400 font-medium">{{ __('Plan Expired') }}</span>
                                <span class="font-medium text-gray-700">{{ !empty($user->plan_expire_date) ? \Auth::user()->dateFormat($user->plan_expire_date) : 'Unlimited' }}</span>
                            </div>
                        </div>
                        <x-ui.button variant="outline" size="sm" class="w-full" data-url="{{route('owner.info', $user->id)}}" data-size="lg" data-ajax-popup="true" data-title="{{__('Owner Info')}}">
                            {{__('Admin Hub')}}
                        </x-ui.button>
                    </div>
                </div>
            @endforeach

            @can('Create Store')
                <div class="bg-gray-50 hover:bg-gray-100 transition-colors duration-200 border-2 border-dashed border-gray-300 rounded-xl p-6 flex flex-col items-center justify-center text-center cursor-pointer" data-url="{{ route('store-resource.create') }}" data-size="md" data-ajax-popup="true" data-title="{{__('Create New Store')}}">
                    <div class="w-12 h-12 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-[24px]">add</span>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 m-0">{{ __('New Store') }}</h3>
                    <p class="text-xs text-gray-500 mt-2 max-w-[200px]">{{ __('Click here to add a new storefront instantly.') }}</p>
                </div>
            @endcan
        </div>
    @endif
</x-ui.page-container>
@endsection
