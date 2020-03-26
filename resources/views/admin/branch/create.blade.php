@extends('layouts.admin')
@section('content')

<div class="container">
        <h1>Новый филиал</h1>
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.branch.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.branch.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.branch.fields.name_helper') }}</span>
                    </div>

                    <div class="form-group">
                        <label class="required" for="geolocation">{{ trans('cruds.branch.fields.geolocation') }}</label>
                        <input class="form-control {{ $errors->has('geolocation') ? 'is-invalid' : '' }}" type="text" name="geolocation" id="geolocation" value="{{ old('geolocation', '') }}" required>
                        @if($errors->has('city'))
                            <div class="invalid-feedback">
                                {{ $errors->first('geolocation') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.branch.fields.geolocation_helper') }}</span>
                    </div>

                    <div class="form-group">
                        <label class="required" for="adress">{{ trans('cruds.branch.fields.adress') }}</label>
                        <input class="form-control {{ $errors->has('adress') ? 'is-invalid' : '' }}" type="text" name="adress" id="adress" value="{{ old('adress', '') }}" required>
                        @if($errors->has('adress'))
                            <div class="invalid-feedback">
                                {{ $errors->first('adress') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.branch.fields.adress_helper') }}</span>
                    </div>

                     <div class="form-group">
                        <label class="required" for="phone">{{ trans('cruds.branch.fields.phone') }}</label>
                        <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}" required>
                        @if($errors->has('phone'))
                            <div class="invalid-feedback">
                                {{ $errors->first('phone') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.branch.fields.phone_helper') }}</span>
                    </div>

                  <div class="form-group">
                      <label class="required" for="region_id">{{ trans('cruds.branch.fields.region') }}</label>
                      <select class="form-control" name="region_id" id="region_id" required>
                          @foreach($regions as $id => $region)
                              <option value="{{ $id }}">{{ $region->name }}</option>
                          @endforeach
                      </select>
                      @if($errors->has('region'))
                          <div class="invalid-feedback">
                              {{ $errors->first('region') }}
                          </div>
                      @endif
                      <span class="help-block">{{ trans('cruds.branch.fields.region_helper') }}</span>
                  </div>

                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.create') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection