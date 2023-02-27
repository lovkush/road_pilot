<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        try {
            $user = Auth::guard('sanctum')->user();
            if ($user != null) {
                $request->validate([
                    'title' => 'required',
                    'body' => 'required',
                    'image' => 'required|image',
                ], [
                        'title.required' => 'Title is required.',
                        'body' => 'POst body is required.',
                        'image.required' => 'Image is required.',
                        'image.image' => 'Invalid file',
                    ]);

                if ($request->hasFile('image')) {
                    $name = 'img-' . time() . '-' . rand(0, 99) . '.' . $request->image->extension();
                    $request->image->move(public_path('upload/profileImage/'), $name);
                    $pic_name = 'upload/postImage/' . $name;

                    $post = Post::insert([
                        'title' => $request->title,
                        'body' => $request->body,
                        'created_by' => $user->id,
                        'status' => false,
                        'image' => $pic_name
                    ]);

                    

                    return response()->json([
                        'status' => true,
                        'message' => 'Post Created Successfully',
                        'post' => $post,
                    ], 200);



                } else {
                    return response()->json(['message' => 'Invalid file', 'status' => false], 403);

                }


            } else {
                return response()->json(['message' => 'Unauthorised User', 'status' => false], 401);
            }



        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}