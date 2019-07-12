<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){

            
            $draw = $request->get('draw');
            $currentPage = $request->input('start')/$request->input('length')+1;
            $itemsPerPage = $request->input('length')?$request->input('length'):10;
            $keyword = $request->input('search.value');
            $orderColumn = $request->input('order.0.column');
            $orderType = $request->input('order.0.dir');

            \Illuminate\Pagination\Paginator::currentPageResolver(function () use($currentPage) {
                return $currentPage;
            });

            

            $posts = \App\Post::with('user');
            if($keyword){
                $posts = $posts->where(function($query) use($keyword){
                    return $query->orWhere('title', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('description', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('body', 'LIKE', '%'.$keyword.'%');
                });
            }


            if($orderColumn && $orderType){
                $posts = $posts->orderBy($orderColumn, $orderType);
            }

            if(auth()->user()->type == 'writer'){
                $posts = $posts->where('user_id', auth()->user()->id);
            }

            $posts = $posts->paginate($itemsPerPage);
            $posts->each(function($post){
                $post->setAppends([
                    'slug',
                ]);
            });

            $pagination = $posts->toArray();

            $data = array(
                'draw' => $draw,
                'recordsTotal' => $pagination['total'],
                'recordsFiltered' => $pagination['total'],
                'data' => $pagination['data'],
            );

            return $data;
        }else{
            return view('admin.posts.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->can('create', \App\Post::class)){
            abort(404);
        }
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->can('create', \App\Post::class)){
            abort(404);
        }
        Validator::make($request->input(), [
            'title' => ['required', 'string', 'max:255'],
        ])->validate();



        //Create new post
        $post = new \App\Post();
        $post->title = $request->input('title');
        $post->description = $request->input('description')?$request->input('description'):null;
        $post->body = $request->input('body')?$request->input('body'):null;
        $post->published_at = $request->input('published')?now():null;
        $post->admin_id = auth()->user()->id;
        $post->save();

        //Attach tags to post
        $post->syncTags($request->input('tags'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(\App\Post $post)
    {
        if(!auth()->user()->can('update', $post)){
            abort(404);
        }
        return view('admin.posts.edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, \App\Post $post)
    {
        if(!auth()->user()->can('update', $post)){
            abort(404);
        }
        Validator::make($request->input(), [
            'title' => ['required', 'string', 'max:255'],
        ])->validate();

        $post->title = $request->input('title');
        $post->description = $request->input('description')?$request->input('description'):null;
        $post->body = $request->input('body')?$request->input('body'):null;
        

        if(auth()->user()->can('publish', $post)){
            if($post->published_at){
                if(!$request->input('published')){
                    $post->published_at = null;
                }
            }else{
                if($request->input('published')){
                    $post->published_at = now();
                }
            }
        }else{
            $post->published_at = null;
        }

        
        $post->save();
        //Attach tags to post
        $post->syncTags($request->input('tags'));
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
