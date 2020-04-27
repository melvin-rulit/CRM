@extends('layouts.admin')
@section('content')

<div id="app">

<region-component :canupdate="true"></region-component>


</div>
<script src="{{ asset('js/app.js') }}"></script>

@endsection
