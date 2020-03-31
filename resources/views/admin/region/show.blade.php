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
                             <!-- <a class="btn btn-sm btn-danger" href="/branch/create">{{ trans('cruds.region.delete_region') }}</a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    
@endsection