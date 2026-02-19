@extends('dashboard.layout')

@section('content')
    @include('dashboard.fragment._errors-form')

    <h1>Crear post</h1>

    <form action="{{ route('post.store') }}" method="post">
        @include('dashboard.post._form')

    </form>
@endsection