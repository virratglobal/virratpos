@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Manage Themes') }}
@endsection

@section('content')
    {{ Form::open(['route' => ['store.changetheme', $store_settings->id], 'method' => 'POST']) }}
    {{ Form::hidden('themefile', null, ['id' => 'themefile']) }}
    
    <x-ui.page-container>
        <x-ui.page-header title="{{ __('Manage Themes') }}">
            <x-slot name="breadcrumbs">
                <a href="{{ route('dashboard') }}" class="hover:text-gray-900">{{ __('Home') }}</a>
                <svg class="flex-shrink-0 mx-2 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
                <span class="text-gray-900 font-medium">{{ __('Themes') }}</span>
            </x-slot>

            <x-slot name="actions">
                <button type="submit" class="btn btn-primary d-inline-flex align-items-center">
                    <i data-feather="check-circle" class="me-2"></i>{{ __('Save Changes') }}
                </button>
            </x-slot>
        </x-ui.page-header>

        <div class="tab-pane themes-main-sec" id="pills-theme_setting" role="tabpanel" aria-labelledby="pills-theme_setting">
            @php
                $themeImg = \App\Models\Utility::get_file('uploads/store_theme/');
            @endphp
            <div class="card p-4">
                <div class="row gy-4">
                    @foreach (\App\Models\Utility::themeOne() as $key => $v)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12">
                            <div class="theme-card border border-2 rounded p-2 {{ $key }} {{ $store_settings['theme_dir'] == $key ? 'border-primary selected' : 'border-outline-variant/30' }}">
                                <div class="theme-card-inner">
                                    <div class="theme-image border rounded overflow-hidden">
                                        <img src="{{ asset(Storage::url('uploads/store_theme/' . $key . '/Home.png')) }}"
                                            class="color1 img-center pro_max_width pro_max_height img-fluid cursor-pointer {{ $key }}_img"
                                            data-id="{{ $key }}" style="max-height: 200px; object-fit: cover; width: 100%;">
                                    </div>
                                    <div class="theme-content theme-edit-content mt-3">
                                        <h6 class="mb-0 text-sm font-semibold">{{ __('Select Sub-Color') }}</h6>
                                        <div class="d-flex mt-2 flex-wrap row-gaps justify-content-between align-items-center {{ $key == 'theme10' ? 'theme10box' : '' }}"
                                            id="{{ $key }}">
                                            <div class="color-inputs">
                                                @foreach ($v as $css => $val)
                                                    <label class="colorinput cursor-pointer me-1">
                                                        <input name="theme_color" id="color1-theme4" type="radio"
                                                            value="{{ $css }}" data-theme="{{ $key }}"
                                                            data-imgpath="{{ $val['img_path'] }}"
                                                            class="colorinput-input color-{{ $loop->index++ }} d-none"
                                                            {{ isset($store_settings['store_theme']) && $store_settings['store_theme'] == $css && $store_settings['theme_dir'] == $key ? 'checked' : '' }}>
                                                        <span class="border-box d-inline-block rounded-circle p-1 border">
                                                            <span class="colorinput-color d-block rounded-circle"
                                                                style="background: #{{ $val['color'] }}; width: 16px; height: 16px;"></span>
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                            @can('Edit Themes')
                                                @if (isset($store_settings['theme_dir']) && $store_settings['theme_dir'] == $key)
                                                    <a href="{{ route('store.editproducts', [$store_settings->slug, $key]) }}"
                                                        class="btn btn-sm btn-secondary" id="button-addon2" data-bs-placement="top" data-bs-toggle="tooltip" title="{{ __('Edit') }}">
                                                        <i class="ti ti-pencil f-20 me-1"></i>
                                                        {{ __('Edit') }}
                                                    </a>
                                                @endif
                                            @endcan
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </x-ui.page-container>
    {!! Form::close() !!}
@endsection

@push('script-page')
    <script>
        $(document).on('click', 'input[name="theme_color"]', function() {
            var eleParent = $(this).attr('data-theme');
            $('#themefile').val(eleParent);
            var imgpath = $(this).attr('data-imgpath');
            $('.' + eleParent + '_img').attr('src', imgpath);
        });
        $(document).ready(function() {
            setTimeout(function(e) {
                var checked = $("input[type=radio][name='theme_color']:checked");
                $('#themefile').val(checked.attr('data-theme'));
                $('.' + checked.attr('data-theme') + '_img').attr('src', checked.attr('data-imgpath'));
            }, 300);
        });
        $(".color1").click(function() {
            var dataId = $(this).attr("data-id");
            $('#' + dataId).trigger('click');
            var first_check = $('#' + dataId).find('.color-0').trigger("click");
            $( ".theme-card" ).each(function() {
                $(".theme-card").removeClass('selected border-primary').addClass('border-outline-variant/30');
            });
            $('.' +dataId).addClass('selected border-primary').removeClass('border-outline-variant/30');
        });
    </script>
@endpush
