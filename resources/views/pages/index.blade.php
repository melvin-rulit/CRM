@extends('layouts.admin')
@section('content')



<div class="row">
  <div class="col-lg-12">
    <div class="card mb-2">
      <div class="card-header">
        <div class="row align-items-center">
          <div class="col">
            <h4 class="card-header-title">Регионы и филиалы</h4>
          </div>
          <div class="col-auto">
            <a class="btn btn-sm btn-success" href="{{ route('admin.region.create') }}">{{ trans('cruds.region.add_region') }}</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row flex-nowrap test">

  @foreach($regions as $region)
  <div class="col-4 col-lg-4">
    <div class="card">

      <div class="card-header">
        <div class="row align-items-center">
          <div class="col">
            <a href="regional/{{ $region->id }}" class="card-header-title">
              {{ $region->name }}
            </a>
          </div>
        </div>
      </div>

@if(count($region->branches))
      <div class="card-body">
        @foreach($region->branches as $branch)

          <div class="card card-sm mb-2">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-12 col-md">
                  <p class="mb-md-0">
                    {{ $branch->name }}
                  </p>
                  <div class="pl-3 pt-1">
                    <p class="card-text small text-muted mb-1">
                      {{ $branch->adress }}
                    </p>
                    <p class="card-text small text-muted mb-1">
                      {{ $branch->phone }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
@else
  <p class="text-center pt-3">{{ trans('cruds.region.count') }}</p>
  <div class="col-auto mb-4">
    <div class="text-center">
      <a class="btn btn-sm btn-success center-block" href="{{ route('admin.branch.create') }}">{{ trans('cruds.branch.add_branch') }}</a>
    </div>
  </div>
@endif
    </div>
  </div>
@endforeach

</div>


<div class="row">
          <div class="col-12 col-lg-6 col-xl">
            
            <!-- Card -->
            <div class="card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">

                    <!-- Title -->
                    <h6 class="card-title text-uppercase text-muted mb-2">
                      Продажи
                    </h6>
                    
                    <!-- Heading -->
                    <span class="h2 mb-0">
                      $24,500
                    </span>

                    <!-- Badge -->
                    <span class="badge badge-soft-success mt-n1">
                      +3.5%
                    </span>

                  </div>
                  <div class="col-auto">
                    
                    <!-- Icon -->
                    <span class="h2 fe fe-dollar-sign text-muted mb-0"></span>

                  </div>
                </div> <!-- / .row -->

              </div>
            </div>

          </div>
          <div class="col-12 col-lg-6 col-xl">
            
            <!-- Card -->
            <div class="card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">

                    <!-- Title -->
                    <h6 class="card-title text-uppercase text-muted mb-2">
                      Количество часов
                    </h6>
                    
                    <!-- Heading -->
                    <span class="h2 mb-0">
                      763.5
                    </span>

                  </div>
                  <div class="col-auto">
                    
                    <!-- Icon -->
                    <span class="h2 fe fe-briefcase text-muted mb-0"></span>

                  </div>
                </div> <!-- / .row -->

              </div>
            </div>
              
          </div>
          <div class="col-12 col-lg-6 col-xl">
            
            <!-- Card -->
            <div class="card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">

                    <!-- Title -->
                    <h6 class="card-title text-uppercase text-muted mb-2">
                      Прогресс
                    </h6>

                    <div class="row align-items-center no-gutters">
                      <div class="col-auto">

                        <!-- Heading -->
                        <span class="h2 mr-2 mb-0">
                          84.5%
                        </span>
                        
                      </div>
                      <div class="col">
                        
                        <!-- Progress -->
                        <div class="progress progress-sm">
                          <div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                      </div>
                    </div> <!-- / .row -->

                  </div>
                  <div class="col-auto">
                    
                    <!-- Icon -->
                    <span class="h2 fe fe-clipboard text-muted mb-0"></span>

                  </div>
                </div> <!-- / .row -->

              </div>
            </div>
              
          </div>
          <div class="col-12 col-lg-6 col-xl">
            
            <!-- Card -->
            <div class="card">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col">

                    <!-- Title -->
                    <h6 class="card-title text-uppercase text-muted mb-2">
                      Еденица стоимости
                    </h6>
                    
                    <!-- Heading -->
                    <span class="h2 mb-0">
                      $5.50
                    </span>

                  </div>
                  <div class="col-auto">
                    
                    <!-- Chart -->
                    <div class="chart chart-sparkline"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                      <canvas class="chart-canvas chartjs-render-monitor" id="sparklineChart" style="display: block; width: 75px; height: 35px;" width="75" height="35"></canvas>
                    </div>

                  </div>
                </div> <!-- / .row -->

              </div>
            </div>
              
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-xl-8">
            
            <!-- Orders -->
            <div class="card">
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col">
                
                    <!-- Title -->
                    <h4 class="card-header-title">
                      Заказы по филиалам 
                    </h4>

                  </div>
                  <div class="col-auto mr-n3">
                    
                    <!-- Caption -->
                    <span class="text-muted">
                      Показать партнера:
                    </span>

                  </div>
                  <div class="col-auto">

                    <!-- Switch -->
                    <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" id="cardToggle" data-toggle="chart" data-target="#ordersChart" data-add="{&quot;data&quot;:{&quot;datasets&quot;:[{&quot;data&quot;:[15,10,20,12,7,0,8,16,18,16,10,22],&quot;backgroundColor&quot;:&quot;#d2ddec&quot;,&quot;label&quot;:&quot;Affiliate&quot;}]}}">
                      <label class="custom-control-label" for="cardToggle"></label>
                    </div>

                  </div>
                </div> <!-- / .row -->

              </div>
              <div class="card-body">
                
                <!-- Chart -->
                <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                  <canvas id="ordersChart" class="chart-canvas chartjs-render-monitor" style="display: block; width: 906px; height: 300px;" width="906" height="300"></canvas>
                </div>

              </div>
            </div>

          </div>
          <div class="col-12 col-xl-4">

            <!-- Devices -->
            <div class="card">
              <div class="card-header">
                <div class="row align-items-center">
                  <div class="col">
                
                    <!-- Title -->
                    <h4 class="card-header-title">
                      Devices
                    </h4>

                  </div>
                  <div class="col-auto">

                    <!-- Tabs -->
                    <ul class="nav nav-tabs nav-tabs-sm card-header-tabs">
                      <li class="nav-item" data-toggle="chart" data-target="#devicesChart" data-update="{&quot;data&quot;:{&quot;datasets&quot;:[{&quot;data&quot;:[60,25,15]}]}}">
                        <a href="#" class="nav-link active" data-toggle="tab">
                          All
                        </a>
                      </li>
                      <li class="nav-item" data-toggle="chart" data-target="#devicesChart" data-update="{&quot;data&quot;:{&quot;datasets&quot;:[{&quot;data&quot;:[15,45,20]}]}}">
                        <a href="#" class="nav-link" data-toggle="tab">
                          Direct
                        </a>
                      </li>
                    </ul>

                  </div>
                </div> <!-- / .row -->

              </div>
              <div class="card-body">
                
                <!-- Chart -->
                <div class="chart chart-appended"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                  <canvas id="devicesChart" class="chart-canvas chartjs-render-monitor" data-toggle="legend" data-target="#devicesChartLegend" style="display: block; width: 416px; height: 241px;" width="416" height="241"></canvas>
                </div>

                <!-- Legend -->
                <div id="devicesChartLegend" class="chart-legend"><span class="chart-legend-item"><i class="chart-legend-indicator" style="background-color: #2C7BE5"></i>Desktop</span><span class="chart-legend-item"><i class="chart-legend-indicator" style="background-color: #A6C5F7"></i>Tablet</span><span class="chart-legend-item"><i class="chart-legend-indicator" style="background-color: #D2DDEC"></i>Mobile</span></div>

              </div>
            </div>
            
          </div>
        </div>
@endsection
