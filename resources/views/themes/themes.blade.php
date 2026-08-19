@extends('layouts.ui-admin')

@section('page-title')
    {{ __('Manage Themes') }}
@endsection

@php
    $themeDetails = [
        'theme1' => ['name' => 'Classic Fresh', 'category' => 'Other'],
        'theme2' => ['name' => 'Sunny Amber', 'category' => 'Other'],
        'theme3' => ['name' => 'Lime Green', 'category' => 'Other'],
        'theme4' => ['name' => 'Slate Steel', 'category' => 'Other'],
        'theme5' => ['name' => 'Royal Indigo', 'category' => 'Other'],
        'theme6' => ['name' => 'Lime Garden', 'category' => 'Other'],
        'theme7' => ['name' => 'Nordic Forest', 'category' => 'Other'],
        'theme8' => ['name' => 'Earth Charcoal', 'category' => 'Other'],
        'theme9' => ['name' => 'Midnight Onyx', 'category' => 'Other'],
        'theme10' => ['name' => 'Ocean Cobalt', 'category' => 'Other'],
        'theme11' => ['name' => 'E-Tech Premium', 'category' => 'Electronics'],
        'theme12' => ['name' => 'Editorial Thread', 'category' => 'Fashion'],
        'theme13' => ['name' => 'High Couture', 'category' => 'Fashion'],
        'theme14' => ['name' => 'Casa Lifestyle', 'category' => 'Furniture'],
        'theme15' => ['name' => 'Glow & Glam', 'category' => 'Beauty'],
        'theme16' => ['name' => 'Super Fresh', 'category' => 'Grocery'],
        'theme17' => ['name' => 'Precision Chrono', 'category' => 'Fashion'],
        'theme18' => ['name' => 'Pro Athletica', 'category' => 'Sports'],
        'theme19' => ['name' => 'Gear & Torque', 'category' => 'Automotive'],
        'theme20' => ['name' => 'Earth Organic', 'category' => 'Other'],
        'theme21' => ['name' => 'Apothecary Plus', 'category' => 'Other'],
        'theme22' => ['name' => 'Gigabyte Shop', 'category' => 'Electronics'],
        'theme23' => ['name' => 'Habitat Living', 'category' => 'Furniture'],
        'theme24' => ['name' => 'Sole Drop', 'category' => 'Sports'],
        'theme25' => ['name' => 'Bijoux Editorial', 'category' => 'Fashion'],
        'theme26' => ['name' => 'Paws & Purrs', 'category' => 'Other'],
        'theme27' => ['name' => 'Le Gourmet Menu', 'category' => 'Other'],
        'theme28' => ['name' => 'Pure Minimalist', 'category' => 'Fashion'],
        'theme29' => ['name' => 'Obsidian Dark', 'category' => 'Other'],
        'theme30' => ['name' => 'Omni Marketplace', 'category' => 'Other'],
    ];
@endphp

@section('content')
    {{ Form::open(['route' => ['store.changetheme', $store_settings->id], 'method' => 'POST']) }}
    {{ Form::hidden('themefile', null, ['id' => 'themefile']) }}
    
    <x-ui.page-container>
        <x-ui.page-header title="{{ __('Manage Themes') }}">
            <x-slot name="breadcrumbs">
                <a href="{{ route('dashboard') }}" class="hover:text-gray-900 text-slate-500 text-xs text-decoration-none">{{ __('Home') }}</a>
                <svg class="flex-shrink-0 mx-1.5 h-4 w-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
                <span class="text-gray-900 font-medium text-xs">{{ __('Themes') }}</span>
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
                
                <!-- Category Filters -->
                <div class="mb-4 d-flex align-items-center flex-wrap gap-2 pb-3 border-bottom border-slate-100">
                    <button type="button" class="category-filter-btn px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-xs font-semibold border-none cursor-pointer" data-filter="all">All</button>
                    <button type="button" class="category-filter-btn px-3 py-1.5 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-lg text-xs font-semibold border-none cursor-pointer" data-filter="Fashion">Fashion</button>
                    <button type="button" class="category-filter-btn px-3 py-1.5 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-lg text-xs font-semibold border-none cursor-pointer" data-filter="Electronics">Electronics</button>
                    <button type="button" class="category-filter-btn px-3 py-1.5 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-lg text-xs font-semibold border-none cursor-pointer" data-filter="Furniture">Furniture</button>
                    <button type="button" class="category-filter-btn px-3 py-1.5 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-lg text-xs font-semibold border-none cursor-pointer" data-filter="Beauty">Beauty</button>
                    <button type="button" class="category-filter-btn px-3 py-1.5 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-lg text-xs font-semibold border-none cursor-pointer" data-filter="Grocery">Grocery</button>
                    <button type="button" class="category-filter-btn px-3 py-1.5 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-lg text-xs font-semibold border-none cursor-pointer" data-filter="Sports">Sports</button>
                    <button type="button" class="category-filter-btn px-3 py-1.5 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-lg text-xs font-semibold border-none cursor-pointer" data-filter="Automotive">Automotive</button>
                    <button type="button" class="category-filter-btn px-3 py-1.5 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-lg text-xs font-semibold border-none cursor-pointer" data-filter="Other">Other</button>
                </div>

                <div class="row gy-4">
                    @foreach (\App\Models\Utility::themeOne() as $key => $v)
                        @php
                            $themeDetail = isset($themeDetails[$key]) ? $themeDetails[$key] : ['name' => ucfirst($key), 'category' => 'Other'];
                            $first_variant = reset($v);
                            $default_img = isset($first_variant['img_path']) ? $first_variant['img_path'] : asset(Storage::url('uploads/store_theme/' . $key . '/Home.png'));
                        @endphp
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 theme-item-card" data-category="{{ $themeDetail['category'] }}">
                            <div class="theme-card border border-2 rounded p-2 {{ $key }} {{ $store_settings->getRawOriginal('theme_dir') == $key ? 'border-primary selected shadow-sm' : 'border-outline-variant/30' }}" style="transition: all 0.2s ease-in-out;">
                                <div class="theme-card-inner">
                                    <div class="theme-image border rounded overflow-hidden position-relative">
                                        <img src="{{ $default_img }}"
                                            class="color1 img-center pro_max_width pro_max_height img-fluid cursor-pointer {{ $key }}_img"
                                            data-id="{{ $key }}" style="height: 180px; object-fit: cover; width: 100%;">
                                        
                                        @if ($store_settings->getRawOriginal('theme_dir') == $key)
                                            <div class="position-absolute top-2 end-2 bg-primary text-white text-[10px] font-bold px-2 py-0.5 rounded-pill shadow-sm" style="font-size: 10px;">
                                                ✓ {{ __('Active') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="theme-content theme-edit-content mt-3">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <span class="text-xs font-bold text-slate-800" style="font-size: 13px;">{{ $themeDetail['name'] }}</span>
                                            <span class="text-[9px] font-bold text-slate-400 uppercase bg-slate-100 px-1.5 py-0.5 rounded" style="font-size: 9px;">{{ $themeDetail['category'] }}</span>
                                        </div>
                                        
                                        <h6 class="mb-0 text-sm font-semibold" style="font-size: 11px; color: #64748b; text-transform: uppercase;">{{ __('Select Sub-Color') }}</h6>
                                        <div class="d-flex mt-2 flex-wrap row-gaps justify-content-between align-items-center {{ $key == 'theme10' ? 'theme10box' : '' }}"
                                            id="{{ $key }}">
                                            <div class="color-inputs">
                                                @foreach ($v as $css => $val)
                                                    <label class="colorinput cursor-pointer me-1">
                                                        <input name="theme_color" id="color1-theme4" type="radio"
                                                            value="{{ $css }}" data-theme="{{ $key }}"
                                                            data-imgpath="{{ $val['img_path'] }}"
                                                            class="colorinput-input color-{{ $loop->index++ }} d-none"
                                                            {{ isset($store_settings['store_theme']) && $store_settings['store_theme'] == $css && $store_settings->getRawOriginal('theme_dir') == $key ? 'checked' : '' }}>
                                                        <span class="border-box d-inline-block rounded-circle p-1 border">
                                                            <span class="colorinput-color d-block rounded-circle"
                                                                style="background: #{{ $val['color'] }}; width: 14px; height: 14px;"></span>
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                            @can('Edit Themes')
                                                @if ($store_settings->getRawOriginal('theme_dir') == $key)
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
                if (checked.length) {
                    $('#themefile').val(checked.attr('data-theme'));
                    $('.' + checked.attr('data-theme') + '_img').attr('src', checked.attr('data-imgpath'));
                }
            }, 300);

            // Category Filter Buttons
            $('.category-filter-btn').click(function() {
                // Reset active button styling
                $('.category-filter-btn').removeClass('bg-indigo-600 text-white').addClass('bg-slate-100 text-slate-600 hover:bg-slate-200');
                $(this).addClass('bg-indigo-600 text-white').removeClass('bg-slate-100 text-slate-600 hover:bg-slate-200');
                
                var filter = $(this).attr('data-filter');
                if (filter === 'all') {
                    $('.theme-item-card').show();
                } else {
                    $('.theme-item-card').hide();
                    $('.theme-item-card[data-category="' + filter + '"]').show();
                }
            });
        });
        $(".color1").click(function() {
            var dataId = $(this).attr("data-id");
            $('#' + dataId).trigger('click');
            var first_check = $('#' + dataId).find('.color-0').trigger("click");
            $( ".theme-card" ).each(function() {
                $(".theme-card").removeClass('selected border-primary shadow-sm').addClass('border-outline-variant/30');
            });
            $('.' +dataId).addClass('selected border-primary shadow-sm').removeClass('border-outline-variant/30');
        });
    </script>
@endpush
