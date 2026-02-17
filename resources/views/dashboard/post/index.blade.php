@extends('dashboard.master')

@section('content')
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Posted</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($posts as $p)
                <tr>
                    <td>
                        {{$p->title}}
                    </td>
                    <td>
                        {{$p->posted}}
                    </td>
                    <td>
                        {{$p->category->title}}
                    </td>
                </tr>
                
            @endforeach
        </tbody>
    </table>

    {{ $posts->links() }}

@endsection