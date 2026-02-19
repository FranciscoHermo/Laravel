@extends('dashboard.layout')

@section('content')

    <a href="{{ route('category.create')}}" target="blank">Create</a>

    <table class="table">
        <thead>
            <tr>
                <td>Title</td>
                <td>id</td>
                <td>Options</td>
            </tr>
        </thead>
        <tbody>     
            @foreach ($categories as $c)
                <tr>
                    <td>
                        {{$c->title}}
                    </td>
                    <td>
                        {{$c->id}}
                    </td>
                    <td>

                        <a href="{{route('category.show', $c->id)}}">Show</a>
                        <a href="{{route('category.edit', $c->id)}}">Edit</a>
                        <form action="{{route('category.destroy', $c->id)}}" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                
            @endforeach
        </tbody>
    </table>

    {{ $categories->links() }}

@endsection