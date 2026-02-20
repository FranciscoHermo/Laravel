@extends('web.layout')

@section('content')
    <x-web.blog.post.show :post="$post" class="bg-red-300" other-attr="data2"/>
@endsection