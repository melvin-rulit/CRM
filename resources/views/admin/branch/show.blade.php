@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-sm btn-outline-primary mb-2" href="{{ route('admin.region.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.branch.fields.id') }}
                        </th>
                        <td>
                            {{ $branch->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.branch.fields.name') }}
                        </th>
                        <td>
                            {{ $branch->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.branch.fields.adress') }}
                        </th>
                        <td>
                            {{ $branch->adress }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.branch.fields.phone') }}
                        </th>
                        <td>
                            {{ $branch->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.branch.fields.geolocation') }}
                        </th>
                        <td>
                            {{ $branch->geolocation }}
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>


@endsection