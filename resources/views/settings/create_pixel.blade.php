{{ Form::open(['method'=>'POST','route'=>array('owner.pixel.setting',$store_settings->slug)]) }}
<div class="row">
    <div class="col-12">
        <input type="hidden" name="id" id="id" >
        <input type="hidden" name="store_id" id="{{ $store_settings->id }}">
        <div class="form-group">
            {{ Form::label('Platform', __('Platform'), ['class' => 'form-label']) }}
            {{ Form::select('platform', Utility::pixel_plateforms(),null, ['class' => 'form-control', 'placeholder'=>'Please Select','required'=>'required']) }}
        </div>
        <div class="form-group">
            {{  Form::label('Pixel Id',__('Pixel Id'),['class'=>'form-label'])  }}
            {{ Form::text('pixel_id','',array('class'=>'form-control','placeholder'=>__('Enter Pixel Id'),'required'=>'required')) }}
        </div>
    </div>
</div>
<div class="form-group py-0 mb-0 col-12 d-flex justify-content-end col-form-label">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-secondary" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Crate') }}" class="btn btn-primary ms-2">
</div>
{{ Form::close() }}
