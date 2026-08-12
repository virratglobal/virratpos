@extends('layouts.ui-admin')

@section('page-title', __('Custom Domain Request'))

@section('content')
<x-ui.page-container>
    <div class="flex items-center justify-between mb-8 mt-4">
        <div class="flex flex-col gap-1 relative z-10">
            <h1 style="font-family: 'Geist', sans-serif; font-size: 1.5rem; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('Domain Requests') }}</h1>
            <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #767586; margin-top: 4px; max-width: 42rem;">{{ __('Review and manage custom domain requests from store owners.') }}</p>
        </div>
    </div>

    <x-ui.card class="overflow-hidden">
        <div class="p-6 border-b" style="border-color: #dce9ff;">
            <h3 style="font-family: 'Geist', sans-serif; font-size: 24px; line-height: 32px; letter-spacing: -0.02em; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('Recent Domain Requests') }}</h3>
        </div>
        <div class="overflow-x-auto">
            <x-ui.table>
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Owner Name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Store') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Custom Domain') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Status') }}</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y" style="border-color: #dce9ff;">
                    @forelse ($custom_domain_requests as $custom_domain_request)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $custom_domain_request->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $custom_domain_request->store->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium" style="color: #4648d4;">{{ $custom_domain_request->custom_domain }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($custom_domain_request->status == 0)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">{{ __(App\Models\CustomDomainRequest::$statues[$custom_domain_request->status]) }}</span>
                                @elseif($custom_domain_request->status == 1)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">{{ __(App\Models\CustomDomainRequest::$statues[$custom_domain_request->status]) }}</span>
                                @elseif($custom_domain_request->status == 2)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">{{ __(App\Models\CustomDomainRequest::$statues[$custom_domain_request->status]) }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-right">
                                <div class="flex justify-end items-center space-x-2">
                                    @if($custom_domain_request->status == 0)
                                        <a href="{{ route('custom_domain_request.request',[$custom_domain_request->id,1]) }}" class="text-green-600 hover:text-green-900 p-1.5 rounded hover:bg-green-50 transition-colors" title="{{ __('Approve') }}">
                                            <span class="material-symbols-outlined text-[18px]">check_circle</span>
                                        </a>
                                        <a href="{{ route('custom_domain_request.request',[$custom_domain_request->id,0]) }}" class="text-gray-600 hover:text-gray-900 p-1.5 rounded hover:bg-gray-50 transition-colors" title="{{ __('Reject') }}">
                                            <span class="material-symbols-outlined text-[18px]">cancel</span>
                                        </a>
                                    @endif

                                    <a href="#" class="text-red-600 hover:text-red-900 p-1.5 rounded hover:bg-red-50 transition-colors bs-pass-para" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="delete-form-{{ $custom_domain_request->id }}" title="{{ __('Delete') }}">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['custom_domain_request.destroy',$custom_domain_request->id], 'id' => 'delete-form-' . $custom_domain_request->id, 'class' => 'hidden']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center" style="color: #767586;">
                                <div class="flex flex-col items-center justify-center">
                                    <span class="material-symbols-outlined text-4xl mb-2" style="color: #c7c4d7;">domain_disabled</span>
                                    <p class="font-medium" style="color: #0b1c30;">{{ __('No domain requests found') }}</p>
                                    <p class="text-sm mt-1">{{ __('There are no pending custom domain requests.') }}</p>
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
