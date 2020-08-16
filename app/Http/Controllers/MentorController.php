<?php

namespace App\Http\Controllers;

use App\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
class MentorController extends Controller
{
    public function index()
    {
        $mentor = Mentor::all();
        return response()->json([
            "status" => "success",
            "data" => $mentor
        ]);
    }

    public function show($id)
    {
        $mentor = Mentor::find($id);

        if(!$mentor){
            return response()->json([
                "status" => "error",
                "message" => "mentor not found"
            ], 404);
        }

        return response()->json([
            "status" => "success",
            "data" => $mentor
        ]);
    }

    public function create(Request $request)
    {
        $rules = [
            "name" => "required|string",
            "profile" => "required|url",
            "profession" => "required|string",
            "email" => "required|email|unique:mentors,email"
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if($validator->fails()){
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()
            ], 400);
        }

        $mentor = Mentor::create($data);

        return response()->json([
            "status" => "success",
            "data" => $mentor,
        ]);
    }

    public function update(Request $request, $id)
    {
        $mentor = Mentor::find($id);

        if(!$mentor){
            return response()->json([
                "status" => "error",
                "message" => "mentor not found"
            ], 404);
        }

        $rules = [
            "name" => "string",
            "profile" => "url",
            "profession" => "string",
            "email" => "email|unique:mentors,email,".$mentor->id
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if($validator->fails()){
            return response()->json([
                "status" => "error",
                "message" => $validator->errors(),
            ], 400);
        }

       
        $mentor->fill($data);
        
        $mentor->save();

        return response()->json([
            "status" => "success", 
            "data" => $mentor 
        ]);
    }

    public function destroy($id)
    {
        $mentor = Mentor::find($id);

        if(!$mentor){
            return response()->json([
                "status" => "error",
                "message" => "mentor not found"
            ], 404);
        }

        $mentor->delete();

        return response()->json([
            "status" => "success", 
            "message" => "mentor deleted" 
        ]);
    }

}