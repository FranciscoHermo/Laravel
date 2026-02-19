@extends('dashboard.layout')

@section('content')

    <a class="btn btn-succes" href="{{ route('category.create')}}" target="blank">Create</a>

    <table class="table mb-3">
        <thead>
            <tr>
                <th>Title</th>
                <th>id</th>
                <th>Options</th>
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

                        <a class="mt-2  btn btn-primary" href="{{route('category.show', $c->id)}}">Show</a>
                        <a class="mt-2 btn btn-primary" href="{{route('category.edit', $c->id)}}">Edit</a>
                        <form action="{{route('category.destroy', $c->id)}}" method="post">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger mt-2" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                
            @endforeach
        </tbody>
    </table>

    {{ $categories->links() }}

@endsection