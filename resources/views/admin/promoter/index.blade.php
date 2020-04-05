@extends('layouts.promoter')
@section('content')

<div class="card visible-sm">
<!--   <div class="card-header">
    <h4 class="card-header-title">
      Card title
    </h4>
  </div> -->


          <div class="card-body">
            <form method="POST" action="{{ route("admin.promoter.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="child_name">{{ trans('cruds.promoter.fields.child_name') }}</label>
                    <input class="form-control {{ $errors->has('child_name') ? 'is-invalid' : '' }}" type="text" name="child_name" id="child_name" value="{{ old('child_name', '') }}" required>
                    @if($errors->has('child_name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('child_name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.promoter.fields.child_name_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="mother_phone">{{ trans('cruds.promoter.fields.mother_phone') }}</label>
                    <input class="form-control {{ $errors->has('mother_phone') ? 'is-invalid' : '' }}" type="text" name="mother_phone" id="mother_phone" value="{{ old('mother_phone', '') }}" required data-mask="+0 (000) 000-00-00" placeholder="+_ (___) ___ __ __">
                    @if($errors->has('mother_phone'))
                        <div class="invalid-feedback">
                            {{ $errors->first('mother_phone') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.promoter.fields.mother_phone_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="surname">{{ trans('cruds.promoter.fields.date') }}</label>
                    <input class="form-control {{ $errors->has('date') ? 'is-invalid' : '' }}" type="date" name="date" id="date" value="{{ old('date', '') }}" required min="2019-01-01" max="2030-01-01">
                    @if($errors->has('date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('date') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.promoter.fields.date_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="required" for="surname">{{ trans('cruds.promoter.fields.time') }}</label>
                    <input class="form-control {{ $errors->has('time') ? 'is-invalid' : '' }}" type="time" min="00:01" max="23:59" name="time" id="time" value="{{ old('time', '') }}" required>
                    @if($errors->has('time'))
                        <div class="invalid-feedback">
                            {{ $errors->first('time') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.promoter.fields.date_helper') }}</span>
                </div>

                   <div class="form-group">
                      <label class="required" for="branch_id">{{ trans('cruds.promoter.fields.branch') }}</label>
                      <select class="form-control" name="branch_id" id="branch_id" required>
                          @foreach($branches as $id => $branch)
                              <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                          @endforeach
                      </select>
                      @if($errors->has('branch'))
                          <div class="invalid-feedback">
                              {{ $errors->first('branch') }}
                          </div>
                      @endif
                      <span class="help-block">{{ trans('cruds.promoter.fields.branch_helper') }}</span>
                  </div>


            <div class="form-group">
                <label for="notes">{{ trans('cruds.promoter.fields.notes') }}</label>
                <textarea class="form-control mb-3" type="text" name="notes" id="notes" rows="1"></textarea>
            </div>

            <input type="hidden" name="source" value="1">

                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
</div>

@endsection