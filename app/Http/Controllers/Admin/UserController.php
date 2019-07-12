<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if(!auth()->user()->can('view', \App\User::class)){
            abort(404);
        }

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

            

            $users = \App\User::where('type', '!=', 'root')->withCount('posts');
            if($keyword){
                $users = $users->where(function($query) use($keyword){
                    return $query->orWhere('email', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('first_name', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('last_name', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('type', 'LIKE', '%'.$keyword.'%');
                });
            }


            if($orderColumn && $orderType){
                $users = $users->orderBy($orderColumn, $orderType);
            }

            $users = $users->paginate($itemsPerPage);
            $users->each(function($user){
                $user->setAppends([
                    'avatar_url',
                ]);
            });

            $pagination = $users->toArray();

            $data = array(
                'draw' => $draw,
                'recordsTotal' => $pagination['total'],
                'recordsFiltered' => $pagination['total'],
                'data' => $pagination['data'],
            );

            return $data;
        }else{
            return view('admin.users.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->can('create', \App\User::class)){
            abort(404);
        }
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->can('create', \App\User::class)){
            abort(404);
        }
        Validator::make($request->input(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'type' => [
                'required', 
                'string',
                Rule::in(['admin', 'publisher', 'writer', 'member']),
            ],
        ])->validate();


        return \App\User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'type' => $request->input('type'),
            'is_banned' => $request->input('banned') ? 1 : null,
        ]);
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
    public function edit(\App\User $user)
    {   
        if($user->type == 'root'){
            abort(404);
        }
        if(!auth()->user()->can('update', $user)){
            abort(404);
        }
        return view('admin.users.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, \App\User $user)
    {
        if($user->type == 'root'){
            abort(404);
        }
        if(!auth()->user()->can('update', $user)){
            abort(404);
        }

        Validator::make($request->input(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'type' => [
                'required', 
                'string',
                Rule::in(['admin', 'publisher', 'writer', 'member']),
            ],
        ])->validate();

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->type = $request->input('type');
        $user->is_banned = $request->input('banned') ? 1: null;
        $user->save();
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

    public function patchPassword(Request $request, \App\User $user){
        if($user->type == 'root'){
            abort(404);
        }
        if(!auth()->user()->can('update', $user)){
            abort(404);
        }

        Validator::make($request->input(), [
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ])->validate();

        $user->password = Hash::make($request->input('password'));
        $user->save();
    }
}
