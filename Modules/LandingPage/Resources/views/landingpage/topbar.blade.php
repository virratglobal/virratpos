@extends('layouts.ui-admin')
@section('page-title')
    {{ __('Landing Page') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Landing Page')}}</li>
@endsection

@php
    $logo=\App\Models\Utility::get_file('uploads/logo');
    $settings = \Modules\LandingPage\Entities\LandingPageSetting::settings();
    $site_settings = Utility::settings();
@endphp

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Landing Page')}}</li>
@endsection


@section('content')
    <x-ui.page-container>
        <div class="flex items-center justify-between mb-8 mt-4">
            <div class="flex flex-col gap-1 relative z-10">
                <h1 style="font-family: 'Geist', sans-serif; font-size: 36px; line-height: 40px; letter-spacing: -0.04em; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('Landing Page Settings') }}</h1>
                <p style="font-family: 'Inter', sans-serif; font-size: 16px; color: #767586; margin-top: 4px; max-width: 42rem;">{{ __('Configure your landing page elements and messaging.') }}</p>
            </div>
        </div>

        <div class="flex flex-col gap-6 lg:flex-row">
            <!-- Sidebar Navigation -->
            <div class="w-full lg:w-1/4">
                <x-ui.card class="sticky top-6 overflow-hidden">
                    <nav class="flex flex-col p-2 space-y-1" id="useradd-sidenav">
                        @include('landingpage::layouts.tab')
                    </nav>
                </x-ui.card>
            </div>

            <!-- Main Content Area -->
            <div class="w-full lg:w-3/4">
                {{Form::model(null, array('route' => array('landingpage.store'), 'method' => 'POST')) }}
                    @csrf
                    <x-ui.card class="overflow-hidden">
                        <div class="flex flex-col items-center justify-between px-6 py-4 border-b border-gray-200 lg:flex-row gap-y-4" style="border-color: #dce9ff;">
                            <h5 style="font-family: 'Geist', sans-serif; font-size: 20px; font-weight: 600; color: #0b1c30; margin: 0;">{{ __('Top Bar Settings') }}</h5>
                            <div class="flex items-center space-x-3">
                                <label for="topbar_status" class="text-sm font-medium text-gray-700">{{__('Enable')}}</label>
                                <div class="relative inline-block w-10 mr-2 align-middle select-none">
                                    <input type="checkbox" name="topbar_status" id="topbar_status" class="absolute block w-6 h-6 transition-all duration-200 ease-in-out bg-white border-4 appearance-none rounded-full cursor-pointer focus:outline-none is_enable right-4 checked:right-0" style="border-color: #4648d4;" {{ $settings['topbar_status'] == 'on' ? 'checked="checked"' : '' }}>
                                    <label for="topbar_status" class="block h-6 overflow-hidden bg-gray-300 rounded-full cursor-pointer transition-colors duration-200 toggle-label" {{ $settings['topbar_status'] == 'on' ? 'style="background-color: #4648d4;"' : '' }}></label>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="space-y-6">
                                <div>
                                    {{ Form::label('content', __('Message'), ['class' => 'block text-sm font-medium text-gray-700 mb-2']) }}
                                    {{ Form::textarea('topbar_notification_msg',$settings['topbar_notification_msg'], ['class' => 'block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm summernote-simple', 'required' => 'required']) }}
                                </div>
                            </div>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 border-t text-right rounded-b-lg" style="border-color: #dce9ff;">
                            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white transition-colors border border-transparent rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2" style="background-color: #4648d4;">
                                {{ __('Save Changes') }}
                            </button>
                        </div>
                    </x-ui.card>
                {{ Form::close() }}
            </div>
        </div>
    </x-ui.page-container>
@endsection

@push('scripts')
<script>
    $('#topbar_status').on('change', function() {
        if($(this).is(':checked')) {
            $(this).addClass('checked:right-0');
            $(this).next('label').css('background-color', '#4648d4');
        } else {
            $(this).next('label').css('background-color', '');
        }
    });
</script>
@endpush



