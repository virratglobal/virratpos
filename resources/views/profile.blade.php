@extends('layouts.ui-admin')

@php
$storagesetting = App\Models\Utility::StorageSettings();
if($storagesetting['storage_setting'] == 'wasabi' || $storagesetting['storage_setting'] == 's3'){
    $profile = \App\Models\Utility::get_file('uploads/profile');
}else{
    $profile = \App\Models\Utility::get_file('uploads/profile/');
}
$users = \Auth::user();
@endphp

@section('page-title')
    {{ __('Profile') }}
@endsection

@section('content')
<style>
    #useradd-sidenav .list-group-item {
        border: none !important;
        padding: 12px 16px !important;
        border-radius: 8px !important;
        font-family: 'Geist', sans-serif !important;
        font-size: 13px !important;
        font-weight: 500 !important;
        color: #464554 !important !important;
        transition: all 0.2s !important;
        background: transparent !important;
        margin-bottom: 4px !important;
        display: block !important;
    }
    #useradd-sidenav .list-group-item:hover {
        background-color: #eff4ff !important;
        color: #0b1c30 !important;
    }
    #useradd-sidenav .list-group-item.active {
        background-color: #f1f1f1 !important;
        color: #000000 !important;
    }
</style>

<x-ui.page-container>
    <x-ui.page-header title="{{ __('Profile') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Profile') }}</span>
        </x-slot>
    </x-ui.page-header>

    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav" style="padding: 8px;">
                            <a href="#Personal_Info" id="Personal_Info_tab" class="list-group-item list-group-item-action">
                                {{ __('Personal Info') }}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#Change_Password" id="Change_Password_tab" class="list-group-item list-group-item-action">
                                {{__('Change Password')}}
                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-9">
                    <!-- Personal Info -->
                    <div class="active" id="Personal_Info">
                        {{Form::model($userDetail,array('route' => array('update.account'), 'method' => 'put', 'enctype' => "multipart/form-data", 'class'=>'needs-validation', 'novalidate'))}}
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ __('Personal Info') }}</h5>
                                    </div>
                                    <div class="card-body pb-0">
                                        <div class="setting-card">
                                            <div class="row">
                                                <div class="col-lg-4 col-sm-6 col-md-6">
                                                    <div class="card-body pt-0 text-center">
                                                        <div class="setting-card">
                                                            <h4>{{__('Picture')}}</h4>
                                                            <div class="logo-content mt-2 d-flex justify-content-center">
                                                                <img src="{{ !empty($users->avatar) ? $profile . '/' . $users->avatar : $profile . '/avatar.png' }}" id="blah" width="100px" class="border border-2 border-primary rounded user-img"/>
                                                            </div>
                                                            <div class="choose-files mt-4">
                                                                <label for="file-1">
                                                                    <div class="bg-primary profile_update text-white rounded p-2 text-xs cursor-pointer" style="max-width: 100% !important;">
                                                                        <i class="ti ti-upload px-1"></i>{{ __('Choose file here') }}
                                                                    </div>
                                                                    <input type="file" class="form-control file d-none" name="profile" id="file-1" data-filename="profile_update">
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-lg-8 col-sm-6 col-md-6">
                                                    <div class="card-body pt-0">
                                                        @if(\Auth::user()->type=='client')
                                                            @php $client=$userDetail->clientDetail; @endphp
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-3">
                                                                    {{Form::label('name',__('Name'),array('class'=>'col-form-label')) }}
                                                                    {{Form::text('name',null,array('class'=>'form-control font-style','placeholder'=>__('Enter User Name')))}}
                                                                    @error('name')
                                                                    <span class="invalid-name" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-3">
                                                                    {{Form::label('email',__('Email'),array('class'=>'col-form-label')) }}
                                                                    {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter User Email')))}}
                                                                    @error('email')
                                                                    <span class="invalid-email" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-3">
                                                                    {{Form::label('name',__('Name'),array('class'=>'col-form-label')) }}<x-required></x-required>
                                                                    {{Form::text('name',null,array('class'=>'form-control font-style','placeholder'=>__('Enter User Name'),'required'=>'required'))}}
                                                                    @error('name')
                                                                    <span class="invalid-name" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group mb-3">
                                                                    {{Form::label('email',__('Email'),array('class'=>'col-form-label')) }}<x-required></x-required>
                                                                    {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter User Email'),'required'=>'required'))}}
                                                                    @error('email')
                                                                    <span class="invalid-email" role="alert">
                                                                        <strong class="text-danger">{{ $message }}</strong>
                                                                    </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="col-sm-12">
                                            <div class="text-end">
                                                {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-xs btn-primary']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{Form::close()}}
                    </div>
                    
                    <!-- Change Password -->
                    <div class="mt-4" id="Change_Password">
                        {{Form::model($userDetail,array('route' => array('update.password',$userDetail->id), 'method' => 'put', 'class'=>'needs-validation', 'novalidate'))}}
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ __('Change Password') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    {{Form::label('current_password',__('Current Password'),array('class'=>'col-form-label')) }}<x-required></x-required>
                                                    {{Form::password('current_password',array('class'=>'form-control','placeholder'=>__('Enter Current Password'),'required'=>'required'))}}
                                                    @error('current_password')
                                                    <span class="invalid-current_password" role="alert">
                                                         <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    {{Form::label('new_password',__('New Password'),array('class'=>'col-form-label')) }}<x-required></x-required>
                                                    {{Form::password('new_password',array('class'=>'form-control','placeholder'=>__('Enter New Password'),'required'=>'required'))}}
                                                    @error('new_password')
                                                    <span class="invalid-new_password" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group mb-3">
                                                    {{Form::label('confirm_password',__('Re-type New Password'),array('class'=>'col-form-label')) }}<x-required></x-required>
                                                    {{Form::password('confirm_password',array('class'=>'form-control','placeholder'=>__('Enter Re-type New Password'),'required'=>'required'))}}
                                                    @error('confirm_password')
                                                    <span class="invalid-confirm_password" role="alert">
                                                        <strong class="text-danger">{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="col-sm-12">
                                            <div class="text-end">
                                                {{ Form::submit(__('Save Changes'), ['class' => 'btn btn-xs btn-primary']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-ui.page-container>
@endsection

@push('script-page')
    <script>
        $(document).on('click', '.list-group-item', function() {
            $('.list-group-item').removeClass('active');
            $('.list-group-item').removeClass('text-primary');
            setTimeout(() => {
                $(this).addClass('active').removeClass('text-primary');
            }, 10);
        });

        var type = window.location.hash.substr(1);
        $('.list-group-item').removeClass('active');
        $('.list-group-item').removeClass('text-primary');
        if (type != '') {
            $('a[href="#' + type + '"]').addClass('active').removeClass('text-primary');
        } else {
            $('.list-group-item:eq(0)').addClass('active').removeClass('text-primary');
        }

        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        })
    </script>
@endpush
