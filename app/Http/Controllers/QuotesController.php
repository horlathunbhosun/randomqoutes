<?php

namespace App\Http\Controllers;

use App\Qoutes;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers;

class QuotesController extends Controller
{
    //



    public function index(){
        $qoute = Qoutes::all();
        if($qoute){
            return response()->json(['status'=>'ok', 'message'=>$qoute]);
        }
    }


    public function store(Request $request){
        $rules = [
            'text' => 'required|string',
            'author' => 'required',         
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'not ok', 'message' => $validator->errors()], 400);
        }else{
           $data = $request->only('text', 'author');
           $qoute = new Qoutes($data);
           $con   = $qoute->save();
           if($con){
               return response()->json(['status'=> ' ok', 'message'=>'Qoute has been created successfully'], 201);
           }else{
               return response()->json(['status'=>'not ok', 'message'=> 'Qoute not added successfully'], 404);
           }
        }
    }


    public function destroy($id){
        $qoute = Qoutes::findOrfail($id);
        if($qoute->delete()){
            return response()->json(['status'=>'ok', 'message'=>'Qoute has been deleted sucessfully'], 200);
        }else{
            return response()->json(['status'=>'ok', 'message'=>'An error Occurred while deleting qoute'], 403);
        }

    }
}
