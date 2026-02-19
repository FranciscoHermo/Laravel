@extends('dashboard.layout')

@section('content')

    <a class="btn btn-succes my-3" href="{{ route('post.create')}}" target="blank">Create</a>

    <table class="table mb-3">
        <thead>
            <tr>
                <th>Title</th>
                <th>id</th>
                <th>Posted</th>
                <th>Category</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>     
            @foreach ($posts as $p)
                <tr>
                    <td>
                        {{$p->title}}
                    </td>
                    <td>
                        {{$p->id}}
                    </td>
                    <td>
                        {{$p->posted}}
                    </td>
                    <td>
                        {{$p->category->title}}
                    </td>
                    <td>

                        <a class="my-2 btn btn-primary" href="{{route('post.show', $p->id)}}">Show</a>
                        <a class="my-2 btn btn-primary" href="{{route('post.edit', $p->id)}}">Edit</a>
                        <form action="{{route('post.destroy', $p->id)}}" method="post">
                            @method('DELETE')
                            @csrf
                            <button class="my-2 btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
                
            @endforeach
        </tbody>
    </table>

    {{ $posts->links() }}

@endsection