@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Coupons') }}
@endsection

@section('content')
    <x-ui.page-container>
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
            <div class="space-y-2">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-3xl text-primary">local_offer</span>
                    <h1 style="font-family: 'Geist', sans-serif; font-size: 1.5rem; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">
                        {{ __('Coupons Management') }}
                    </h1>
                </div>
                <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #767586; margin-top: 4px;">
                    {{ __('Create and manage platform-wide promotional codes and discounts.') }}
                </p>
            </div>
            <div class="flex items-center gap-3 shrink-0">
                @can('Create Coupans')
                    <a href="#" data-url="{{ route('coupons.create') }}" data-title="{{ __('Add Coupon') }}" data-ajax-popup="true" class="btn btn-primary" style="display: flex; gap: 8px;">
                        <span class="material-symbols-outlined" style="font-size: 18px;">add</span>
                        {{ __('Create New Coupon') }}
                    </a>
                @endcan
            </div>
        </div>

        <!-- 3 Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Active Coupons -->
            <div style="background: #ffffff; border-radius: 16px; padding: 24px; position: relative; overflow: hidden; border: 1px solid rgba(199,196,215,0.15); box-shadow: 0 1px 8px rgba(0,0,0,0.04);" class="group flex flex-col justify-between">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-colors duration-500 blur-xl bg-primary/5 group-hover:bg-primary/10"></div>
                <div class="flex justify-between items-center mb-4 relative z-10">
                    <span style="font-family: 'Geist', sans-serif; font-size: 12px; font-weight: 500; letter-spacing: 0.02em; color: #767586; text-transform: uppercase;">{{ __('Active Coupons') }}</span>
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(96,99,238,0.2); color: #4648d4; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined text-[16px]">confirmation_number</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-3 relative z-10">
                    <span style="font-family: 'Geist', sans-serif; font-size: 36px; line-height: 40px; font-weight: 600; color: #0b1c30;">{{ count($coupons) }}</span>
                </div>
            </div>

            <!-- Redemptions (MTD) Placeholder -->
            <div style="background: #ffffff; border-radius: 16px; padding: 24px; position: relative; overflow: hidden; border: 1px solid rgba(199,196,215,0.15); box-shadow: 0 1px 8px rgba(0,0,0,0.04);" class="group flex flex-col justify-between">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-colors duration-500 blur-xl bg-tertiary/5 group-hover:bg-tertiary/10"></div>
                <div class="flex justify-between items-center mb-4 relative z-10">
                    <span style="font-family: 'Geist', sans-serif; font-size: 12px; font-weight: 500; letter-spacing: 0.02em; color: #767586; text-transform: uppercase;">{{ __('Redemptions (MTD)') }}</span>
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(181,93,0,0.2); color: #904900; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined text-[16px]">shopping_basket</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-3 relative z-10">
                    <span style="font-family: 'Geist', sans-serif; font-size: 36px; line-height: 40px; font-weight: 600; color: #0b1c30;">---</span>
                </div>
            </div>

            <!-- Total Savings Placeholder -->
            <div style="background: #ffffff; border-radius: 16px; padding: 24px; position: relative; overflow: hidden; border: 1px solid rgba(199,196,215,0.15); box-shadow: 0 1px 8px rgba(0,0,0,0.04);" class="group flex flex-col justify-between">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-colors duration-500 blur-xl bg-secondary/5 group-hover:bg-secondary/10"></div>
                <div class="flex justify-between items-center mb-4 relative z-10">
                    <span style="font-family: 'Geist', sans-serif; font-size: 12px; font-weight: 500; letter-spacing: 0.02em; color: #767586; text-transform: uppercase;">{{ __('Total Savings') }}</span>
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(218,226,253,0.2); color: #565e74; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined text-[16px]">savings</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-3 relative z-10">
                    <span style="font-family: 'Geist', sans-serif; font-size: 36px; line-height: 40px; font-weight: 600; color: #0b1c30;">---</span>
                </div>
            </div>
        </div>

        <x-ui.card class="overflow-hidden">
            <div class="overflow-x-auto">
                <x-ui.table>
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">{{ __('Name') }}</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">{{ __('Code') }}</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">{{ __('Discount (%)') }}</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">{{ __('Limit') }}</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase bg-gray-50">{{ __('Used') }}</th>
                            <th class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase bg-gray-50">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($coupons as $coupon)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $coupon->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                        {{ $coupon->code }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">{{ $coupon->discount }}%</td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $coupon->limit }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">{{ $coupon->used_coupon() }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end space-x-2">
                                        @can('Show Coupans')
                                            <a href="{{ route('coupons.show', $coupon->id) }}" class="text-blue-600 hover:text-blue-900" title="{{ __('View') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                        @endcan
                                        @can('Edit Coupans')
                                            <a href="#" data-url="{{ route('coupons.edit', $coupon->id) }}" data-title="{{ __('Edit Coupon') }}" data-ajax-popup="true" class="text-indigo-600 hover:text-indigo-900" title="{{ __('Edit') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                        @endcan
                                        @can('Delete Coupans')
                                            <a href="#" class="text-red-600 bs-pass-para hover:text-red-900" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="delete-form-{{ $coupon->id }}" title="{{ __('Delete') }}">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['coupons.destroy', $coupon->id], 'id' => 'delete-form-' . $coupon->id, 'class' => 'hidden']) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2zM10 8.5a.5.5 0 11-1 0 .5.5 0 011 0zm5 5a.5.5 0 11-1 0 .5.5 0 011 0z"></path></svg>
                                        <p class="text-base font-medium text-gray-900">{{ __('No coupons found') }}</p>
                                        <p class="mt-1 text-sm text-gray-500">{{ __('Get started by creating a new coupon.') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </x-ui.table>
            </div>
        </x-ui.card>
    </x-ui.page-container>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '#code-generate', function () {
            var length = 10;
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            $('#auto-code').val(result);
        });
    </script>
@endpush
