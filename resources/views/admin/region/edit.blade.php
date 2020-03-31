@extends('layouts.admin')
@section('content')

    <div class="container">
        <h1>Редактировать регион</h1>
        <div class="card">
            <div class="card-body">
                <form action="{{ route("admin.region.update", [$region->id]) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.region.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $region->name) }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.region.fields.name_helper') }}</span>
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