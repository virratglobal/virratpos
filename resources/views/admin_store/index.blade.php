@extends('layouts.ui-admin')

@section('page-title', __('Store'))

@section('content')
    <x-ui.page-container>
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 style="font-family: 'Geist', sans-serif; font-size: 1.5rem; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">
                    {{ __('Stores Management') }}
                </h1>
                <p style="font-family: 'Inter', sans-serif; font-size: 14px; color: #767586; margin-top: 4px;">
                    {{ __('Overview and control of all active merchant storefronts on the platform.') }}
                </p>
            </div>
            <div class="flex items-center space-x-2">
                <a href="{{ route('store.subDomain') }}" class="btn btn-secondary" title="{{ __('Sub Domain') }}">
                    {{ __('Sub Domain') }}
                </a>
                <a href="{{ route('store.customDomain') }}" class="btn btn-secondary" title="{{ __('Custom Domain') }}">
                    {{ __('Custom Domain') }}
                </a>
                <a href="{{ route('store.grid') }}" class="btn btn-secondary" title="{{ __('Grid View') }}">
                    <span class="material-symbols-outlined" style="font-size: 18px;">grid_view</span>
                </a>
                @can('Create Store')
                    <a href="#" class="btn btn-primary" data-size="lg" data-url="{{ route('store-resource.create') }}" data-ajax-popup="true" data-title="{{ __('Create New Store') }}" title="{{ __('Create') }}" style="display: flex; gap: 8px;">
                        <span class="material-symbols-outlined" style="font-size: 18px;">add</span>
                        {{ __('New Store') }}
                    </a>
                @endcan
            </div>
        </div>

        <!-- 3 Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Active Stores -->
            <div style="background: #ffffff; border-radius: 12px; padding: 24px; position: relative; overflow: hidden; border: 1px solid rgba(199,196,215,0.15); box-shadow: 0 1px 8px rgba(0,0,0,0.04);" class="group flex flex-col justify-between">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 group-hover:scale-150 blur-xl" style="background: rgba(70,72,212,0.05);"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <p style="font-family: 'Geist', sans-serif; font-size: 12px; font-weight: 500; letter-spacing: 0.02em; color: #767586; text-transform: uppercase; margin-bottom: 4px;">{{ __('Total Active Stores') }}</p>
                        <h2 style="font-family: 'Geist', sans-serif; font-size: 36px; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">{{ $users->count() }}</h2>
                    </div>
                    <div style="width: 40px; height: 40px; border-radius: 8px; background: #e5eeff; color: #4648d4; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined">storefront</span>
                    </div>
                </div>
            </div>

            <!-- Total Revenue (Placeholder) -->
            <div style="background: #ffffff; border-radius: 12px; padding: 24px; position: relative; overflow: hidden; border: 1px solid rgba(199,196,215,0.15); box-shadow: 0 1px 8px rgba(0,0,0,0.04);" class="group flex flex-col justify-between">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 group-hover:scale-150 blur-xl" style="background: rgba(70,72,212,0.05);"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <p style="font-family: 'Geist', sans-serif; font-size: 12px; font-weight: 500; letter-spacing: 0.02em; color: #767586; text-transform: uppercase; margin-bottom: 4px;">{{ __('Total Revenue (30D)') }}</p>
                        <h2 style="font-family: 'Geist', sans-serif; font-size: 36px; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">---</h2>
                    </div>
                    <div style="width: 40px; height: 40px; border-radius: 8px; background: #e5eeff; color: #4648d4; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                </div>
            </div>

            <!-- Needs Attention (Placeholder) -->
            <div style="background: #ffffff; border-radius: 12px; padding: 24px; position: relative; overflow: hidden; border: 1px solid rgba(199,196,215,0.15); box-shadow: 0 1px 8px rgba(0,0,0,0.04);" class="group flex flex-col justify-between">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 group-hover:scale-150 blur-xl" style="background: rgba(186,26,26,0.05);"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <p style="font-family: 'Geist', sans-serif; font-size: 12px; font-weight: 500; letter-spacing: 0.02em; color: #ba1a1a; text-transform: uppercase; margin-bottom: 4px;">{{ __('Needs Attention') }}</p>
                        <h2 style="font-family: 'Geist', sans-serif; font-size: 36px; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">---</h2>
                    </div>
                    <div style="width: 40px; height: 40px; border-radius: 8px; background: #ffdad6; color: #ba1a1a; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined">warning</span>
                    </div>
                </div>
            </div>
        </div>

        <x-ui.card class="overflow-hidden">
        <x-ui.table>
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('User Name') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Email') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Stores') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Plan') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Created At') }}</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Store Display') }}</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $usr)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $usr->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $usr->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $usr->stores->count() }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-primary-100 text-primary-800">
                                {{ !empty($usr->currentPlan->name) ? $usr->currentPlan->name : '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \App\Models\Utility::dateFormat($usr->created_at) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="form-check form-switch disabled-form-switch cursor-pointer">
                                <a href="#" data-size="md" data-url="{{ route('store-resource.edit.display', $usr->id) }}" data-ajax-popup="true" data-title="{{ __('Are You Sure?') }}" title="{{ $usr->store_display == 1 ? 'Store disable' : 'Store enable' }}">
                                    <input type="checkbox" class="form-check-input" disabled="disabled" name="store_display" id="{{ $usr->id }}" {{ $usr->store_display == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $usr->id }}"></label>
                                </a>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                            <div class="flex justify-end items-center space-x-2">
                                @if(Auth::user()->type == "super admin")
                                    <a href="#" data-url="{{route('owner.info', $usr->id)}}" data-size="lg" data-ajax-popup="true" class="text-orange-600 hover:text-orange-900" data-title="{{__('Owner Info')}}" title="{{ __('Owner Info') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </a>

                                    <a href="{{ route('login.with.owner', $usr->id) }}" class="text-indigo-600 hover:text-indigo-900" title="{{ __('Login As Owner') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                    </a>

                                    <a href="#" data-size="lg" data-url="{{ route('store.links', $usr->id) }}" data-ajax-popup="true" data-title="{{ __('Store Links') }}" class="text-blue-600 hover:text-blue-900" title="{{ __('Store Links') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                    </a>
                                @endif

                                @if ($usr->is_enable_login == 1)
                                    <a href="{{ route('users.login', \Crypt::encrypt($usr->id)) }}" class="text-red-600 hover:text-red-900" title="{{ __('Login Disable') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                    </a>
                                @elseif ($usr->is_enable_login == 0 && $usr->password == null)
                                    <a href="#" data-url="{{ route('user.reset', \Crypt::encrypt($usr->id)) }}" class="text-green-600 hover:text-green-900 login_enable" data-ajax-popup="true" data-title="{{ __('New Password') }}" title="{{ __('Login Enable') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </a>
                                @else
                                    <a href="{{ route('users.login', \Crypt::encrypt($usr->id)) }}" class="text-green-600 hover:text-green-900 login_enable" title="{{ __('Login Enable') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </a>
                                @endif

                                @can('Upgrade Plans')
                                    <a href="#" data-url="{{ route('plan.upgrade', $usr->id) }}" data-ajax-popup="true" data-title="{{ __('Upgrade Plan') }}" class="text-yellow-600 hover:text-yellow-900" title="{{ __('Upgrade Plan') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                    </a>
                                @endcan

                                @can('Reset Password')
                                    <a href="#" data-url="{{ route('user.reset', \Crypt::encrypt($usr->id)) }}" data-ajax-popup="true" data-title="{{ __('Reset Password') }}" class="text-gray-600 hover:text-gray-900" title="{{ __('Reset Password') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4v-4l5.659-5.659A6 6 0 1115 7z"></path></svg>
                                    </a>
                                @endcan

                                @can('Edit Store')
                                    <a href="#" data-url="{{ route('store-resource.edit', $usr->id) }}" data-ajax-popup="true" data-title="{{ __('Edit Store') }}" class="text-blue-600 hover:text-blue-900" title="{{ __('Edit') }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                @endcan

                                @if($usr->id != 2)
                                    @can('Delete Store')
                                        <a href="#" class="text-red-600 hover:text-red-900 bs-pass-para" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="delete-form-{{ $usr->id }}" title="{{ __('Delete') }}">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['store-resource.destroy', $usr->id], 'id' => 'delete-form-' . $usr->id, 'class' => 'hidden']) !!}
                                        {!! Form::close() !!}
                                    @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-ui.table>
    </x-ui.card>
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
