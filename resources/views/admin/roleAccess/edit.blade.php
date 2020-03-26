@extends('layouts.admin')
@section('content')

{{dd($role->roleAccess)}}

<div class="card">

    <div class="card-body">{{ $role->title }}</div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.roleaccess.update", [$role->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <input type="hidden" name="role_id" value="{{ $role->id }}">
            <div class="form-group">
                <label class="required" for="permissions">Права на добавление ролей</label>
                <div class="pb-3">
                    <span class="btn btn-info btn-sm select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-sm deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>

                <select class="form-control select2 {{ $errors->has('permissions') ? 'is-invalid' : '' }}" name="permissions[]" id="permissions" multiple required>
                    @foreach($permissions as $id => $permissions)
                        <option value="{{ $id }}-{{ $permissions }}" {{ ($role->roleAccess->contains('role_access', $id)) ? 'selected' : '' }}>{{ $permissions }}</option>
                    @endforeach
                </select>

                @if($errors->has('permissions'))
                    <div class="invalid-feedback">
                        {{ $errors->first('permissions') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.role.fields.permissions_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection