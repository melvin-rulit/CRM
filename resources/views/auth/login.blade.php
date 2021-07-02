@extends('layouts.app_auth')
@section('content')


    <div class="container">

        <div class="row">
            <div class="col-12 col-md-5 col-xl-4 personal">
                <h2 class="display-5 text-center mb-3">{{ trans('panel.site_title') }}</h2>
                <h6 class="text-info text-center mb-1">{{ trans('panel.site_description') }}</h6>
                @if ($errors->has('email'))
                    <span class="help-block" style="color:red; font-size: 14px;">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                @endif

                <form class="form-horizontal" method="POST" action="{{ route('login') }}">

                @csrf

                <!--  -->
                    <div class="form-group">
                        <label for="email" class="colors.coolGray #111827" style="color:white;">{{ trans('global.login') }}</label>
                        <input id="email" name="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">


                    </div>

                    <!--  -->
                    <div class="form-group">
                        <div class="row">
                            <div class="col">
                                <label for="password" style="color:white;">{{ trans('global.login_password') }}</label>
                            </div>
                            <div class="col-auto">
                                @if(Route::has('password.request'))
                                    <a class="px-0" style="color:white;" href="{{ route('password.request') }}">
                                    </a><br>
                                @endif
                            </div>
                        </div>

                        <div class="input-group input-group-merge">
                            <input id="password" name="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_password') }}">
                            @if($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
                    </div>


                    <button type="submit" class="btn btn-lg btn-block btn-primary mt-4">
                        Войти
                    </button>
                </form>
            </div>
        </div>
    </div>


    {{--    <main class="container">--}}
{{--        <div class="row">--}}

{{--            @if(session('message'))--}}
{{--                <div class="alert alert-info" role="alert">--}}
{{--                    {{ session('message') }}--}}
{{--                </div>--}}
{{--            @endif--}}

{{--                <img class="main-logo" src="/images/images_for_promouter/Logo.png">--}}

{{--            <form method="POST" action="{{ route('login') }}">--}}
{{--                @csrf--}}


{{--                <div class="inputs">--}}

{{------------------------------------ Login -----------------------------------}}

{{--                    <div class="form-group">--}}

{{--                        <input id="email" name="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">--}}

{{--                        @if ($errors->has('email'))--}}
{{--                            <span class="help-block" style="color:red; font-size: 14px;">--}}
{{--                                    <strong>{{ $errors->first('email') }}</strong>--}}
{{--                                </span>--}}
{{--                        @endif--}}

{{--                    </div>--}}

{{------------------------------------- Password --------------------------------}}


{{--                        <div class="form-group">--}}
{{--                            <input id="password" name="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_password') }}">--}}
{{--                            @if($errors->has('password'))--}}
{{--                                <div class="invalid-feedback">--}}
{{--                                    {{ $errors->first('password') }}--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        </div>--}}

{{-------------------------------- Send Password -----------------------}}

{{--                    <button type="submit" class="login-button button btn">Войти</button>--}}

{{--                </div>--}}

{{--            </form>--}}
{{--        </div>--}}
{{--    </main>--}}
@endsection



