    {{$slot}}
    {{$header}}
        <h1>Listado principal de post</h1>
        @foreach ($posts as $p)
            <div class="card card-white mnb-2">
                <h3>{{$p->title}}</h3>
                <a href="{{ route('web.blog.show',$p)}}">Ir</a>
                <p>{{$p->description}}</p>
            </div> 
        @endforeach

{{$extra}}
{{$posts->links()}}

{{$footer}}