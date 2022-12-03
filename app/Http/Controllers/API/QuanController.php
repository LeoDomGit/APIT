<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\QuanM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class QuanController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,QuanM $QuanM)
    {
        $validation = Validator::make($request->all(),
        [
            
            'quan' =>'required',
            'id'=>'required|numeric',
        ],
        [
            'id.required' =>'Thiếu mã quận',   
            'id.numeric' =>'Mã quận không hợp lệ',   
            'quan.required'=>'Thiếu tên quận',            

        ]);
        if($validation->fails()){
            return response()->json(['check'=>false,'message'=>$validation->errors()]);
        }else{
            $check = QuanM::where('districtname','=',$request->quan)->count('id');
            if($check==0){
                QuanM::where('id','=',$request->id)->update(['districtname'=>$request->quan,'updated_at'=>now()]);
                return response()->json(['check'=>true]);
            }else{
                return response()->json(['check'=>false,'message'=>'Quận đã tồn tại']);
            }
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request,QuanM $QuanM)
    {
        $result =DB::Table('quantable')->get();
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request,QuanM $QuanM)
    {
        $validation = Validator::make($request->all(),
        [
            
            'quan' =>'required',
        ],
        [
                        
            'quan.required'=>'Thiếu tên quận',            

        ]);
        if($validation->fails()){
            return response()->json(['check'=>false,'message'=>$validation->errors()]);
        }else{
            $check = QuanM::where('districtname','=',$request->quan)->count('id');
            if($check==0){
                QuanM::create(['districtname'=>$request->quan]);
                return response()->json(['check'=>true]);
            }else{
                return response()->json(['check'=>false,'message'=>'Quận đã tồn tại']);
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
     * @param  \App\Models\QuanM  $quanM
     * @return \Illuminate\Http\Response
     */
    public function show(QuanM $quanM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\QuanM  $quanM
     * @return \Illuminate\Http\Response
     */
    // public function edit(QuanM $quanM)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuanM  $quanM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, QuanM $quanM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\QuanM  $quanM
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,QuanM $quanM)
    {
        $validation = Validator::make($request->all(),
        [
            
            'id' =>'required|numeric',
        ],
        [
                        
            'id.required'=>'Thiếu mã quận',   
            'id.numeric'=>'Mã quận không hợp lệ',            

        ]);
        if($validation->fails()){
            return response()->json(['check'=>false,'message'=>$validation->errors()]);
        }else{
            $check = DB::Table('roomtable')->where('idQuan','=',$request->id)->count('id');
            if($check==0){
                QuanM::where('id','=',$request->id)->delete();
                return response()->json(['check'=>true]);
            }else{
                return response()->json(['check'=>false,'message'=>'Có phòng trọ trong quận']);
            }
        }
    }
}
