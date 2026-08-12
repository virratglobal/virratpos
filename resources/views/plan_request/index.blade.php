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

    <x-ui.card class="overflow-hidden">
        <div class="p-6 border-b" style="border-color: #dce9ff;">
            <h3 style="font-family: 'Geist', sans-serif; font-size: 24px; line-height: 32px; letter-spacing: -0.02em; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('Recent Requests') }}</h3>
        </div>
        <div class="overflow-x-auto">
            <x-ui.table>
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Plan Name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Max Products') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Max Stores') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Duration') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Date') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y" style="border-color: #dce9ff;">
                    @forelse($plan_requests as $prequest)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $prequest->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $prequest->plan->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="font-medium text-gray-900">{{ $prequest->plan->max_products }}</span>
                                <span class="text-xs">{{ __('Products') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="font-medium text-gray-900">{{ $prequest->plan->max_stores }}</span>
                                <span class="text-xs">{{ __('Stores') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ ($prequest->duration == 'Lifetime') ? __('Lifetime') : 'One '.$prequest->duration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \App\Models\Utility::getDateFormated($prequest->created_at,false) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{route('response.request',[$prequest->id,1])}}" class="text-green-600 hover:text-green-900 p-1.5 rounded hover:bg-green-50 transition-colors" title="{{ __('Approve') }}">
                                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                    </a>
                                    <a href="{{route('response.request',[$prequest->id,0])}}" class="text-red-600 hover:text-red-900 p-1.5 rounded hover:bg-red-50 transition-colors" title="{{ __('Reject') }}">
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
