@extends('layouts.admin')
@section('content')

<div class="container">
        <h1>{{ trans('cruds.branch.edit_branch') }}</h1>
        <div }}class="card">
            <div class="card-body">
                <form action="{{ route("admin.branch.update", [$branch->id]) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.branch.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $branch->name) }}" required>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.branch.fields.name_helper') }}</span>
                    </div>

                    <div class="form-group">
                        <label class="required" for="geolocation">{{ trans('cruds.branch.fields.geolocation') }}</label>
                        <input class="form-control {{ $errors->has('geolocation') ? 'is-invalid' : '' }}" type="text" name="geolocation" id="geolocation" value="{{ old('name', $branch->geolocation) }}" required>
                        @if($errors->has('city'))
                            <div class="invalid-feedback">
                                {{ $errors->first('geolocation') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.branch.fields.geolocation_helper') }}</span>
                    </div>

                    <div class="form-group">
                        <label class="required" for="adress">{{ trans('cruds.branch.fields.adress') }}</label>
                        <input class="form-control {{ $errors->has('adress') ? 'is-invalid' : '' }}" type="text" name="adress" id="adress" value="{{ old('name', $branch->adress) }}" required>
                        @if($errors->has('adress'))
                            <div class="invalid-feedback">
                                {{ $errors->first('adress') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.branch.fields.adress_helper') }}</span>
                    </div>

                     <div class="form-group">
                        <label class="required" for="phone">{{ trans('cruds.branch.fields.phone') }}</label>
                        <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('name', $branch->phone) }}" required>
                        @if($errors->has('phone'))
                            <div class="invalid-feedback">
                                {{ $errors->first('phone') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.branch.fields.phone_helper') }}</span>
                    </div>

                  <div class="form-group">
                      <label style="color: red" class="required" for="region_id">{{ trans('cruds.branch.fields.region_required') }}</label>
                      <select class="form-control" name="region_id" id="region_id" required>
                              <option selected="{{ old('branch', $branch->region_id) }}">{{\App\Region::getIsRegionAttribute($branch->region_id)->name}}</option>
                          @foreach($regions as $id => $region)
                              <option value="{{ $region->id }}">{{ $region->name }}</option>
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
                        {{ trans('global.save') }}
                    </button>
                <a class="btn btn-danger" href="/">
                    {{ trans('global.cancel') }}
                </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection