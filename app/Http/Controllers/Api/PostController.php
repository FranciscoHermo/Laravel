<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PutRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Models\Post;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/post
     */
    public function index()
    {
        return response()->json(Post::with('category')->paginate(10));
    }

    /**
     * Get all posts without pagination
     * GET /api/post/all
     */
    public function all()
    {
        return response()->json(Post::with('category')->get());  // ← Sin paginate()
    }

    /**
     * Get post by slug
     * GET /api/post/slug/{slug}
     */
    public function slug($slug)  // ← Recibe $slug como string, no Post model
    {
        $post = Post::with('category')
            ->where('slug', $slug)
            ->firstOrFail();
        
        return response()->json($post);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/post
     */
    public function store(StoreRequest $request)
    {
        $post = Post::create($request->validated());  // ← validated() no validate()
        
        return response()->json([
            'success' => true,
            'message' => 'Post creado exitosamente',
            'data' => $post->load('category')
        ], 201);
    }

    /**
     * Display the specified resource.
     * GET /api/post/{post}
     */
    public function show(Post $post)
    {
        return response()->json($post->load('category'));
    }

    /**
     * Update the specified resource in storage.
     * PUT /api/post/{post}
     */
    public function update(PutRequest $request, Post $post)
    {
        $post->update($request->validated());  // ← validated() no validate()
        
        return response()->json([
            'success' => true,
            'message' => 'Post actualizado exitosamente',
            'data' => $post->load('category')
        ]);  // ← Retorna el post, no el resultado de update()
    }

    public function upload(Request $request, Post $post)
    {
            $request->validate([
                'image' => "required|mime:jpg,png,gif|max:10249"
            ]);

            // Storage::disk("public_upload")->delete("image/otro/".$post->image);

             $data['image'] = $filename = time().'.'.$request['image']->extension();
             $request->image->move(public_path('image/otro'), $filename);


             $post->update($data);

             return response()->json($post);

    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/post/{post}
     */
    public function destroy(Post $post)
    {
        $post->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Post eliminado exitosamente'
        ]);
    }
}