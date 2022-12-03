<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ThemLoaiTK;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class ThemLoaiTKController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['check'=>true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createthem(Request $request,ThemLoaiTK $ThemLoaiTK )
    {
        $validation = Validator::make($request->all(),
        [
            
            'name' =>'required',
        ],
        [
                        
            'name.required'=>'Thiếu name',            

        ]);
        if($validation->fails()){
            return response()->json(['check'=>false,'message'=>$validation->errors()]);
        }else{
            $check = ThemLoaiTK::where('name','=',$request->name)->count('id');
                if($check==0){
                    ThemLoaiTK::create([
                        'name' => $request->name,
                        'created_at' => now()]);
                } 
                else{
                    return response()->json(['check' => false]);
                    
                }
                return response()->json(['check' => true]);

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
