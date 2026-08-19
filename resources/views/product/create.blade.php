@extends('layouts.ui-admin')
@section('page-title')
    {{ __('Add Product') }}
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Home') }}</a></li>
<li class="breadcrumb-item"><a href="{{ route('product.index') }}">{{ __('Product') }}</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ __('Create') }}</li>
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
            url: "{{ route('product.store') }}",
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
        url: "{{ route('product.store') }}",
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
    $.get('{{ route("product.variants.create") }}', {}, function(data) {
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

function previewCover(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) { $('#upcoverImg').attr('src', e.target.result).show(); };
        reader.readAsDataURL(input.files[0]);
    }
}
function previewAttach(input, imgId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) { $('#' + imgId).attr('src', e.target.result).show(); };
        reader.readAsDataURL(input.files[0]);
    }
}

$(function() {
    $('.summernote-simple').summernote({
        height: 160,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'strikethrough']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['codeview']]
        ]
    });
});
</script>
@endpush

@section('content')
@php $plan = \App\Models\Plan::find(\Auth::user()->plan); @endphp

{{ Form::open(['method' => 'POST', 'id' => 'frmTarget', 'enctype' => 'multipart/form-data', 'class' => 'submit-product needs-validation', 'novalidate']) }}

<div class="pc-page-header">
    <div>
        <h1 class="pc-page-title">{{ __('Add New Product') }}</h1>
        <p class="pc-page-sub">{{ __('Fill in product details below and save when ready.') }}</p>
    </div>
    <div class="pc-actions">
        @if($plan->enable_chatgpt == 'on')
        <a href="#" class="pc-btn pc-btn-ai" data-size="lg" data-ajax-popup-over="true"
           data-url="{{ route('generate', ['products']) }}"
           data-title="{{ __('Generate Content With AI') }}">
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
            {{ __('Save Product') }}
        </button>
    </div>
</div>

<div class="pc-grid">

    <div>
        <div class="pc-card">
            <div class="pc-card-header">
                <div class="pc-card-header-icon"><span class="material-symbols-outlined">inventory_2</span></div>
                <h3 class="pc-card-title">{{ __('Main Information') }}</h3>
            </div>
            <div class="pc-card-body">
                <div class="pc-field">
                    <label class="pc-label">{{ __('Product Name') }}<span class="req">*</span></label>
                    <input type="text" name="name" class="pc-input" placeholder="{{ __('e.g. Wireless Headphones Pro') }}" required>
                </div>
                <div class="pc-field">
                    <label class="pc-label">{{ __('Product Categories') }}</label>
                    {!! Form::select('product_categorie[]', $product_categorie, null, ['class' => 'pc-input multi-select', 'id' => 'choices-multiple', 'multiple', 'style' => 'height:auto;']) !!}
                    @if(count($product_categorie) == 0)
                    <p style="font-size:12px;color:#767586;margin-top:6px;">
                        {{ __('No categories yet.') }} <a href="{{ route('product_categorie.index') }}" class="pc-link">{{ __('Add one') }}</a>
                    </p>
                    @endif
                </div>
                <div class="pc-field">
                    <label class="pc-label">{{ __('SKU') }}</label>
                    <input type="text" name="SKU" class="pc-input" placeholder="{{ __('e.g. WHP-2024-BLK') }}">
                </div>
                <div class="pc-field">
                    <label class="pc-label">{{ __('Product Tax') }}</label>
                    {!! Form::select('product_tax[]', $product_tax, null, ['class' => 'pc-input multi-select', 'id' => 'choices-multiple1', 'multiple', 'style' => 'height:auto;']) !!}
                    @if(count($product_tax) == 0)
                    <p style="font-size:12px;color:#767586;margin-top:6px;">
                        {{ __('No taxes yet.') }} <a href="{{ route('product_tax.index') }}" class="pc-link">{{ __('Add one') }}</a>
                    </p>
                    @endif
                </div>
                <div class="pc-field proprice">
                    <div class="pc-row-2">
                        <div>
                            <label class="pc-label">{{ __('Price') }}</label>
                            <input type="number" step="any" name="price" class="pc-input" placeholder="0.00">
                        </div>
                        <div>
                            <label class="pc-label">{{ __('Compare-at Price') }}</label>
                            <input type="number" step="any" name="last_price" class="pc-input" placeholder="0.00">
                        </div>
                    </div>
                </div>
                <div class="pc-field proprice">
                    <label class="pc-label">{{ __('Stock Quantity') }}</label>
                    <input type="text" name="quantity" class="pc-input" placeholder="{{ __('e.g. 100') }}">
                </div>
                <div class="pc-field">
                    <label class="pc-label">{{ __('Attachment') }}</label>
                    <input type="file" name="attachment" id="attachment" class="pc-input" onchange="previewAttach(this, 'blah')">
                    <img id="blah" src="" class="pc-cover-preview">
                </div>
                <div class="pc-field">
                    <label class="pc-label">{{ __('Downloadable Product File') }}</label>
                    <input type="file" name="downloadable_prodcut" id="downloadable_prodcut" class="pc-input" onchange="previewAttach(this, 'down_product')">
                    <img id="down_product" src="" class="pc-cover-preview">
                </div>
            </div>
        </div>

        <div class="pc-card">
            <div class="pc-card-header">
                <div class="pc-card-header-icon"><span class="material-symbols-outlined">tune</span></div>
                <h3 class="pc-card-title">{{ __('Custom Fields') }}</h3>
            </div>
            <div class="pc-card-body">
                @foreach([1,2,3,4] as $i)
                <div class="pc-row-2" style="margin-bottom:14px;">
                    <div>
                        @if($i === 1)<label class="pc-label">{{ __('Field Name') }}</label>@endif
                        <input type="text" name="custom_field_{{ $i }}" class="pc-input" placeholder="{{ __('Field name') }}">
                    </div>
                    <div>
                        @if($i === 1)<label class="pc-label">{{ __('Field Value') }}</label>@endif
                        <input type="text" name="custom_value_{{ $i }}" class="pc-input" placeholder="{{ __('Field value') }}">
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="pc-card">
            <div class="pc-card-header">
                <div class="pc-card-header-icon"><span class="material-symbols-outlined">toggle_on</span></div>
                <h3 class="pc-card-title">{{ __('Visibility & Variants') }}</h3>
            </div>
            <div class="pc-card-body">
                <div class="pc-toggle-row">
                    <div>
                        <div class="pc-toggle-label">{{ __('Product Display') }}</div>
                        <div class="pc-toggle-sub">{{ __('Show this product in your storefront') }}</div>
                    </div>
                    <label class="pc-switch">
                        <input type="checkbox" name="product_display" id="product_display" checked>
                        <span class="pc-slider"></span>
                    </label>
                </div>
                <div class="pc-toggle-row">
                    <div>
                        <div class="pc-toggle-label">{{ __('Display Variants') }}</div>
                        <div class="pc-toggle-sub">{{ __('Allow customers to pick variant options') }}</div>
                    </div>
                    <label class="pc-switch">
                        <input type="checkbox" name="enable_product_variant" id="enable_product_variant">
                        <span class="pc-slider"></span>
                    </label>
                </div>
                <div id="productVariant" style="margin-top:20px;">
                    <div class="pc-variant-header">
                        <span style="font-family:'Geist',sans-serif;font-size:13px;font-weight:600;color:#0b1c30;">{{ __('Product Variants') }}</span>
                        @can('Create Variants')
                        <button type="button" class="pc-variant-add get-variants">
                            <span class="material-symbols-outlined">add</span>
                            {{ __('Add Variant') }}
                        </button>
                        @endcan
                    </div>
                    <input type="hidden" id="hiddenVariantOptions" name="hiddenVariantOptions" value="{}">
                    <div class="variant-table"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="pc-sidebar-col">
        <div class="pc-card">
            <div class="pc-card-header">
                <div class="pc-card-header-icon"><span class="material-symbols-outlined">photo_library</span></div>
                <h3 class="pc-card-title">{{ __('Product Images') }}</h3>
            </div>
            <div class="pc-card-body">
                <label class="pc-label" style="margin-bottom:10px;">{{ __('Gallery Images') }}</label>
                <div class="dropzone dropzone-multiple" data-toggle="dropzone1" data-dropzone-url="http://" data-dropzone-multiple>
                    <div class="fallback">
                        <div class="pc-upload-zone" onclick="document.getElementById('dropzone-1').click()">
                            <span class="material-symbols-outlined" style="font-size:36px;color:#c7c4d7;">cloud_upload</span>
                            <div class="pc-upload-title">{{ __('Drop images here') }}</div>
                            <div class="pc-upload-sub">{{ __('PNG, JPG, WEBP — up to 10 files') }}</div>
                            <span class="pc-upload-btn">{{ __('Browse files') }}</span>
                        </div>
                        <input type="file" name="file" id="dropzone-1" class="pc-file-input-hidden"
                               onchange="document.getElementById('dropzone').src = window.URL.createObjectURL(this.files[0])" multiple>
                        <img id="dropzone" src="" width="20%" class="mt-2">
                        <label class="pc-file-input-hidden" for="customFileUpload">{{ __('Choose file') }}</label>
                    </div>
                    <ul class="dz-preview dz-preview-multiple list-group list-group-lg list-group-flush" style="margin-top:10px;">
                        <li class="list-group-item px-0">
                            <div class="row align-items-center">
                                <div class="col-auto"><div class="avatar"><img class="rounded" src="" alt="Image placeholder" data-dz-thumbnail></div></div>
                                <div class="col"><h6 class="text-sm mb-1" data-dz-name>...</h6><p class="small text-muted mb-0" data-dz-size></p></div>
                                <div class="col-auto"><a href="#" class="dropdown-item" data-dz-remove><span class="material-symbols-outlined" style="font-size:16px;color:#ba1a1a;">delete</span></a></div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="pc-field" style="margin-top:20px;">
                    <label class="pc-label">{{ __('Cover Image') }}</label>
                    <div class="pc-upload-zone" onclick="document.getElementById('is_cover_image').click()" style="padding:18px 16px;">
                        <span class="material-symbols-outlined" style="font-size:28px;color:#c7c4d7;">image</span>
                        <div class="pc-upload-title" style="font-size:12px;">{{ __('Click to upload cover') }}</div>
                    </div>
                    <input type="file" name="is_cover_image" id="is_cover_image" class="pc-file-input-hidden" onchange="previewCover(this)">
                    <img id="upcoverImg" src="" class="pc-cover-preview" style="max-height:120px;">
                </div>
            </div>
        </div>

        <div class="pc-card">
            <div class="pc-card-header">
                <div class="pc-card-header-icon"><span class="material-symbols-outlined">description</span></div>
                <h3 class="pc-card-title">{{ __('About Product') }}</h3>
            </div>
            <div class="pc-card-body">
                <div class="pc-field">
                    <label class="pc-label">{{ __('Product Description') }}</label>
                    {{ Form::textarea('description', null, ['class' => 'form-control summernote-simple', 'rows' => 1, 'placeholder' => __('Describe your product…'), 'id' => 'description']) }}
                </div>
                <div class="pc-field">
                    <label class="pc-label">{{ __('Product Specification') }}</label>
                    {{ Form::textarea('specification', null, ['class' => 'form-control summernote-simple', 'rows' => 1, 'placeholder' => __('Technical specs…'), 'id' => 'specification']) }}
                </div>
                <div class="pc-field">
                    <label class="pc-label">{{ __('Product Details') }}</label>
                    {{ Form::textarea('detail', null, ['class' => 'form-control summernote-simple', 'rows' => 1, 'placeholder' => __('Additional details…'), 'id' => 'detail']) }}
                </div>
            </div>
        </div>

        <div style="display:flex;gap:10px;">
            <a href="{{ route('product.index') }}" class="pc-btn pc-btn-secondary" style="flex:1;justify-content:center;">{{ __('Cancel') }}</a>
            <button type="button" class="pc-btn pc-btn-primary" style="flex:1;justify-content:center;" onclick="$('#submit-all').trigger('click')">
                <span class="material-symbols-outlined">check_circle</span>
                {{ __('Save') }}
            </button>
        </div>
    </div>

</div>

<input type="submit" value="{{ __('Create') }}" class="product-submit-button d-none btn btn-primary ms-2">
{{ Form::close() }}
@endsection
