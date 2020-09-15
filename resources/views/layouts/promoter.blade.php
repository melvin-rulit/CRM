<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>
    <link rel="stylesheet" href="https://dashkit.goodthemes.co/assets/css/theme.min.css" id="stylesheetLight">
    <link rel="stylesheet" href="https://dashkit.goodthemes.co/assets/css/theme-dark.min.css" id="stylesheetDark">
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
