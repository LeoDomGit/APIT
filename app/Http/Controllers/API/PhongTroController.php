<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\phongTroM;
use App\Models\QuanM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class PhongTroController extends Controller
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
    public function create(Request $request,QuanM $QuanM,phongTroM $phongTroM)
    {
        $validation = Validator::make($request->all(),
        [
            
            'roomname' =>'required',
            'price' =>'required|numeric|min:1000',
            'phone' =>'required',
            'dientich' =>'required|numeric|min:10',
            'idQ' =>'required|numeric|min:1',
            'address' =>'required',
            'mota' =>'required',
            'file' =>'required',
        ],
        [
            'roomname.required'=>'Thiếu name phòng',
            'price.required'=>'Thiếu giá phòng',            
            'price.numeric'=>'Giá phòng không hợp lệ',            
            'dientich.required'=>'Thiếu diện tích phòng', 
            'dientich.numeric'=>'Diện tích phòng không hợp lệ',            
            'dientich.min'=>'Diện tích phòng quá nhỏ',            
            'idQ.required'=>'Thiếu mã quận', 
            'idQ.numeric'=>' Mã quận không hợp lệ',            
            'idQ.min'=>'Mã quận không hợp lệ',  
            'phone.required'=>'Thiếu số điện thoại',            
            'address.required'=>'Thiếu địa chỉ phòng',            
            'mota.required'=>'Thiếu mô tả phòng',            
            'file.required'=>'Thiếu hình ảnh phòng',            
        ]);
        if($validation->fails()){
            return response()->json(['check'=>false,'message'=>$validation->errors()]);
        }else{
            $filetype = $_FILES['file']['type'];
            $filetype1= explode('/', $filetype);
            $accept = ['gif', 'jpeg', 'jpg', 'png', 'svg', 'jfif', 'JFIF', 'blob', 'GIF', 'JPEG', 'JPG', 'PNG', 'SVG', 'webpimage', 'WEBIMAGE', 'webpimage', 'webpimage', 'webpimage', 'webp', 'WEBP'];
            $filetype = $_FILES['file']['type'];
            $pattern='/^[0][3|5|7|8|9][0-9]{8}+$/';
            if(!in_array($filetype1[1], $accept)){
                return response()->json(['check'=>false,'message'=>"Hình ảnh không hợp lệ"]);
            }else if(!preg_match($pattern, $request->phone)){
                return response()->json(['check' => false,'message'=>'Số điện thoại không hợp lệ']);    
            }else{
                $check=phongTroM::where('roomname','=',$request->roomname)->count('id');
                if($check!=0){
                    return response()->json(['check'=>false,'message'=>"Đã tồn tại phòng trong danh sách"]);
                }else{
                    move_uploaded_file($_FILES['file']['tmp_name'],'images/'.$_FILES['file']['name']);
                    $filename=$_FILES['file']['name'];
                    DB::Table('roomtable')->insert([
                        'roomname'=>$request->roomname,
                        'address'=>$request->address,
                        'price'=>$request->price,
                        'phone'=>$request->phone,
                        'image'=>$filename,
                        'dientich'=>$request->dientich,
                        'mota'=>$request->mota,
                        'idQuan'=>$request->idQ,
                        'created_at'=>now()
                    ]);
                    return response()->json(['check'=>true]);
                }
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request,QuanM $QuanM,phongTroM $phongTroM)
    {
        $result = DB::Table('roomtable')->join('quantable','roomtable.idQuan','=','quantable.id')->select('roomtable.id as idRoome','roomtable.roomname','address','price','phone','image','dientich','mota','districtname','quantable.id as idQuan','roomtable.created_at as created_at')->get();
        return response()->json($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\phongTroM  $phongTroM
     * @return \Illuminate\Http\Response
     */
    public function show(phongTroM $phongTroM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\phongTroM  $phongTroM
     * @return \Illuminate\Http\Response
     */
    public function edit(phongTroM $phongTroM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\phongTroM  $phongTroM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, phongTroM $phongTroM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\phongTroM  $phongTroM
     * @return \Illuminate\Http\Response
     */
    public function destroy(phongTroM $phongTroM)
    {
        //
    }
}
