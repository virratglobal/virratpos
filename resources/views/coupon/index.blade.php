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
                    <span class="material-symbols-outlined text-3xl" style="color: #4648d4;">local_offer</span>
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
                    <a href="#" data-url="{{ route('coupons.create') }}" data-title="{{ __('Add Coupon') }}" data-ajax-popup="true" class="btn btn-primary" style="display: flex; gap: 8px; background-color: #4648d4 !important; color: #ffffff !important; border: none; align-items: center; justify-content: center; box-shadow: none;">
                        <span class="material-symbols-outlined" style="font-size: 18px; color: #ffffff !important;">add</span>
                        <span style="color: #ffffff !important; font-weight: 500; font-family: 'Geist', sans-serif;">{{ __('Create New Coupon') }}</span>
                    </a>
                @endcan
            </div>
        </div>

        <!-- 3 Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Active Coupons -->
            <div style="background: #ffffff; border-radius: 16px; padding: 24px; position: relative; overflow: hidden; border: 1px solid #E2E8F0; box-shadow: 0 1px 8px rgba(0,0,0,0.04);" class="group flex flex-col justify-between">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 blur-xl" style="background: rgba(70,72,212,0.05);"></div>
                <div class="flex justify-between items-center mb-4 relative z-10">
                    <span style="font-family: 'Geist', sans-serif; font-size: 12px; font-weight: 500; letter-spacing: 0.02em; color: #767586; text-transform: uppercase;">{{ __('Active Coupons') }}</span>
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #e5eeff; color: #4648d4; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined text-[16px]">confirmation_number</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-3 relative z-10">
                    <span style="font-family: 'Geist', sans-serif; font-size: 36px; line-height: 40px; font-weight: 600; color: #0b1c30;">{{ count($coupons) }}</span>
                </div>
            </div>

            <!-- Redemptions (MTD) Placeholder -->
            <div style="background: #ffffff; border-radius: 16px; padding: 24px; position: relative; overflow: hidden; border: 1px solid #E2E8F0; box-shadow: 0 1px 8px rgba(0,0,0,0.04);" class="group flex flex-col justify-between">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 blur-xl" style="background: rgba(70,72,212,0.05);"></div>
                <div class="flex justify-between items-center mb-4 relative z-10">
                    <span style="font-family: 'Geist', sans-serif; font-size: 12px; font-weight: 500; letter-spacing: 0.02em; color: #767586; text-transform: uppercase;">{{ __('Redemptions (MTD)') }}</span>
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #e5eeff; color: #4648d4; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined text-[16px]">shopping_basket</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-3 relative z-10">
                    <span style="font-family: 'Geist', sans-serif; font-size: 36px; line-height: 40px; font-weight: 600; color: #0b1c30;">---</span>
                </div>
            </div>

            <!-- Total Savings Placeholder -->
            <div style="background: #ffffff; border-radius: 16px; padding: 24px; position: relative; overflow: hidden; border: 1px solid #E2E8F0; box-shadow: 0 1px 8px rgba(0,0,0,0.04);" class="group flex flex-col justify-between">
                <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full transition-transform duration-500 blur-xl" style="background: rgba(70,72,212,0.05);"></div>
                <div class="flex justify-between items-center mb-4 relative z-10">
                    <span style="font-family: 'Geist', sans-serif; font-size: 12px; font-weight: 500; letter-spacing: 0.02em; color: #767586; text-transform: uppercase;">{{ __('Total Savings') }}</span>
                    <div style="width: 32px; height: 32px; border-radius: 8px; background: #e5eeff; color: #4648d4; display: flex; align-items: center; justify-content: center;">
                        <span class="material-symbols-outlined text-[16px]">savings</span>
                    </div>
                </div>
                <div class="flex items-baseline gap-3 relative z-10">
                    <span style="font-family: 'Geist', sans-serif; font-size: 36px; line-height: 40px; font-weight: 600; color: #0b1c30;">---</span>
                </div>
            </div>
        </div>

        <x-ui.card class="overflow-hidden" style="border: 1px solid #E2E8F0; box-shadow: 0 1px 3px 0 rgba(11,28,48,0.04);">
            <div class="px-6 py-4 border-b flex items-center justify-between" style="border-color: #E2E8F0; background: #ffffff;">
                <div>
                    <h3 style="font-family: 'Geist', sans-serif; font-size: 18px; line-height: 24px; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('All Coupons') }}</h3>
                    <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586; margin-top: 2px;">{{ __('List of active platform discounts and redemption limits.') }}</p>
                </div>
            </div>
            <div class="overflow-x-auto">
                <x-ui.table>
                    <thead style="background-color: #eff4ff; border-bottom: 1px solid #E2E8F0;">
                        <tr>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Name') }}</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Code') }}</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Discount (%)') }}</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Limit') }}</th>
                            <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Used') }}</th>
                            <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y" style="border-color: #E2E8F0;">
                        @forelse ($coupons as $coupon)
                            <tr class="hover:bg-[#eff4ff]/60 transition-colors duration-150">
                                <td class="px-5 py-3.5 whitespace-nowrap text-sm font-semibold" style="color: #0b1c30; font-family: 'Geist', sans-serif;">{{ $coupon->name }}</td>
                                <td class="px-5 py-3.5 whitespace-nowrap text-sm">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold" style="background-color: #e5eeff; color: #4648d4; font-family: 'Geist', sans-serif;">
                                        {{ $coupon->code }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 whitespace-nowrap text-sm font-semibold" style="color: #0b1c30; font-family: 'Geist', sans-serif;">{{ $coupon->discount }}%</td>
                                <td class="px-5 py-3.5 whitespace-nowrap text-sm" style="color: #464554; font-family: 'Inter', sans-serif;">{{ $coupon->limit }}</td>
                                <td class="px-5 py-3.5 whitespace-nowrap text-sm" style="color: #464554; font-family: 'Inter', sans-serif;">{{ $coupon->used_coupon() }}</td>
                                <td class="px-5 py-3.5 whitespace-nowrap text-sm font-medium text-right">
                                    <div class="flex items-center justify-end space-x-1.5">
                                        @can('Show Coupans')
                                            <a href="{{ route('coupons.show', $coupon->id) }}" class="w-8 h-8 rounded-lg bg-[#e5eeff] text-[#4648d4] hover:bg-[#4648d4] hover:text-white flex items-center justify-center transition-all duration-150" title="{{ __('View') }}">
                                                <span class="material-symbols-outlined text-[18px]">visibility</span>
                                            </a>
                                        @endcan
                                        @can('Edit Coupans')
                                            <a href="#" data-url="{{ route('coupons.edit', $coupon->id) }}" data-title="{{ __('Edit Coupon') }}" data-ajax-popup="true" class="w-8 h-8 rounded-lg bg-[#e5eeff] text-[#4648d4] hover:bg-[#4648d4] hover:text-white flex items-center justify-center transition-all duration-150" title="{{ __('Edit') }}">
                                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                            </a>
                                        @endcan
                                        @can('Delete Coupans')
                                            <a href="#" class="w-8 h-8 rounded-lg bg-[#ffdad6] text-[#ba1a1a] hover:bg-[#ba1a1a] hover:text-white flex items-center justify-center transition-all duration-150 bs-pass-para" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="delete-form-{{ $coupon->id }}" title="{{ __('Delete') }}">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['coupons.destroy', $coupon->id], 'id' => 'delete-form-' . $coupon->id, 'class' => 'hidden']) !!}
                                            {!! Form::close() !!}
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center" style="color: #767586;">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="material-symbols-outlined text-4xl mb-2" style="color: #c7c4d7;">confirmation_number</span>
                                        <p class="font-medium" style="color: #0b1c30;">{{ __('No coupons found') }}</p>
                                        <p class="text-sm mt-1">{{ __('Get started by creating a new coupon.') }}</p>
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
