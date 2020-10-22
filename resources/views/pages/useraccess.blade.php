@extends('layouts.admin')
@section('content')

<div id="app">

<user-access-component></user-access-component>

</div>
<script src="{{ asset('js/app.js') }}"></script>

@endsection
