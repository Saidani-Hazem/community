<?php

namespace App\Http\Controllers;

use App\Models\post;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function index()
    {
        try {
            $posts = Post::orderBy('created_at', 'desc')->get();
            return response()->json(['posts' => $posts]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try{
        $request->validate([
            'description'=>'nullable|string|max:255',
            'img' => 'nullable|image|mimes:jpg|max:3072'
        ]);

            $picId = Str::uuid()->toString();
            $imageExt = $request->file('img')->getClientOriginalExtension();
            $picname = $picId . '.' . $imageExt;
            $path = public_path('postsPic');
            $request->file('img')->move($path, $picname);
            $post = new post();

            $post->user_id = 1; // to change with id_user

            $post->description = $request->desc;
            $post->img = $picId;
            $post->save();
            return response()->json(['msj' => 'post added']);
        }catch(Exception $e){
            return response()->json(['err' => $e->getMessage()]);
        }
    }


    public function show(post $post)
    {
        return response()->json(['post' => $post]);
    }

  

   
    public function update(Request $request, post $post)
    {
        
    }

   
    public function destroy(post $post)
    {
        try{
        $post->delete();
        return response()->json(['msj' => 'post deleted']);
        }catch(Exception $e){
            return response()->json(['err' => $e->getMessage()]);
        }
    }



}
