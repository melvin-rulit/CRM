@extends('layouts.admin')
@section('content')

@can('useraccess')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.useraccess.title') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-hover datatable datatable-Role">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.useraccess.fields.surname') }}
                        </th>
                        <th>
                            {{ trans('cruds.useraccess.title_sing') }}
                        </th>
                        <th>
                            {{ trans('cruds.useraccess.title_access') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>

                      @foreach($users as $key => $user)
                        <tr data-entry-id="">
                            <td>

                            </td>
                            <td>
                                {{ $user->surname }}
                            </td>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                @foreach($user->userAccess as $key => $item)
                                    <span class="badge badge-info">{{ $item->title }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('role_edit')
                                    <a class="btn btn-sm btn-primary d-none d-md-inline-block" href="{{ route('admin.useraccess.edit', $user->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                            </td>
                        </tr>
                      @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endcan


@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('role_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.roles.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  // dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Role:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection