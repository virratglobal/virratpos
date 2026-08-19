@extends('layouts.ui-admin')

@section('page-title')
    {{ $emailTemplate->name }}
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('custom/libs/summernote/summernote-bs4.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('custom/libs/summernote/summernote-bs4.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.summernote-simple').summernote({
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough']],
                    ['list', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'unlink']],
                ],
                height: 250,
            });
        });
    </script>
@endpush

@section('content')
<x-ui.page-container>
    <!-- Header -->
    <x-ui.page-header title="{{ $emailTemplate->name }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Email Template') }}</span>
        </x-slot>
    </x-ui.page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        {{-- Left Form --}}
        <div class="bg-white rounded-xl border border-gray-150 p-6 shadow-sm">
            <h3 class="text-base font-semibold text-gray-900 mb-4">{{ __('Template Settings') }}</h3>
            {{ Form::model($currEmailTempLang, ['route' => ['email_templates.update', $currEmailTempLang->parent_id], 'method' => 'PUT', 'class' => 'space-y-4']) }}
                <div>
                    {{ Form::label('subject', __('Subject'), ['class' => 'text-xs font-semibold text-gray-500 mb-1.5 block']) }}<x-required></x-required>
                    {{ Form::text('subject', null, ['class' => 'form-control pc-input', 'required' => 'required', 'disabled' => 'disabled', 'placeholder' => __('Enter Subject')]) }}
                </div>
                <div>
                    {{ Form::label('from', __('From'), ['class' => 'text-xs font-semibold text-gray-500 mb-1.5 block']) }}
                    {{ Form::text('from', $emailTemplate->from, ['class' => 'form-control pc-input', 'required' => 'required', 'placeholder' => __('Enter Form')]) }}
                </div>
                {{ Form::hidden('lang', $currEmailTempLang->lang) }}
                <div class="text-end pt-2">
                    <input type="submit" value="{{ __('Save') }}" class="btn btn-primary px-4 py-2 text-sm font-semibold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 cursor-pointer">
                </div>
            {{ Form::close() }}
        </div>

        {{-- Right Variables Panel --}}
        <div class="lg:col-span-2 bg-white rounded-xl border border-gray-150 p-6 shadow-sm">
            <h3 class="text-base font-semibold text-gray-900 mb-4">{{ __('Dynamic Variables') }}</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                @if($emailTemplate->name != "Owner And Store Created")
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-400 font-medium">{{ __('App Name') }}</span>
                        <span class="font-semibold text-indigo-600">{app_name}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-400 font-medium">{{ __('Order Name') }}</span>
                        <span class="font-semibold text-indigo-600">{order_name}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-400 font-medium">{{ __('Order Status') }}</span>
                        <span class="font-semibold text-indigo-600">{order_status}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-400 font-medium">{{ __('Order URL') }}</span>
                        <span class="font-semibold text-indigo-600">{order_url}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-400 font-medium">{{ __('Order Id') }}</span>
                        <span class="font-semibold text-indigo-600">{order_id}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-400 font-medium">{{ __('Order Date') }}</span>
                        <span class="font-semibold text-indigo-600">{order_date}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-400 font-medium">{{ __('Owner Name') }}</span>
                        <span class="font-semibold text-indigo-600">{owner_name}</span>
                    </div>
                @else
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-400 font-medium">{{ __('App Name') }}</span>
                        <span class="font-semibold text-indigo-600">{app_name}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-400 font-medium">{{ __('App URL') }}</span>
                        <span class="font-semibold text-indigo-600">{app_url}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-400 font-medium">{{ __('Owner Name') }}</span>
                        <span class="font-semibold text-indigo-600">{owner_name}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-400 font-medium">{{ __('Owner Email') }}</span>
                        <span class="font-semibold text-indigo-600">{owner_email}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-400 font-medium">{{ __('Owner Password') }}</span>
                        <span class="font-semibold text-indigo-600">{owner_password}</span>
                    </div>
                    <div class="flex justify-between border-b border-gray-100 pb-2">
                        <span class="text-gray-400 font-medium">{{ __('Store URL') }}</span>
                        <span class="font-semibold text-indigo-600">{store_url}</span>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Content Editor and Language Sidebar --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        {{-- Language Sidebar --}}
        <div>
            <div class="bg-white rounded-xl border border-gray-150 overflow-hidden shadow-sm sticky top-6">
                <div class="px-4 py-3 bg-gray-50 border-b border-gray-150">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">{{ __('Languages') }}</span>
                </div>
                <div class="divide-y divide-gray-100 flex flex-col">
                    @foreach($languages as $key => $lang)
                        <a class="px-4 py-3 text-sm no-underline transition-colors {{ ($currEmailTempLang->lang == $key) ? 'bg-indigo-50 text-indigo-700 font-semibold' : 'text-gray-600 hover:bg-gray-50' }}" href="{{ route('manage.email.language',[$emailTemplate->id,$key]) }}">
                            {{ Str::ucfirst($lang) }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Email Content Editor --}}
        <div class="md:col-span-3 bg-white rounded-xl border border-gray-150 p-6 shadow-sm">
            {{ Form::model($currEmailTempLang, ['route' => ['updateEmail.settings',$currEmailTempLang->parent_id], 'method' => 'PUT', 'class' => 'space-y-4']) }}
                <div>
                    {{ Form::label('subject', __('Subject'), ['class' => 'text-xs font-semibold text-gray-500 mb-1.5 block']) }}
                    {{ Form::text('subject', null, ['class' => 'form-control pc-input', 'required' => 'required', 'placeholder' => __('Enter Subject')]) }}
                </div>
                <div>
                    {{ Form::label('content', __('Email Message'), ['class' => 'text-xs font-semibold text-gray-500 mb-1.5 block']) }}<x-required></x-required>
                    {{ Form::textarea('content', $currEmailTempLang->content, ['class' => 'summernote-simple', 'required' => 'required']) }}
                </div>
                <div class="text-end pt-2">
                    {{ Form::hidden('lang', null) }}
                    <input type="submit" value="{{ __('Save') }}" class="btn btn-primary px-4 py-2 text-sm font-semibold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 cursor-pointer">
                </div>
            {{ Form::close() }}
        </div>
    </div>
</x-ui.page-container>
@endsection
