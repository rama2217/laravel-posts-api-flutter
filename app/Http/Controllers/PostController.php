<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = Post::where('user_id', $request->user()->id)->get();

        return response()->json([
            'status' => 200,
            'data'   => $posts,
        ]);
    }

    public function store(Request $request)
    {
        $post = Post::create([
            'user_id' => $request->user()->id,
            'title'   => $request->input('title'),
            'content' => $request->input('content'),
            'slug'    => Str::slug($request->input('title')),
            'status'  => $request->input('status') ?? 1,
        ]);

        return response()->json([
            'status' => 200,
            'data'   => $post,
        ]);
    }

    public function show(Request $request, $id)
    {
        $post = Post::where('id', $id)
                    ->where('user_id', $request->user()->id)
                    ->first();

        if (!$post) {
            return response()->json([
                'message' => 'Post tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'data'   => $post,
        ]);
    }

    public function update(Request $request, $id)
    {
        $post = Post::where('id', $id)
                    ->where('user_id', $request->user()->id)
                    ->first();

        if (!$post) {
            return response()->json([
                'message' => 'Post tidak ditemukan',
            ], 404);
        }

        $post->update([
            'title'   => $request->input('title'),
            'content' => $request->input('content'),
            'slug'    => Str::slug($request->input('title')),
            'status'  => $request->input('status') ?? 1,
        ]);

        return response()->json([
            'status' => 200,
            'data'   => $post,
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $post = Post::where('id', $id)
                    ->where('user_id', $request->user()->id)
                    ->first();

        if (!$post) {
            return response()->json([
                'message' => 'Post tidak ditemukan',
            ], 404);
        }

        $post->delete();

        return response()->json([
            'status'  => 200,
            'message' => 'Post berhasil dihapus',
        ]);
    }
}
