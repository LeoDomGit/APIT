<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserM;
use App\Models\LoaiTKM;
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
        $result = DB::Table('users')->join('userrole','users.idRole','=','userrole.id')->select('users.name as username','userrole.name as rolename','users.email as useremail','users.created_at','users.id as userID','users.status')->get();
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
    public function switch(Request $request,UserM $UserM)
    {
        $validation = Validator::make($request->all(),
        [
            
            'id' =>'required|numeric',
        ],
        [
                        
            'id.required'=>'Thiếu mã tài khoản', 
            'id.numeric'=>'Mã tài khoản không hợp lệ',            

        ]);
        if($validation->fails()){
            return response()->json(['check'=>false,'message'=>$validation->errors()]);
        }else{
            $oldstt = UserM::where('id','=',$request->id)->value('status');
            if($oldstt==0){
                UserM::where('id','=',$request->id)->update(['status'=>1,'updated_at'=>now()]);
                return response()->json(['check'=>true]);
            }else if($oldstt==1){
                UserM::where('id','=',$request->id)->update(['status'=>1,'updated_at'=>now()]);
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

    public function checkLogin(Request $request, UserM $UserM)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'image' => 'required',
            'name'=>'required',
        ],[
            'email.required'=>'Thiếu email',
            'email.email'=>'Email không đúng định dạng',
            'image.required'=>'Thiếu hình ảnh',
            'name.required'=>'Thiếu name',
            
        ]);
        if ($validation->fails()) {
            return response()->json(['check' => false,'message'=>$validation->errors()]);
        }else{
            $check = UserM::where('status','=',1)->where('email','=',$request->email)->count();
            if($check!=0){
                userM::where('status','=',1)->where('email','=',$request->email)->update(['name'=>$request->name,'image'=>$request->image]);
                return response()->json(['check'=>true]);
            }else{
                return response()->json(['check'=>false]);
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
    public function edit(UserM $userM,Request $request,LoaiTKM $LoaiTKM)
    {
        $validation = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'email' => 'required|email',
        ],[
            'id.required'=>'Thiếu mã tài khoản',
            'id.numeric'=>'Thiếu mã tài khoản',
            'email.required'=>'Thiếu email',
            'email.email'=>'Email không đúng định dạng',
        ]);
        if ($validation->fails()) {
            return response()->json(['check' => false,'message'=>$validation->errors()]);
        }else{
            if(isset($request->idLTK)){
                if(is_nan($request->idLTK)==true){
                    return response()->json(['check'=>false,'message'=>"Mã Loại tài khoản không hợp lệ"]);
                }else{
                    $check = UserM::where('id','!=',$request->id)->where('email','=',$request->email)->count();
                    if($check!=0){
                        return response()->json(['check'=>false,'message'=>"Email đã được đăng ký ở tài khoản khác"]);
                    }else{
                        UserM::where('id','=',$request->id)->update(['email'=>$request->email,'idRole'=>$request->idLTK,'updated_at'=>now()]);
                        return response()->json(['check'=>true]);
                    }
                }
            }else{
                $check = UserM::where('id','!=',$request->id)->where('email','=',$request->email)->count();
                if($check!=0){
                    return response()->json(['check'=>false,'message'=>"Email đã được đăng ký ở tài khoản khác"]);

                }else{
                UserM::where('id','=',$request->id)->update(['email'=>$request->email,'updated_at'=>now()]);
                return response()->json(['check'=>true]);

                }
            }

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserM  $userM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserM $userM,)
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
