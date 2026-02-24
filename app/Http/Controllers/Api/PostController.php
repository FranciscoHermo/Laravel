<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PutRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use PharIo\Manifest\Type;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Post::paginate(10));
    }

    public function all(){
        return response()->json(Post::paginate());
    }

    public function slug(Post $post){
        // $post = Post::where("slug", $slug)->firstOrFail();
        $post->category;
        return response()->json($post);
    }


    public function store(StoreRequest $request)
    {
        return response()->json(Post::create($request->validate()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return response()->json($post);
    }


    public function update(PutRequest $request, Post $post)
    {
        return response()->json($post->update($request->validate()));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json("ok");
    }
}
