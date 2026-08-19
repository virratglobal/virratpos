@extends('layouts.ui-admin')

@section('page-title', __('Plan Request'))

@section('content')
<x-ui.page-container>
    <div class="flex items-center justify-between mb-8 mt-4">
        <div class="flex flex-col gap-1 relative z-10">
            <h1 style="font-family: 'Geist', sans-serif; font-size: 1.5rem; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('Plan Requests') }}</h1>
            <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #767586; margin-top: 4px; max-width: 42rem;">{{ __('Manage and review requests for plan upgrades or custom tier adjustments.') }}</p>
        </div>
    </div>

    <x-ui.card class="overflow-hidden" style="border: 1px solid #E2E8F0; box-shadow: 0 1px 3px 0 rgba(11,28,48,0.04);">
        <div class="px-6 py-4 border-b flex items-center justify-between" style="border-color: #E2E8F0; background: #ffffff;">
            <div>
                <h3 style="font-family: 'Geist', sans-serif; font-size: 18px; line-height: 24px; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('Recent Requests') }}</h3>
                <p style="font-family: 'Inter', sans-serif; font-size: 13px; color: #767586; margin-top: 2px;">{{ __('Review and process merchant plan upgrade requests.') }}</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <x-ui.table>
                <thead style="background-color: #eff4ff; border-bottom: 1px solid #E2E8F0;">
                    <tr>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Name') }}</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Plan Name') }}</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Max Products') }}</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Max Stores') }}</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Duration') }}</th>
                        <th class="px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Date') }}</th>
                        <th class="px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y" style="border-color: #E2E8F0;">
                    @forelse($plan_requests as $prequest)
                        <tr class="hover:bg-[#eff4ff]/60 transition-colors duration-150">
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm font-semibold" style="color: #0b1c30; font-family: 'Geist', sans-serif;">{{ $prequest->user->name }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm font-semibold" style="color: #0b1c30; font-family: 'Geist', sans-serif;">{{ $prequest->plan->name }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm" style="color: #464554; font-family: 'Inter', sans-serif;">
                                <span class="font-semibold" style="color: #0b1c30;">{{ $prequest->plan->max_products }}</span>
                                <span class="text-xs text-[#767586]">{{ __('Products') }}</span>
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm" style="color: #464554; font-family: 'Inter', sans-serif;">
                                <span class="font-semibold" style="color: #0b1c30;">{{ $prequest->plan->max_stores }}</span>
                                <span class="text-xs text-[#767586]">{{ __('Stores') }}</span>
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm font-semibold" style="color: #0b1c30; font-family: 'Geist', sans-serif;">{{ ($prequest->duration == 'Lifetime') ? __('Lifetime') : 'One '.$prequest->duration }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm" style="color: #767586; font-family: 'Inter', sans-serif;">{{ \App\Models\Utility::getDateFormated($prequest->created_at,false) }}</td>
                            <td class="px-5 py-3.5 whitespace-nowrap text-sm text-right font-medium">
                                <div class="flex items-center justify-end space-x-1.5">
                                    <a href="{{route('response.request',[$prequest->id,1])}}" class="w-8 h-8 rounded-lg bg-[#e8f5e9] text-[#1a7431] hover:bg-[#1a7431] hover:text-white flex items-center justify-center transition-all duration-150" title="{{ __('Approve') }}">
                                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                    </a>
                                    <a href="{{route('response.request',[$prequest->id,0])}}" class="w-8 h-8 rounded-lg bg-[#ffdad6] text-[#ba1a1a] hover:bg-[#ba1a1a] hover:text-white flex items-center justify-center transition-all duration-150" title="{{ __('Reject') }}">
                                        <span class="material-symbols-outlined text-[18px]">cancel</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center" style="color: #767586;">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl mb-2" style="color: #c7c4d7;">description</span>
                                    <p class="font-medium" style="color: #0b1c30;">{{ __('No requests found') }}</p>
                                    <p class="text-sm mt-1">{{ __('There are no pending plan requests at this time.') }}</p>
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
