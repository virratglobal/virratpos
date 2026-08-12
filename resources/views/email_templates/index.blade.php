@extends('layouts.ui-admin')

@section('page-title')
    {{__('Email Templates')}}
@endsection

@section('content')
    <x-ui.page-container>
        <div class="flex items-center justify-between mb-8 mt-4">
            <div class="flex flex-col gap-1 relative z-10">
                <h1 style="font-family: 'Geist', sans-serif; font-size: 1.5rem; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('Email Templates') }}</h1>
                <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #767586; margin-top: 4px; max-width: 42rem;">{{ __('Manage and customize automated email communications.') }}</p>
            </div>
        </div>

        <x-ui.card class="overflow-hidden">
            <div class="p-6 border-b" style="border-color: #dce9ff;">
                <h3 style="font-family: 'Geist', sans-serif; font-size: 24px; line-height: 32px; letter-spacing: -0.02em; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('System Templates') }}</h3>
            </div>
            <div class="overflow-x-auto">
                <x-ui.table>
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Name') }}</th>
                            @if(\Auth::user()->type == 'super admin')
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('Action') }}</th>
                            @elseif(\Auth::user()->type == 'Owner')
                                <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider" style="color: #767586; font-family: 'Geist', sans-serif;">{{ __('On/Off') }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y" style="border-color: #dce9ff;">
                        @forelse ($EmailTemplates as $EmailTemplate)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">{{ $EmailTemplate->name }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end">
                                        <a href="{{ route('manage.email.language',[$EmailTemplate->id,\Auth::user()->lang]) }}" class="inline-flex items-center justify-center p-2 text-primary-600 transition-colors rounded-lg hover:bg-primary-50" style="color: #4648d4;" title="{{ __('View') }}">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-8 text-center" style="color: #767586;">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="material-symbols-outlined text-4xl mb-2" style="color: #c7c4d7;">mail</span>
                                        <p class="font-medium" style="color: #0b1c30;">{{ __('No email templates found') }}</p>
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
