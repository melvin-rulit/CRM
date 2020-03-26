@extends('layouts.admin')
@section('content')



<div class="card">

    <div class="card-body">{{ $users->name }}</div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.useraccess.update", [$users->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <input type="hidden" name="user_id" value="{{ $users->id }}">
            <div class="form-group">
                <label class="required" for="roles">Права на добавление ролей</label>
                <div class="pb-3">
                    <span class="btn btn-info btn-sm select-all">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-sm deselect-all">{{ trans('global.deselect_all') }}</span>
                </div>

                <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple required>
                    @foreach($roles as $id => $roles)
                        <option value="{{ $id }}" {{ ($users->useraccess->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                    @endforeach
                </select>

                @if($errors->has('roles'))
                    <div class="invalid-feedback">
                        {{ $errors->first('roles') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
                <a class="btn btn-danger" href="{{ route('admin.useraccess.index') }}">
                    {{ trans('global.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>



@endsection