<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />

    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/select/1.3.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />

    <!-- Стили из нового шаблона -->
    <link rel="stylesheet" href="https://dashkit.goodthemes.co/assets/css/theme.min.css" id="stylesheetLight">
    <link rel="stylesheet" href="https://dashkit.goodthemes.co/assets/css/theme-dark.min.css" id="stylesheetDark">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Стили из нового шаблона -->

<!--     <script src="{{ asset('js/maskedinput/src/jquery.maskedinput.js') }}"></script>
    <script src="{{ asset('js/maskedinput/lib/jquery-1.9.0.min.js') }}"></script> -->

    @yield('styles')
    <style>body { display: none; }</style>

    <style type="text/css">
  .test {
    overflow-x: auto;
    margin-bottom: 24px;
}
.breadcrumb{
  padding-left: 21px;
}
</style>
</head>

@include('partials.promoter_menu')

<div class="main-content d-none d-md-block d-sm-block">
  <div class="container-fluid">
          <div class="row mb-2">
              <div class="col-lg-12">
                  <p class="alert alert-info text-center"> Данный интерфейс доступен только на мобильном экране. </p>
              </div>
          </div>
  </div>
</div>


<div class="main-content d-block d-sm-none">

  @include('layouts.message')

</div>




<body class="app header-fixed sidebar-fixed aside-menu-fixed pace-done sidebar-lg-show">



    <script src="https://dashkit.goodthemes.co/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://dashkit.goodthemes.co/assets/js/theme.min.js"></script>

    @yield('scripts')
</body>

</html>
