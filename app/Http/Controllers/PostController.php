<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = \App\Post::orderBy('created_at', 'DESC')
            ->whereNotNull('published_at');

        if($request->input('keyword')){
            $posts = $posts->where(function($query) use($request){
                $query->where('title', 'LIKE', '%'.$request->input('keyword').'%')
                    ->orWhere('description', 'LIKE', '%'.$request->input('keyword').'%')
                    ->orWhereHas('tags', function($query) use($request){
                        $query->where('name', 'LIKE', '%'.$request->input('keyword').'%');
                    });
            });
        }

        if($request->input('tagId')){
            $posts = $posts->whereHas('tags', function($query) use($request){
                $query->where('id', $request->input('tagId'));
            });
        }

        $posts = $posts->simplePaginate(10);
            

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(\App\Post $post)
    {
        $post->views = $post->views + 1;
        $post->save();
        return view('posts.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
