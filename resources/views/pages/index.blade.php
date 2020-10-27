@extends('layouts.admin')
@section('content')

    <transition name="component-fade" mode="out-in">
        <router-view></router-view>
    </transition>

<script src="{{ asset('js/app.js') }}"></script>


@endsection
