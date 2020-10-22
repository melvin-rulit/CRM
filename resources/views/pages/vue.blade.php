@extends('layouts.admin')
@section('content')

<div id="app">

{{--<base-component :adduser="{{Gate::check('user_create')}}"></base-component>--}}
<base-component></base-component>

{{--<mask-component></mask-component>--}}


</div>
<script src="{{ asset('js/app.js') }}"></script>

@endsection
