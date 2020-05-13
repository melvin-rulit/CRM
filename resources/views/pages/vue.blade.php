@extends('layouts.admin')
@section('content')

<div id="app">

<user-component :adduser="{{Gate::check('user_create')}}"></user-component>
<!-- <example-component></example-component> -->


</div>
<script src="{{ asset('js/app.js') }}"></script>

@endsection
