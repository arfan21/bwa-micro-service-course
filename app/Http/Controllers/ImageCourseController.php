<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\ImageCourse;
use Illuminate\Support\Facades\Validator;

class ImageCourseController extends Controller
{
    public function create(Request $request)
    {
        $rules = [
            "image" => "required|string|url",
            "course_id" => "required|integer",
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                "status" => "error",
                "message" => $validator->errors()
            ]);
        }

        $courseId = $request->input("course_id");
        $course = Course::find($courseId);

        if (!$course) {
            return response()->json([
                "status" => "error",
                "message" => "course not found",
            ], 404);
        }

        $imageCourse = ImageCourse::create($data);

        return response()->json([
            "status" => "success",
            "data" => $imageCourse
        ]);
    }

    public function destroy($id)
    {
        $imageCourse = ImageCourse::find($id);

        if (!$imageCourse) {
            return response()->json([
                "status" => "error",
                "messaGe" => "image course not found"
            ]);
        }

        $imageCourse->delete();

        return response()->json([
            "status" => "success",
            "message" => "image course deleted"
        ]);
    }
}
