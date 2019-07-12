<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!auth()->user()->can('view', \App\Admin::class)){
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

            

            $admins = \App\User::where('type', '!=', 'root');
            if($keyword){
                $admins = $admins->where(function($query) use($keyword){
                    return $query->where('username', 'LIKE', '%'.$keyword.'%')
                        ->orWhere('type', 'LIKE', '%'.$keyword.'%');
                });
            }


            if($orderColumn && $orderType){
                $admins = $admins->orderBy($orderColumn, $orderType);
            }

            $admins = $admins->paginate($itemsPerPage);
            $pagination = $admins->toArray();

            $data = array(
                'draw' => $draw,
                'recordsTotal' => $pagination['total'],
                'recordsFiltered' => $pagination['total'],
                'data' => $pagination['data'],
            );

            return $data;
        }else{
            return view('admin.admins.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!auth()->user()->can('create', \App\Admin::class)){
            abort(404);
        }
        return view('admin.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!auth()->user()->can('create', \App\Admin::class)){
            abort(404);
        }
        Validator::make($request->input(), [
            'username' => ['required', 'string', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'type' => [
                'required', 
                'string',
                Rule::in(['admin', 'publisher', 'writer']),
            ],
        ])->validate();


        $admin = new \App\Admin();
        $admin->username = $request->input('username');
        $admin->password = Hash::make($request->input('password'));
        $admin->type = $request->input('type');
        $admin->is_banned = $request->input('banned')?1:null;
        $admin->save();
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
    public function edit(\App\Admin $admin)
    {   
        if(!auth()->user()->can('update', $admin)){
            abort(404);
        }
        return view('admin.admins.edit', [
            'admin' => $admin
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, \App\Admin $admin)
    {
        if(!auth()->user()->can('update', $admin)){
            abort(404);
        }
        Validator::make($request->input(), [
            'type' => [
                'required', 
                'string',
                Rule::in(['admin', 'publisher', 'writer']),
            ],
        ])->validate();


        $admin->type = $request->input('type');
        $admin->is_banned = $request->input('banned')?1:null;
        $admin->save();
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
