@extends('layouts.ui-admin')

@section('page-title', __('Store'))

@section('content')
    <x-ui.page-container>
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 style="font-family: 'Geist', sans-serif; font-size: 1.5rem; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30 !important; margin: 0;">
                    {{ __('Stores Management') }}
                </h1>
                <p style="font-family: 'Inter', sans-serif; font-size: 14px; color: #767586 !important !important; margin-top: 4px;">
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
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 group-hover:scale-150 blur-xl" style="background: rgba(0,0,0,0.03);"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <p style="font-family: 'Geist', sans-serif; font-size: 12px; font-weight: 500; letter-spacing: 0.02em; color: #767586 !important !important; text-transform: uppercase; margin-bottom: 4px;">{{ __('Total Active Stores') }}</p>
                        <h2 style="font-family: 'Geist', sans-serif; font-size: 36px; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30 !important; margin: 0;">{{ $users->count() }}</h2>
                    </div>
                    <div style="width: 40px; height: 40px; border-radius: 8px; background: #f1f1f1; color: #000000 !important; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined">storefront</span>
                    </div>
                </div>
            </div>

            <!-- Total Revenue (Placeholder) -->
            <div style="background: #ffffff; border-radius: 12px; padding: 24px; position: relative; overflow: hidden; border: 1px solid rgba(199,196,215,0.15); box-shadow: 0 1px 8px rgba(0,0,0,0.04);" class="group flex flex-col justify-between">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 group-hover:scale-150 blur-xl" style="background: rgba(0,0,0,0.03);"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <p style="font-family: 'Geist', sans-serif; font-size: 12px; font-weight: 500; letter-spacing: 0.02em; color: #767586 !important !important; text-transform: uppercase; margin-bottom: 4px;">{{ __('Total Revenue (30D)') }}</p>
                        <h2 style="font-family: 'Geist', sans-serif; font-size: 36px; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30 !important; margin: 0;">---</h2>
                    </div>
                    <div style="width: 40px; height: 40px; border-radius: 8px; background: #f1f1f1; color: #000000 !important; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                </div>
            </div>

            <!-- Needs Attention (Placeholder) -->
            <div style="background: #ffffff; border-radius: 12px; padding: 24px; position: relative; overflow: hidden; border: 1px solid rgba(199,196,215,0.15); box-shadow: 0 1px 8px rgba(0,0,0,0.04);" class="group flex flex-col justify-between">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 group-hover:scale-150 blur-xl" style="background: rgba(186,26,26,0.05);"></div>
                <div class="flex justify-between items-start mb-4 relative z-10">
                    <div>
                        <p style="font-family: 'Geist', sans-serif; font-size: 12px; font-weight: 500; letter-spacing: 0.02em; color: #ba1a1a !important; text-transform: uppercase; margin-bottom: 4px;">{{ __('Needs Attention') }}</p>
                        <h2 style="font-family: 'Geist', sans-serif; font-size: 36px; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30 !important; margin: 0;">---</h2>
                    </div>
                    <div style="width: 40px; height: 40px; border-radius: 8px; background: #ffdad6; color: #ba1a1a !important; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined">warning</span>
                    </div>
                </div>
            </div>
        </div>

        <x-ui.card class="overflow-hidden" style="border: 1px solid #E2E8F0; box-shadow: 0 1px 3px 0 rgba(11,28,48,0.04);">
            <div class="px-6 py-4 border-b flex items-center justify-between" style="border-color: #E2E8F0; background: #ffffff;">
                <div>
                    <h3 style="font-family: 'Geist', sans-serif; font-size: 18px; line-height: 24px; font-weight: 600; color: #0b1c30; margin: 0;">
                        {{ __('All Stores') }}
                    </h3>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586; margin-top: 2px;">
                        {{ __('Overview and account control of all registered storefronts.') }}
                    </p>
                </div>
            </div>
            <x-ui.table>
                <thead style="background-color: #eff4ff; border-bottom: 1px solid #E2E8F0;">
                    <tr>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('User Name') }}</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Email') }}</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Stores') }}</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Plan') }}</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Created At') }}</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Store Display') }}</th>
                        <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y" style="border-color: #E2E8F0;">
                    @foreach ($users as $usr)
                        <tr class="hover:bg-[#eff4ff]/60 transition-colors duration-150">
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm font-semibold" style="color: #0b1c30; font-family: 'Geist', sans-serif;">{{ $usr->name }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm" style="color: #464554; font-family: 'Inter', sans-serif;">{{ $usr->email }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm font-semibold" style="color: #0b1c30; font-family: 'Geist', sans-serif;">{{ $usr->stores->count() }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold" style="background-color: #e5eeff; color: #4648d4; font-family: 'Geist', sans-serif;">
                                    {{ !empty($usr->currentPlan->name) ? $usr->currentPlan->name : '-' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm" style="color: #767586; font-family: 'Inter', sans-serif;">{{ \App\Models\Utility::dateFormat($usr->created_at) }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm">
                                <div class="form-check form-switch disabled-form-switch cursor-pointer inline-block">
                                    <a href="#" data-size="md" data-url="{{ route('store-resource.edit.display', $usr->id) }}" data-ajax-popup="true" data-title="{{ __('Are You Sure?') }}" title="{{ $usr->store_display == 1 ? __('Store disable') : __('Store enable') }}">
                                        <input type="checkbox" class="form-check-input" disabled="disabled" name="store_display" id="{{ $usr->id }}" {{ $usr->store_display == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $usr->id }}"></label>
                                    </a>
                                </div>
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm font-medium text-right">
                                <div class="flex justify-end items-center space-x-1.5">
                                    @if(Auth::user()->type == "super admin")
                                        <a href="#" data-url="{{route('owner.info', $usr->id)}}" data-size="lg" data-ajax-popup="true" class="w-8 h-8 rounded-lg bg-[#e5eeff] text-[#4648d4] hover:bg-[#4648d4] hover:text-white flex items-center justify-center transition-all duration-150" data-title="{{__('Owner Info')}}" title="{{ __('Owner Info') }}">
                                            <span class="material-symbols-outlined text-[18px]">info</span>
                                        </a>

                                        <a href="{{ route('login.with.owner', $usr->id) }}" class="w-8 h-8 rounded-lg bg-[#e5eeff] text-[#4648d4] hover:bg-[#4648d4] hover:text-white flex items-center justify-center transition-all duration-150" title="{{ __('Login As Owner') }}">
                                            <span class="material-symbols-outlined text-[18px]">login</span>
                                        </a>

                                        <a href="#" data-size="lg" data-url="{{ route('store.links', $usr->id) }}" data-ajax-popup="true" data-title="{{ __('Store Links') }}" class="w-8 h-8 rounded-lg bg-[#e5eeff] text-[#4648d4] hover:bg-[#4648d4] hover:text-white flex items-center justify-center transition-all duration-150" title="{{ __('Store Links') }}">
                                            <span class="material-symbols-outlined text-[18px]">link</span>
                                        </a>
                                    @endif

                                    @if ($usr->is_enable_login == 1)
                                        <a href="{{ route('users.login', \Crypt::encrypt($usr->id)) }}" class="w-8 h-8 rounded-lg bg-[#e5eeff] text-[#4648d4] hover:bg-[#4648d4] hover:text-white flex items-center justify-center transition-all duration-150" title="{{ __('Login Disable') }}">
                                            <span class="material-symbols-outlined text-[18px]">lock</span>
                                        </a>
                                    @elseif ($usr->is_enable_login == 0 && $usr->password == null)
                                        <a href="#" data-url="{{ route('user.reset', \Crypt::encrypt($usr->id)) }}" class="w-8 h-8 rounded-lg bg-[#e5eeff] text-[#4648d4] hover:bg-[#4648d4] hover:text-white flex items-center justify-center transition-all duration-150 login_enable" data-ajax-popup="true" data-title="{{ __('New Password') }}" title="{{ __('Login Enable') }}">
                                            <span class="material-symbols-outlined text-[18px]">lock_open</span>
                                        </a>
                                    @else
                                        <a href="{{ route('users.login', \Crypt::encrypt($usr->id)) }}" class="w-8 h-8 rounded-lg bg-[#e5eeff] text-[#4648d4] hover:bg-[#4648d4] hover:text-white flex items-center justify-center transition-all duration-150 login_enable" title="{{ __('Login Enable') }}">
                                            <span class="material-symbols-outlined text-[18px]">lock_open</span>
                                        </a>
                                    @endif

                                    @can('Upgrade Plans')
                                        <a href="#" data-url="{{ route('plan.upgrade', $usr->id) }}" data-ajax-popup="true" data-title="{{ __('Upgrade Plan') }}" class="w-8 h-8 rounded-lg bg-[#e5eeff] text-[#4648d4] hover:bg-[#4648d4] hover:text-white flex items-center justify-center transition-all duration-150" title="{{ __('Upgrade Plan') }}">
                                            <span class="material-symbols-outlined text-[18px]">military_tech</span>
                                        </a>
                                    @endcan

                                    @can('Reset Password')
                                        <a href="#" data-url="{{ route('user.reset', \Crypt::encrypt($usr->id)) }}" data-ajax-popup="true" data-title="{{ __('Reset Password') }}" class="w-8 h-8 rounded-lg bg-[#e5eeff] text-[#4648d4] hover:bg-[#4648d4] hover:text-white flex items-center justify-center transition-all duration-150" title="{{ __('Reset Password') }}">
                                            <span class="material-symbols-outlined text-[18px]">key</span>
                                        </a>
                                    @endcan

                                    @can('Edit Store')
                                        <a href="#" data-url="{{ route('store-resource.edit', $usr->id) }}" data-ajax-popup="true" data-title="{{ __('Edit Store') }}" class="w-8 h-8 rounded-lg bg-[#e5eeff] text-[#4648d4] hover:bg-[#4648d4] hover:text-white flex items-center justify-center transition-all duration-150" title="{{ __('Edit') }}">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </a>
                                    @endcan

                                    @if($usr->id != 2)
                                        @can('Delete Store')
                                            <a href="#" class="w-8 h-8 rounded-lg bg-[#ffdad6] text-[#ba1a1a] hover:bg-[#ba1a1a] hover:text-white flex items-center justify-center transition-all duration-150 bs-pass-para" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="delete-form-{{ $usr->id }}" title="{{ __('Delete') }}">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
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
