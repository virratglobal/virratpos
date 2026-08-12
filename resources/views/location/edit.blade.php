{{Form::model($location, array('route' => array('location.update', $location->id), 'method' => 'PUT', 'class'=>'needs-validation', 'novalidate')) }}
<div class="row">
    <div class="col-12">
        <div class="form-group">
            {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}<x-required></x-required>
            {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Name'),'required'=>'required'))}}
            @error('country_name')
            <span class="invalid-country_name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
<div class="form-group py-0 mb-0 col-12 d-flex justify-content-end form-label">
    <input type="button" value="{{ __('Cancel') }}" class="btn btn-secondary" data-bs-dismiss="modal">
    <input type="submit" value="{{ __('Update') }}" class="btn btn-primary ms-2">
</div>
{{Form::close()}}
