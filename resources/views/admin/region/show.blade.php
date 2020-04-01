@extends('layouts.admin')
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-2">
                <div class="card-header">
                    <div class="row align-items-center">
                         <div class="col">
                            <h4 class="card-header-title">{{ $region->name }}</h4>
                        </div>
                        <div class="col-auto">
                             <a class="btn btn-sm btn-success" href="/branch/create">{{ trans('cruds.branch.add_branch') }}</a>
                             <a class="btn btn-sm btn-info" href="/region/{{ $region->id }}/edit">{{ trans('cruds.region.edit_region') }}</a>

                                @if(count($region->branches))
                                    <form action="{{ route('admin.region.destroy', $region->id) }}" method="POST" onsubmit=" confirm('{{ trans('global.notDelete') }}'); return false;" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-sm btn-danger" value="{{ trans('cruds.region.delete_region') }}">
                                    </form>
                                @else
                                    <form action="{{ route('admin.region.destroy', $region->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-sm btn-danger" value="{{ trans('cruds.region.delete_region') }}">
                                    </form>
                                @endif



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection