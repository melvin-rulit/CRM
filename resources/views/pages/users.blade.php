@extends('layouts.admin')
@section('content')

<div id="app">

<!-- <example-component></example-component> -->
<users-component></users-component>

{{--@foreach($users as $user)--}}
{{--	<h3>{{ $user->surname }}</h3>--}}
{{--@endforeach--}}

</div>
<script src="{{ asset('js/app.js') }}"></script>

@endsection
