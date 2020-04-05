<div class="container-fluid">
    @if(Session::has('success'))
        <div class="row mb-2">
            <div class="col-lg-12">
                <p class="alert alert-success">{!! Session::get('success') !!}</p>
            </div>
        </div>
    @endif
    @if($errors->count() > 0)
        <div class="alert alert-danger">
            <ul class="list-unstyled">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@yield('content')
</div>