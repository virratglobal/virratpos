@extends('layouts.ui-admin')
@section('page-title')
    {{ __('Edit Product') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
<li class="breadcrumb-item"><a href="{{ route('product.index') }}">{{ __('Product') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Edit') }}</li>
@endsection

@push('style')
<link rel="stylesheet" href="{{ asset('custom/libs/summernote/summernote-bs4.css') }}">
<style>
.pc-page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;flex-wrap:wrap;gap:12px}
.pc-page-title{font-family:'Geist',sans-serif;font-size:1.45rem;font-weight:700;letter-spacing:-0.04em;color:#0b1c30;margin:0}
.pc-page-sub{font-family:'Inter',sans-serif;font-size:13px;color:#767586;margin-top:3px}
.pc-actions{display:flex;gap:10px;align-items:center;flex-shrink:0}
.pc-btn{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:9px;font-family:'Geist',sans-serif;font-size:13px;font-weight:500;cursor:pointer;border:none;transition:all .18s;text-decoration:none;white-space:nowrap}
.pc-btn-primary{background:#4648d4;color:#fff}
.pc-btn-primary:hover{background:#2f2ebe;color:#fff}
.pc-btn-secondary{background:#e5eeff;color:#4648d4}
.pc-btn-secondary:hover{background:#dce9ff;color:#4648d4}
.pc-btn-ai{background:#e5eeff;color:#4648d4;border:1px solid rgba(70,72,212,0.2)}
.pc-btn-ai:hover{background:#dce9ff}
.pc-btn .material-symbols-outlined{font-size:16px}
.pc-card{background:#fff;border:1px solid #ebebeb;border-radius:14px;overflow:hidden;margin-bottom:20px}
.pc-card-header{padding:16px 22px;border-bottom:1px solid #f0f0f0;display:flex;align-items:center;gap:10px}
.pc-card-header-icon{width:30px;height:30px;border-radius:8px;background:#6063ee;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.pc-card-header-icon .material-symbols-outlined{font-size:16px;color:#fff}
.pc-card-title{font-family:'Geist',sans-serif;font-size:14px;font-weight:600;color:#0b1c30;letter-spacing:-0.02em;margin:0}
.pc-card-body{padding:22px}
.pc-field{margin-bottom:18px}
.pc-field:last-child{margin-bottom:0}
.pc-label{display:block;font-family:'Geist',sans-serif;font-size:12px;font-weight:500;color:#464554;margin-bottom:5px;letter-spacing:0.01em}
.pc-label .req{color:#e53935;margin-left:2px}
.pc-input{width:100%;padding:10px 13px;border-radius:9px;border:1px solid #e2e0ec;background:#fafafa;font-family:'Inter',sans-serif;font-size:14px;color:#0b1c30;transition:border-color .18s,box-shadow .18s;outline:none;box-sizing:border-box}
.pc-input:focus{border-color:#4648d4;box-shadow:0 0 0 3px rgba(70,72,212,0.12);background:#fff}
.pc-input::placeholder{color:#b0aec0}
select.pc-input{cursor:pointer}
textarea.pc-input{resize:vertical;min-height:90px}
.pc-row-2{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.pc-toggle-row{display:flex;align-items:center;justify-content:space-between;padding:14px 0;border-bottom:1px solid #f3f3f3}
.pc-toggle-row:last-child{border-bottom:none;padding-bottom:0}
.pc-toggle-label{font-family:'Inter',sans-serif;font-size:13px;font-weight:500;color:#0b1c30}
.pc-toggle-sub{font-family:'Inter',sans-serif;font-size:12px;color:#767586;margin-top:2px}
.pc-switch{position:relative;display:inline-block;width:40px;height:22px;flex-shrink:0}
.pc-switch input{opacity:0;width:0;height:0}
.pc-slider{position:absolute;cursor:pointer;inset:0;background:#e0dff0;border-radius:22px;transition:.2s}
.pc-slider::before{content:'';position:absolute;width:16px;height:16px;left:3px;bottom:3px;background:#fff;border-radius:50%;transition:.2s;box-shadow:0 1px 4px rgba(0,0,0,.15)}
.pc-switch input:checked + .pc-slider{background:#4648d4}
.pc-switch input:checked + .pc-slider::before{transform:translateX(18px)}
.pc-upload-zone{border:2px dashed #e2e0ec;border-radius:12px;padding:28px 20px;text-align:center;background:#fafafa;cursor:pointer;transition:border-color .18s,background .18s;position:relative}
.pc-upload-zone:hover{border-color:#4648d4;background:#f5f5f5}
.pc-upload-title{font-family:'Geist',sans-serif;font-size:13px;font-weight:600;color:#0b1c30}
.pc-upload-sub{font-family:'Inter',sans-serif;font-size:12px;color:#767586;margin-top:3px}
.pc-upload-btn{display:inline-block;margin-top:12px;padding:7px 16px;border-radius:7px;background:#4648d4;color:#fff;font-family:'Geist',sans-serif;font-size:12px;font-weight:500;cursor:pointer;transition:background .18s}
.pc-upload-btn:hover{background:#2f2ebe}
.pc-cover-preview{width:100%;max-height:140px;object-fit:cover;border-radius:10px;margin-top:12px;display:none;border:1px solid #ebebeb}
.pc-file-input-hidden{display:none}
.pc-variant-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px}
.pc-variant-add{display:inline-flex;align-items:center;gap:5px;padding:7px 13px;border-radius:8px;background:#4648d4;color:#fff;font-family:'Geist',sans-serif;font-size:12px;font-weight:500;border:none;cursor:pointer;transition:background .18s}
.pc-variant-add:hover{background:#2f2ebe}
.pc-variant-add .material-symbols-outlined{font-size:15px}
.pc-link{color:#4648d4;font-weight:500;text-decoration:underline;font-size:12px}
.pc-link:hover{color:#2f2ebe}
.note-editor.note-frame{border-radius:10px !important;border:1px solid #e2e0ec !important}
.note-toolbar{border-radius:10px 10px 0 0 !important;background:#f8f8f8 !important;border-bottom:1px solid #e2e0ec !important}
.dropzone{border:none !important;padding:0 !important;min-height:unset !important;background:transparent !important}
.pc-grid{display:grid;grid-template-columns:1fr 340px;gap:24px;align-items:start}
@media(max-width:1024px){.pc-grid{grid-template-columns:1fr}.pc-row-2{grid-template-columns:1fr}}
.pc-sidebar-col{position:sticky;top:20px}
</style>
@endpush

@push('scripts')
<script src="{{ asset('custom/libs/summernote/summernote-bs4.js') }}"></script>
<script>
var Dropzones = function() {
    var e = $('[data-toggle="dropzone1"]'), t = $(".dz-preview");
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    e.length && (Dropzone.autoDiscover = !1, e.each(function() {
        var e, a, n, o, i;
        e = $(this), a = void 0 !== e.data("dropzone-multiple"), n = e.find(t), o = void 0, i = {
            url: "{{ route('products.update', $product->id) }}",
            method: 'PUT',
            headers: { 'x-csrf-token': CSRF_TOKEN },
            thumbnailWidth: null, thumbnailHeight: null,
            previewsContainer: n.get(0), previewTemplate: n.html(),
            maxFiles: 10, parallelUploads: 10,
            autoProcessQueue: false, uploadMultiple: true,
            acceptedFiles: a ? null : "image/*",
            success: function(file, response) {
                if (response.flag == "success") {
                    show_toastr('success', response.msg, 'success');
                    window.location.href = "{{ route('product.index') }}";
                } else { show_toastr('Error', response.msg, 'error'); }
            },
            error: function(file, response) {
                if (response.error) { show_toastr('Error', response.error, 'error'); }
                else { show_toastr('Error', response, 'error'); }
            },
            init: function() {
                var myDropzone = this;
                this.on("addedfile", function(e) { !a && o && this.removeFile(o); o = e; })
            }
        };
        n.html(""); e.dropzone(i);
    }))
}();

$('#submit-all').on('click', function(e) {
    e.preventDefault();
    $('.product-submit-button').trigger('click');
});

$(document).on("submit", ".submit-product", function(e) {
    e.preventDefault();
    $('#submit-all').attr('disabled', true);
    var fd = new FormData();
    var file = document.getElementById('is_cover_image').files[0];
    var attachment = document.getElementById('attachment').files[0];
    var downloadable_prodcutfile = document.getElementById('downloadable_prodcut').files[0];
    if (file) fd.append('is_cover_image', file);
    if (downloadable_prodcutfile) fd.append('downloadable_prodcut', downloadable_prodcutfile);
    if (attachment) fd.append('attachment', attachment);
    var files = $('[data-toggle="dropzone1"]').get(0).dropzone.getAcceptedFiles();
    $.each(files, function(key, file) {
        fd.append('multiple_files[' + key + ']', $('[data-toggle="dropzone1"]')[0].dropzone.getAcceptedFiles()[key]);
    });
    var other_data = $('#frmTarget').serializeArray();
    $.each(other_data, function(key, input) { fd.append(input.name, input.value); });
    $.ajax({
        url: "{{ route('products.update', $product->id) }}",
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: fd, contentType: false, processData: false, type: 'POST',
        success: function(data) {
            if (data.flag == "success") {
                $('#submit-all').attr('disabled', true);
                show_toastr('success', data.msg, 'success');
                window.location.href = "{{ route('product.index') }}";
            } else {
                show_toastr('Error', data.msg, 'error');
                $('#submit-all').attr('disabled', false);
            }
        },
        error: function(data) {
            $('#submit-all').attr('disabled', false);
            if (data.error) { show_toastr('Error', data.error, 'error'); }
            else { show_toastr('Error', data, 'error'); }
        }
    });
});

$(document).on('click', '.get-variants', function(e) {
    $("#commonModal .modal-title").html('{{ __("Add Variants") }}');
    $("#commonModal .modal-dialog").addClass('modal-md');
    $("#commonModal").modal('show');
    $.get('{{ route("product.variants.edit", $product->id) }}', {}, function(data) {
        $('#commonModal .modal-body').html(data);
    });
});

$(document).on('click', '.add-variants', function(e) {
    e.preventDefault();
    var form = $(this).parents('form');
    var variantNameEle = $('#variant_name');
    var variantOptionsEle = $('#variant_options');
    var isValid = true;
    if (variantNameEle.val() == '') { variantNameEle.focus(); isValid = false; }
    else if (variantOptionsEle.val() == '') { variantOptionsEle.focus(); isValid = false; }
    if (isValid) {
        $.ajax({
            url: form.attr('action'), datType: 'json',
            data: { variant_name: variantNameEle.val(), variant_options: variantOptionsEle.val(), hiddenVariantOptions: $('#hiddenVariantOptions').val() },
            success: function(data) {
                $('#hiddenVariantOptions').val(data.hiddenVariantOptions);
                $('.variant-table').html(data.varitantHTML);
                $("#commonModal").modal('hide');
            }
        });
    }
});

$(".deleteRecord").click(function() {
    var id = $(this).data("id");
    var token = $("meta[name='csrf-token']").attr("content");
    $.ajax({
        url: '{{ route('products.file.delete', '__product_id') }}'.replace('__product_id', id),
        type: 'DELETE',
        data: {
            "id": id,
            "_token": token,
        },
        success: function(data) {
            if (data.success) {
                show_toastr('success', data.success, 'success');
                $('.product_Image[data-id="' + data.id + '"]').remove();
            } else {
                show_toastr('Error', data.error, 'error');
            }
        }
    });
});
</script>
@endpush

@php
    $plan = \App\Models\Plan::find(\Auth::user()->plan);
    $is_cover_image = \App\Models\Utility::get_file('uploads/is_cover_image/');
    $productimage = \App\Models\Utility::get_file('uploads/product_image/');
@endphp

@section('content')
<div class="dash-container">
    <div class="pc-page-header">
        <div>
            <h1 class="pc-page-title">{{ __('Edit Product') }}</h1>
            <p class="pc-page-sub">{{ __('Modify product details below.') }}</p>
        </div>
        <div class="pc-actions">
            @if($plan->enable_chatgpt == 'on')
                <a href="#" class="pc-btn pc-btn-ai" data-size="lg" data-ajax-popup-over="true" data-url="{{ route('generate',['products']) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Generate') }}" data-title="{{ __('Generate Content With AI') }}">
                    <span class="material-symbols-outlined">smart_toy</span>
                    {{ __('Generate with AI') }}
                </a>
            @endif
            <a href="{{ route('product.index') }}" class="pc-btn pc-btn-secondary">
                <span class="material-symbols-outlined">close</span>
                {{ __('Cancel') }}
            </a>
            <button type="button" id="submit-all" class="pc-btn pc-btn-primary">
                <span class="material-symbols-outlined">check_circle</span>
                {{ __('Save Changes') }}
            </button>
        </div>
    </div>

    {{ Form::model($product, ['method' => 'POST', 'id' => 'frmTarget', 'enctype' => 'multipart/form-data', 'class'=>'submit-product needs-validation', 'novalidate']) }}
    <div class="pc-grid">
        {{-- Left Column --}}
        <div>
            {{-- Card 1: Main Information --}}
            <div class="pc-card">
                <div class="pc-card-header">
                    <div class="pc-card-header-icon">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                    <h3 class="pc-card-title">{{ __('Main Information') }}</h3>
                </div>
                <div class="pc-card-body">
                    <div class="pc-field">
                        {{ Form::label('name', __('Product Name'), ['class' => 'pc-label']) }}<x-required></x-required>
                        {{ Form::text('name', null, ['class' => 'pc-input', 'placeholder' => __('e.g. Wireless Headphones'), 'required' => 'required']) }}
                    </div>

                    <div class="pc-field">
                        {{ Form::label('product_categorie', __('Product Categories'), ['class' => 'pc-label']) }}
                        {!! Form::select('product_categorie[]', $product_categorie, explode(',',$product->product_categorie), [
                            'class' => 'pc-input choices-multiple',
                            'id' => 'choices-multiple',
                            'multiple',
                        ]) !!}
                        @if (count($product_categorie) == 0)
                            <div class="mt-2 text-xs text-gray-500">
                                {{ __('No categories yet.') }} <a href="{{ route('product_categorie.index') }}" class="pc-link">{{ __('Add one') }}</a>
                            </div>
                        @endif
                    </div>

                    <div class="pc-row-2">
                        <div class="pc-field">
                            {{ Form::label('SKU', __('SKU'), ['class' => 'pc-label']) }}
                            {{ Form::text('SKU', null, ['class' => 'pc-input', 'placeholder' => __('e.g. WHP-2024-BLK')]) }}
                        </div>
                        <div class="pc-field">
                            {{ Form::label('product_tax', __('Product Tax'), ['class' => 'pc-label']) }}
                            {!! Form::select('product_tax[]', $product_tax, explode(',',$product->product_tax), [
                                'class' => 'pc-input choices-multiple1',
                                'id' => 'choices-multiple1',
                                'multiple',
                            ]) !!}
                            @if (count($product_tax) == 0)
                                <div class="mt-2 text-xs text-gray-500">
                                    {{ __('No taxes yet.') }} <a href="{{ route('product_tax.index') }}" class="pc-link">{{ __('Add one') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="pc-row-2">
                        <div class="pc-field">
                            {{ Form::label('price', __('Price'), ['class' => 'pc-label']) }}
                            {{ Form::number('price', null, ['step' => 'any', 'class' => 'pc-input', 'placeholder' => __('0.00')]) }}
                        </div>
                        <div class="pc-field">
                            {{ Form::label('last_price', __('Compare-at Price'), ['class' => 'pc-label']) }}
                            {{ Form::number('last_price', null, ['step' => 'any', 'class' => 'pc-input', 'placeholder' => __('0.00')]) }}
                        </div>
                    </div>

                    <div class="pc-field">
                        {{ Form::label('quantity', __('Stock Quantity'), ['class' => 'pc-label']) }}
                        {{ Form::text('quantity', null, ['class' => 'pc-input', 'placeholder' => __('e.g. 100')]) }}
                    </div>

                    <div class="pc-row-2">
                        <div class="pc-field">
                            <label for="attachment" class="pc-label">{{ __('Attachment') }}</label>
                            <input type="file" name="attachment" id="attachment" class="pc-input" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                            <img id="blah" src="" width="20%" class="mt-2" />
                        </div>
                        <div class="pc-field">
                            <label for="downloadable_prodcut" class="pc-label">{{ __('Downloadable Product File') }}</label>
                            <input type="file" name="downloadable_prodcut" id="downloadable_prodcut" class="pc-input" onchange="document.getElementById('down_product').src = window.URL.createObjectURL(this.files[0])">
                            <img id="down_product" src="" width="20%" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 2: Custom Fields --}}
            <div class="pc-card">
                <div class="pc-card-header">
                    <div class="pc-card-header-icon">
                        <span class="material-symbols-outlined">tune</span>
                    </div>
                    <h3 class="pc-card-title">{{ __('Custom Fields') }}</h3>
                </div>
                <div class="pc-card-body">
                    <div class="pc-row-2">
                        <div class="pc-field">
                            {{ Form::label('custom_field_1', __('Field Name'), ['class' => 'pc-label']) }}
                            {{ Form::text('custom_field_1', null, ['class' => 'pc-input', 'placeholder' => __('Field name')]) }}
                        </div>
                        <div class="pc-field">
                            {{ Form::label('custom_value_1', __('Field Value'), ['class' => 'pc-label']) }}
                            {{ Form::text('custom_value_1', null, ['class' => 'pc-input', 'placeholder' => __('Field value')]) }}
                        </div>
                    </div>
                    <div class="pc-row-2">
                        <div class="pc-field">
                            {{ Form::label('custom_field_2', __('Field Name'), ['class' => 'pc-label']) }}
                            {{ Form::text('custom_field_2', null, ['class' => 'pc-input', 'placeholder' => __('Field name')]) }}
                        </div>
                        <div class="pc-field">
                            {{ Form::label('custom_value_2', __('Field Value'), ['class' => 'pc-label']) }}
                            {{ Form::text('custom_value_2', null, ['class' => 'pc-input', 'placeholder' => __('Field value')]) }}
                        </div>
                    </div>
                    <div class="pc-row-2">
                        <div class="pc-field">
                            {{ Form::label('custom_field_3', __('Field Name'), ['class' => 'pc-label']) }}
                            {{ Form::text('custom_field_3', null, ['class' => 'pc-input', 'placeholder' => __('Field name')]) }}
                        </div>
                        <div class="pc-field">
                            {{ Form::label('custom_value_3', __('Field Value'), ['class' => 'pc-label']) }}
                            {{ Form::text('custom_value_3', null, ['class' => 'pc-input', 'placeholder' => __('Field value')]) }}
                        </div>
                    </div>
                    <div class="pc-row-2">
                        <div class="pc-field">
                            {{ Form::label('custom_field_4', __('Field Name'), ['class' => 'pc-label']) }}
                            {{ Form::text('custom_field_4', null, ['class' => 'pc-input', 'placeholder' => __('Field name')]) }}
                        </div>
                        <div class="pc-field">
                            {{ Form::label('custom_value_4', __('Field Value'), ['class' => 'pc-label']) }}
                            {{ Form::text('custom_value_4', null, ['class' => 'pc-input', 'placeholder' => __('Field value')]) }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 3: Visibility & Variants --}}
            <div class="pc-card">
                <div class="pc-card-header">
                    <div class="pc-card-header-icon">
                        <span class="material-symbols-outlined">toggle_on</span>
                    </div>
                    <h3 class="pc-card-title">{{ __('Visibility & Variants') }}</h3>
                </div>
                <div class="pc-card-body">
                    <div class="pc-toggle-row">
                        <div>
                            <div class="pc-toggle-label">{{ __('Product Display') }}</div>
                            <div class="pc-toggle-sub">{{ __('Make this product visible in your storefront.') }}</div>
                        </div>
                        <label class="pc-switch">
                            <input type="checkbox" name="product_display" id="product_display" {{ $product->product_display == 'on' ? 'checked' : '' }}>
                            <span class="pc-slider"></span>
                        </label>
                    </div>

                    @if (isset($product_variant_names))
                        <div class="pc-toggle-row">
                            <div>
                                <div class="pc-toggle-label">{{ __('Display Variants') }}</div>
                                <div class="pc-toggle-sub">{{ __('Enable multiple options (like size or color) for this product.') }}</div>
                            </div>
                            <label class="pc-switch">
                                <input type="checkbox" name="enable_product_variant" id="enable_product_variant" {{ $product->enable_product_variant == 'on' ? 'checked' : '' }}>
                                <input type="hidden" name="hiddenhidden" id="hiddenhidden" value="">
                                <span class="pc-slider"></span>
                            </label>
                        </div>

                        <div id="productVariant" class="mt-4" style="{{ $product->enable_product_variant == 'on' ? '' : 'display: none;' }}">
                            <div class="pc-variant-header">
                                <h4 class="text-sm font-semibold text-gray-900 m-0">{{ __('Product Variants') }}</h4>
                                @can('Edit Variants')
                                    <button type="button" class="pc-variant-add get-variants">
                                        <span class="material-symbols-outlined">add</span>
                                        {{ __('Add Variant') }}
                                    </button>
                                @endcan
                            </div>
                            <input type="hidden" id="hiddenVariantOptions" name="hiddenVariantOptions" value="{{ $product->variants_json }}">
                            <div class="variant-table overflow-x-auto">
                                <table class="table min-w-full divide-y divide-gray-200">
                                    <thead>
                                        <tr>
                                            @foreach ($product_variant_names as $variant)
                                                <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase">{{ ucwords($variant) }}</th>
                                            @endforeach
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('Price') }}</th>
                                            <th class="px-3 py-2 text-left text-xs font-semibold text-gray-500 uppercase">{{ __('Quantity') }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @if (isset($productVariantArrays))
                                            @foreach ($productVariantArrays as $counter => $productVariant)
                                                <tr data-id="{{ $productVariant['product_variants']['id'] }}">
                                                    @foreach (explode(' : ', $productVariant['product_variants']['name']) as $key => $values)
                                                        <td class="px-3 py-2 whitespace-nowrap">
                                                            <input type="text" name="variants[{{ $productVariant['product_variants']['id'] }}][variants][{{ $key }}][]" class="pc-input" style="padding: 6px 10px; font-size: 13px;" value="{{ $values }}" readonly>
                                                        </td>
                                                    @endforeach
                                                    <td class="px-3 py-2 whitespace-nowrap">
                                                        <input type="number" name="variants[{{ $productVariant['product_variants']['id'] }}][price]" class="pc-input vprice_{{ $counter }}" style="padding: 6px 10px; font-size: 13px; min-width: 80px;" value="{{ $productVariant['product_variants']['price'] }}" required>
                                                    </td>
                                                    <td class="px-3 py-2 whitespace-nowrap">
                                                        <input type="number" name="variants[{{ $productVariant['product_variants']['id'] }}][quantity]" class="pc-input vquantity_{{ $counter }}" style="padding: 6px 10px; font-size: 13px; min-width: 80px;" value="{{ $productVariant['product_variants']['quantity'] }}" required>
                                                    </td>
                                                    <td class="px-3 py-2 whitespace-nowrap text-right text-sm">
                                                        @can('Delete Variants')
                                                            <x-ui.button variant="danger" size="sm" class="bs-pass-para" data-title="{{ __('Delete Lead') }}" data-confirm="{{ __('Are You Sure?') }}" data-text="{{ __('This action can not be undone. Do you want to continue?') }}" data-confirm-yes="delete-form-{{ $productVariant['product_variants']['id'] }}">
                                                                <span class="material-symbols-outlined text-[14px]">delete</span>
                                                            </x-ui.button>
                                                            {!! Form::open([
                                                                'method' => 'DELETE',
                                                                'route' => ['products.variant.delete', [$productVariant['product_variants']['id'],$productVariant['product_variants']['product_id']]],
                                                                'id' => 'delete-form-' . $productVariant['product_variants']['id'],
                                                            ]) !!}
                                                            {!! Form::hidden('variant_options', $productVariant['product_variants']['name'], ['id' => 'invisible_id']) !!}
                                                            {!! Form::close() !!}
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Right Column (Sidebar) --}}
        <div class="pc-sidebar-col">
            {{-- Card 4: Product Images --}}
            <div class="pc-card">
                <div class="pc-card-header">
                    <div class="pc-card-header-icon">
                        <span class="material-symbols-outlined">photo_library</span>
                    </div>
                    <h3 class="pc-card-title">{{ __('Product Images') }}</h3>
                </div>
                <div class="pc-card-body">
                    <div class="pc-field">
                        <label class="pc-label">{{ __('Gallery Images') }}</label>
                        <div class="pc-upload-zone dropzone dropzone-multiple" data-toggle="dropzone1" data-dropzone-multiple>
                            <div class="fallback">
                                <input type="file" name="file" multiple>
                            </div>
                            <span class="material-symbols-outlined text-[32px] text-gray-400 mb-2">cloud_upload</span>
                            <div class="pc-upload-title">{{ __('Drag & drop gallery images') }}</div>
                            <div class="pc-upload-sub">{{ __('Supports JPEG, PNG, WEBP (Max 10 files)') }}</div>
                            <div class="pc-upload-btn">{{ __('Select Files') }}</div>

                            <ul class="dz-preview dz-preview-multiple list-group list-group-lg list-group-flush" style="display: none;">
                                <li class="list-group-item px-0">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar">
                                                <img class="rounded" src="" alt="" data-dz-thumbnail style="width: 40px; height: 40px; object-fit: cover;">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h6 class="text-xs font-semibold mb-0 truncate" data-dz-name style="max-width: 120px;">...</h6>
                                            <p class="text-[10px] text-gray-500 mb-0" data-dz-size></p>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" class="bg-transparent border-none text-red-500 cursor-pointer p-1" data-dz-remove>
                                                <span class="material-symbols-outlined text-[16px]">close</span>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    {{-- Uploaded Images List --}}
                    @if(count($product_image) > 0)
                        <div class="pc-field border-t border-gray-100 pt-4">
                            <label class="pc-label mb-3">{{ __('Current Gallery') }}</label>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach ($product_image as $file)
                                    <div class="product_Image relative aspect-square rounded-lg overflow-hidden border border-gray-150 group" data-id="{{ $file->id }}">
                                        <img src="{{ $productimage . $file->product_images }}" alt="" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center space-x-2">
                                            <a href="{{ $productimage . $file->product_images }}" download class="w-8 h-8 rounded-full bg-white text-gray-800 flex items-center justify-center hover:bg-gray-100 transition-colors">
                                                <span class="material-symbols-outlined text-[18px]">download</span>
                                            </a>
                                            <button type="button" class="w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center hover:bg-red-700 transition-colors deleteRecord" data-id="{{ $file->id }}">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="pc-field border-t border-gray-100 pt-4">
                        <label for="is_cover_image" class="pc-label">{{ __('Cover Image') }}</label>
                        <input type="file" name="is_cover_image" id="is_cover_image" class="pc-input" onchange="document.getElementById('coverImg').src = window.URL.createObjectURL(this.files[0])">
                        <img id="coverImg" src="" width="20%" class="mt-2" />
                    </div>

                    @if(!empty($product->is_cover))
                        <div class="pc-field">
                            <label class="pc-label">{{ __('Current Cover Image') }}</label>
                            <div class="relative w-full h-32 rounded-lg overflow-hidden border border-gray-150 group">
                                <img src="{{ $is_cover_image . $product->is_cover }}" alt="" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <a href="{{ $is_cover_image . $product->is_cover }}" download class="w-8 h-8 rounded-full bg-white text-gray-800 flex items-center justify-center hover:bg-gray-100 transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">download</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Card 5: About Product --}}
            <div class="pc-card">
                <div class="pc-card-header">
                    <div class="pc-card-header-icon">
                        <span class="material-symbols-outlined">description</span>
                    </div>
                    <h3 class="pc-card-title">{{ __('About Product') }}</h3>
                </div>
                <div class="pc-card-body">
                    <div class="pc-field">
                        {{ Form::label('description', __('Product Description'), ['class' => 'pc-label']) }}
                        {{ Form::textarea('description', !empty($product->description) ? $product->description : '', ['class' => 'form-control summernote-simple', 'rows' => 2, 'placeholder' => __('Product Description'), 'id' => 'description']) }}
                    </div>
                    <div class="pc-field">
                        {{ Form::label('specification', __('Product Specification'), ['class' => 'pc-label']) }}
                        {{ Form::textarea('specification', !empty($product->specification) ? $product->specification : '', ['class' => 'form-control summernote-simple', 'rows' => 2, 'placeholder' => __('Product Specification'), 'id' => 'specification']) }}
                    </div>
                    <div class="pc-field">
                        {{ Form::label('detail', __('Product Details'), ['class' => 'pc-label']) }}
                        {{ Form::textarea('detail', !empty($product->detail) ? $product->detail : '', ['class' => 'form-control summernote-simple', 'rows' => 2, 'placeholder' => __('Product Details'), 'id' => 'detail']) }}
                    </div>
                </div>
            </div>

            {{-- Save / Cancel Footer (sticky bottom of sidebar) --}}
            <div class="flex gap-3 justify-end mt-4">
                <a href="{{ route('product.index') }}" class="pc-btn pc-btn-secondary" style="flex: 1; justify-content: center;">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="pc-btn pc-btn-primary" style="flex: 1; justify-content: center;">
                    {{ __('Update Product') }}
                </button>
            </div>
        </div>
    </div>
    <input type="submit" value="{{__('Update')}}" class="product-submit-button d-none btn btn-primary">
    {{ Form::close() }}
</div>
@endsection
