@extends('layouts.admin')
@section('content')

    <div class="container">
        <h1>Новый регион</h1>
        <div class="card">
            <div class="card-body">
                <form action="{{ route("admin.region.store") }}" method="POST" enctype="multipart/form-data">
                    @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.region.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.region.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.create') }}
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