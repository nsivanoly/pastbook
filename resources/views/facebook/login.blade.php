@extends('layouts.app')
@section('content')
@if ($login_url)
    <div class="links">
        <a href="{{ $login_url }}">Allow access and get the last year insights.</a>
    </div>
@endif
@endsection
