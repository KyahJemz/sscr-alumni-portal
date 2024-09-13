@extends('guest-master')

@section('content')
<div class="text-center w-1/3 mx-auto">
    <a href="{{ route('login') }}">login</a>
    <br>
    <br>
    <a href="{{ route('register') }}">register</a>
</div>

@endsection
