@extends('layouts.admin')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <center class="m-t-30">
                        <img src="http://83.220.172.19/images/photo_LI.jpg" class="avatar-img rounded-circle" alt="..." width="150">
                        <hr>
                        <div class="text-center">
                            <h2 class="card-title">
                                {{ $user->name }} {{ $user->surname }}
                            </h2>
                            <p class="card-text text-muted">
                              <small>Роль пользователя</small>
                          </p>
                      </div>
                  </center>
              </div>
              <div class="card-body">
                <h4 class="text-muted">Email адресс </h4>
                <h4>{{ old('email', $user->email) }}</h4>
                <hr>
                <h4 class="text-muted p-t-30 db">Телефон</h4>
                <h4>{{ old('phone', $user->phone) }}</h4>
            </div>
        </div>
    </div>

        <div class="col-lg-8 col-xlg-9 col-md-7">
                <form method="POST" action="{{ route("admin.users.update", [$user->id]) }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="surname">{{ trans('cruds.user.fields.surname') }}</label>
                        <input class="form-control {{ $errors->has('surname') ? 'is-invalid' : '' }}" type="text" name="surname" id="surname" value="{{ old('surname', $user->surname) }}" required>
                        @if($errors->has('surname'))
                            <div class="invalid-feedback">
                                {{ $errors->first('surname') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="phone">{{ trans('cruds.user.fields.phone') }}</label>
                        <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" required>
                        @if($errors->has('phone'))
                            <div class="invalid-feedback">
                                {{ $errors->first('phone') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                    </div>
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
                    
                <label for="pasport" class="col-md-4 control-label">{{ trans('cruds.user.fields.about_as') }}</label>
                <textarea class="form-control mb-3" data-toggle="autosize" rows="1"></textarea>

                    <div class="form-group">
                        <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', $user->email) }}" required>
                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password">
                        @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                    </div>

                    <div class="form-group">
                        <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                        <div class="mb-4">
                            <span class="btn btn-info btn-sm select-all">{{ trans('global.select_all') }}</span>
                            <span class="btn btn-info btn-sm deselect-all">{{ trans('global.deselect_all') }}</span>
                        </div>
                        <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple required>
                            @foreach($roles as $id => $roles)
                                <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || $user->roles->contains($id)) ? 'selected' : '' }}>{{ $roles }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('roles'))
                            <div class="invalid-feedback">
                                {{ $errors->first('roles') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
                    </div>

                    <div class="form-group mb-4">
                        <label class="required" for="roles">{{ trans('cruds.user.fields.branch') }}</label>
                        <select class="form-control select2 {{ $errors->has('branches') ? 'is-invalid' : '' }}" name="branches[]" id="branches" multiple required>
                            @foreach($branches as $id => $branches)
                                <option value="{{ $id }}" {{ ($user->branches->contains($id)) ? 'selected' : '' }}>{{ $branches }}</option>
                            @endforeach
                        </select>
                    </div>

<!--                     <div class="form-group">
                        <label for="class_id">{{ trans('cruds.user.fields.class') }}</label>
                        <select class="form-control select2 {{ $errors->has('class') ? 'is-invalid' : '' }}" name="class_id" id="class_id">
                            @foreach($classes as $id => $class)
                                <option value="{{ $id }}" {{ ($user->class ? $user->class->id : old('class_id')) == $id ? 'selected' : '' }}>{{ $class }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('class'))
                            <div class="invalid-feedback">
                                {{ $errors->first('class') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.user.fields.class_helper') }}</span>
                    </div> -->

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



