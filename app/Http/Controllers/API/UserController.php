<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $result = DB::Table('users')->join('userrole','users.idRole','=','userrole.id')->select('users.name as username','userrole.name as rolename','users.email as useremail','users.created_at','users.status')->get();
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,UserM $UserM)
    {
        $validation = Validator::make($request->all(), [
            'name'=>'required',
            'email'=>'required|email',
            'role'=>'required|numeric',

        ],[
            'name.required'=>'Thiếu tên tài khoản',
            'email.required'=>'Thiếu email tài khoản',
            'email.email'=>'Email không hợp lệ',
            'role.required'=>'Thiếu loại tài khoản',
            'role.numeric'=>'Loại tài khoản không hợp lệ',
        ]
        ); 
        if ($validation->fails()) {
            return response()->json(['check' => false,'message'=>$validation->errors()]);
        }else{
            $check=UserM::where('name','=',$request->name)->orWhere('email', '=', $request->email)->count('id');
            if($check!=0){
                return response()->json(['check'=>false,'message'=>'Đã tồn tại tài khoản']);
            }else{
                UserM::create(['name'=>$request->name,'email'=>$request->email,'idRole'=>$request->role]);
                return response()->json(['check'=>true]);
            }
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
     * @param  \App\Models\UserM  $userM
     * @return \Illuminate\Http\Response
     */
    public function show(UserM $userM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserM  $userM
     * @return \Illuminate\Http\Response
     */
    public function edit(UserM $userM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserM  $userM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserM $userM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserM  $userM
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserM $userM)
    {
        //
    }
}