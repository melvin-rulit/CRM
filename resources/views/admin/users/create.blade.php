@extends('layouts.admin')
@section('content')


<div class="container">
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route("admin.users.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="surname">{{ trans('cruds.user.fields.surname') }}</label>
                    <input class="form-control {{ $errors->has('surname') ? 'is-invalid' : '' }}" type="text" name="surname" id="surname" value="{{ old('surname', '') }}" required>
                    @if($errors->has('surname'))
                        <div class="invalid-feedback">
                            {{ $errors->first('surname') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="phone">{{ trans('cruds.user.fields.phone') }}</label>
                    <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', '') }}" required>
                    @if($errors->has('phone'))
                        <div class="invalid-feedback">
                            {{ $errors->first('phone') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email') }}" required>
                    @if($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                    <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" required>
                    @if($errors->has('password'))
                        <div class="invalid-feedback">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                </div>
                @if(!request()->has('student'))
                    <div class="form-group">
                        <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                        <div class="pb-3">
                            <span class="btn btn-info btn-sm select-all">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-sm deselect-all">{{ trans('global.deselect_all') }}</span>
                        </div>
                        <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple required>

                            @foreach($useraccesses as $id => $val)
                                <option value="{{ $val->id }}" {{ in_array($val, old('roles', [])) ? 'selected' : '' }}>{{ $val->title }}</option>
                            @endforeach

                        </select>
                        @if($errors->has('roles'))
                            <div class="invalid-feedback">
                                {{ $errors->first('roles') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
                    </div>
                @else
                    <input type="hidden" name="roles[]" value="4">
                @endif

                <div class="form-group{{ $errors->has('avatar') ? ' has-error' : '' }}">
                    <label for="avatar" class="col-md-4 control-label">{{ trans('cruds.user.fields.avatar') }}</label>
                    <div class="col-md-6">
                        <input id="avatar" type="file" name="avatar" class="btn btn-outline-secondary mb-2">
                    </div>
                </div>
                @if ($errors->has('avatar'))
                    <span class="help-block">
                        <strong>{{ $errors->first('avatar') }}</strong>
                    </span>
                @endif

                <div class="form-group{{ $errors->has('pasport') ? ' has-error' : '' }}">
                    <label for="pasport" class="col-md-4 control-label">{{ trans('cruds.user.fields.pasport') }}</label>
                    <div class="col-md-6">
                        <input id="pasport" type="file" name="pasport" class="btn btn-outline-secondary mb-2">
                    </div>
                </div>
                @if ($errors->has('pasport'))
                    <span class="help-block">
                        <strong>{{ $errors->first('pasport') }}</strong>
                    </span>
                @endif

                <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
                    <label for="birthday" class="col-md-4 control-label">{{ trans('cruds.user.fields.birthday') }}</label>
                        <input id="birthday" type="date" name="birthday" class="form-control" min="1950-01-01" max="2030-01-01">
                </div>
                @if ($errors->has('birthday'))
                    <span class="help-block">
                        <strong>{{ $errors->first('birthday') }}</strong>
                    </span>
                @endif

                <div class="form-group{{ $errors->has('facebook') ? ' has-error' : '' }}">
                    <label for="facebook" class="col-md-4 control-label">{{ trans('cruds.user.fields.facebook') }}</label>
                        <input id="facebook" type="text" name="facebook" class="form-control">
                </div>
                @if ($errors->has('facebook'))
                    <span class="help-block">
                        <strong>{{ $errors->first('facebook') }}</strong>
                    </span>
                @endif

                <div class="form-group{{ $errors->has('instagram') ? ' has-error' : '' }}">
                    <label for="instagram" class="col-md-4 control-label">{{ trans('cruds.user.fields.instagram') }}</label>
                        <input id="instagram" type="text" name="instagram" class="form-control">
                </div>
                @if ($errors->has('instagram'))
                    <span class="help-block">
                        <strong>{{ $errors->first('instagram') }}</strong>
                    </span>
                @endif

            <div class="form-group">
                <label for="about_as" class="required">{{ trans('cruds.user.fields.about_as') }}</label>
                <textarea class="form-control mb-3" type="text" name="about_as" id="about_as" rows="1" required></textarea>
            </div>

                <div class="form-group">
                        <label class="required" for="branches">{{ trans('cruds.user.fields.branch') }}</label>
                        <select class="form-control select2 {{ $errors->has('branches') ? 'is-invalid' : '' }}" name="branches[]" id="branches" multiple required>

                            @foreach($branches as $id => $val)
                                <option value="{{ $id }}" {{ in_array($val, old('branches', [])) ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach

                        </select>
                        @if($errors->has('branches'))
                            <div class="invalid-feedback">
                                {{ $errors->first('branch') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.branch_helper') }}</span>
                </div>

                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection