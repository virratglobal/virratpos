@extends('layouts.ui-admin')

@section('page-title')
    {{__('Language')}}
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
    <x-ui.page-header title="{{ __('Language') }}">
        <x-slot name="breadcrumbs">
            <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
            <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
            <span class="text-gray-900 font-medium">{{ __('Language') }}</span>
        </x-slot>

        <x-slot name="actions">
            <div class="pr-2 d-flex justify-content-end align-items-center space-x-3">
                @if($currantLang != (!empty( $settings['default_language']) ?  $settings['default_language'] : 'en'))
                    <div class="form-check form-switch custom-switch-v1 mb-0">
                        <input type="hidden" name="disable_lang" value="off">
                        <input type="checkbox" class="form-check-input input-primary cursor-pointer" name="disable_lang" data-bs-placement="top" title="{{ __('Enable/Disable') }}" id="disable_lang" data-bs-toggle="tooltip" {{ !in_array($currantLang,$disabledLang) ? 'checked':'' }} > 
                        <label class="form-check-label mb-0" for="disable_lang"></label>
                    </div>
                @endif
                @can('Delete Language')
                    @if($currantLang != (!empty( $settings['default_language']) ?  $settings['default_language'] : 'en'))
                        <a href="#!" class="bs-pass-para btn btn-sm bg-danger text-white"
                            data-title="{{ __('Delete Lead') }}"
                            data-confirm="{{ __('Are You Sure?') }}"
                            data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                            data-confirm-yes="delete-form-{{ $currantLang}}"
                            data-bs-toggle="tooltip" data-bs-placement="top"
                            title="{{ __('Delete') }}">
                            <i class="ti ti-trash"></i>
                        </a>
                        {!! Form::open(['method' => 'DELETE', 'route' => ['lang.destroy', $currantLang],'id'=>'delete-form-'.$currantLang]) !!}
                        {!! Form::close() !!}
                    @endif
                @endcan
            </div>
        </x-slot>
    </x-ui.page-header>

    <div class="row mt-3">
        <div class="col-lg-3">
            <div class="card sticky-top" style="top:30px">
                <div class="list-group list-group-flush" id="useradd-sidenav" style="padding: 8px;">
                    @foreach($languages as $code => $lang)
                        <a href="{{route('manage.language',[$code])}}" class="list-group-item list-group-item-action border-0 @if($currantLang == $code) active @endif">
                            {{ucFirst($lang)}}
                            <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="p-3 card mb-3">
                <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-user-tab-1" data-bs-toggle="pill"
                            data-bs-target="#home" type="button">{{ __('Labels')}}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-user-tab-2" data-bs-toggle="pill"
                            data-bs-target="#profile" type="button">{{ __('Messages')}}</button>
                    </li>
                </ul>
            </div>

            <div class="card card-fluid">
                <div class="card-body" style="position: relative;">
                    <div class="tab-content no-padding" id="myTab2Content">
                        <!-- Labels Tab -->
                        <div class="tab-pane fade show active" id="lang1" role="tabpanel" aria-labelledby="home-tab4">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                    <form method="post" action="{{route('store.language.data',[$currantLang])}}" class="needs-validation" novalidate>
                                        @csrf
                                        <div class="row">
                                            @foreach($arrLabel as $label => $value)
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label" for="example3cols1Input">{{$label}} </label>
                                                        <input type="text" class="form-control" name="label[{{$label}}]" value="{{$value}}">
                                                    </div>
                                                </div>
                                            @endforeach
                                            <div class="col-lg-12">
                                                <div class="text-end">
                                                    <div class="d-flex justify-content-end">
                                                        {{Form::submit(__('Save Changes'),array('class'=>'btn btn-xs btn-primary'))}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- Messages Tab -->
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <form method="post" action="{{route('store.language.data',[$currantLang])}}" class="needs-validation" novalidate>
                                        @csrf
                                        <div class="row">
                                            @foreach($arrMessage as $fileName => $fileValue)
                                                <div class="col-lg-12 mt-3">
                                                    <h5 class="text-lg font-semibold text-zinc-900">{{ucfirst($fileName)}}</h5>
                                                </div>
                                                @foreach($fileValue as $label => $value)
                                                    @if(is_array($value))
                                                        @foreach($value as $label2 => $value2)
                                                            @if(is_array($value2))
                                                                @foreach($value2 as $label3 => $value3)
                                                                    @if(is_array($value3))
                                                                        @foreach($value3 as $label4 => $value4)
                                                                            @if(is_array($value4))
                                                                                @foreach($value4 as $label5 => $value5)
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group mb-3">
                                                                                            <label class="form-label">{{$fileName}}.{{$label}}.{{$label2}}.{{$label3}}.{{$label4}}.{{$label5}}</label>
                                                                                            <input type="text" class="form-control" name="message[{{$fileName}}][{{$label}}][{{$label2}}][{{$label3}}][{{$label4}}][{{$label5}}]" value="{{$value5}}">
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            @else
                                                                                <div class="col-lg-6">
                                                                                    <div class="form-group mb-3">
                                                                                        <label class="form-label">{{$fileName}}.{{$label}}.{{$label2}}.{{$label3}}.{{$label4}}</label>
                                                                                        <input type="text" class="form-control" name="message[{{$fileName}}][{{$label}}][{{$label2}}][{{$label3}}][{{$label4}}]" value="{{$value4}}">
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                        @endforeach
                                                                    @else
                                                                        <div class="col-lg-6">
                                                                            <div class="form-group mb-3">
                                                                                <label class="form-label">{{$fileName}}.{{$label}}.{{$label2}}.{{$label3}}</label>
                                                                                <input type="text" class="form-control" name="message[{{$fileName}}][{{$label}}][{{$label2}}][{{$label3}}]" value="{{$value3}}">
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            @else
                                                                <div class="col-lg-6">
                                                                    <div class="form-group mb-3">
                                                                        <label class="form-label">{{$fileName}}.{{$label}}.{{$label2}}</label>
                                                                        <input type="text" class="form-control" name="message[{{$fileName}}][{{$label}}][{{$label2}}]" value="{{$value2}}">
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        <div class="col-lg-6">
                                                            <div class="form-group mb-3">
                                                                <label class="form-label">{{$fileName}}.{{$label}}</label>
                                                                <input type="text" class="form-control" name="message[{{$fileName}}][{{$label}}]" value="{{$value}}">
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </div>
                                        <div class="col-lg-12 mt-3">
                                            <div class="text-end">
                                                <div class="d-flex justify-content-end">
                                                    {{Form::submit(__('Save Changes'),array('class'=>'btn btn-xs btn-primary'))}}
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-ui.page-container>
@endsection

@push('script-page')
    <script>
        $(document).on('change','#disable_lang',function(){
           var val = $(this).prop("checked");
           if(val == true){
                var langMode = 'on';
           }
           else{
                var langMode = 'off';
           }
           $.ajax({
                type:'POST',
                url: "{{route('disablelanguage')}}",
                datType: 'json',
                data:{
                    "_token": "{{ csrf_token() }}",
                    "mode":langMode,
                    "lang":"{{ $currantLang }}"
                },
                success : function(data){
                    show_toastr('Success',data.message, 'success')
                }
           });
        });
    </script>
@endpush
