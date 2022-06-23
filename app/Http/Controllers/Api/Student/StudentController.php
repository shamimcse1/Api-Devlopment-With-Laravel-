<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\ValidationException;
use Facades\FlareClient\Stacktrace\File;

class StudentController extends Controller
{
    public function index($id = null)
    {
        if ($id == '') {
            $members = Member::get();
            return response()->json(array(
                'status' => 200,
                'data' => $members,
                'massage' => "Data found"
            ));
        } else {

            $members = Member::find($id);
            return response()->json(array(
                'status' => 200,
                'data' => $members,
                'massage' => "Data found"
            ));
        }
    }


    public function create(Request $request)
    {
        $rules = [
            "name" => "required|min:3",
            "description" => "nullable|string",
            "number" => "required|max:11",
            "address" => "required|string",
            "image" => "required|mimes:jpeg,png,jpg||max:2048",
        ];

        //$request->all()
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors[] = $validator->errors()->all();

            return response()->json(array('message' => $errors), 422);
        } else {
            // $members = Member::find($request->members->id);
            $members = new Member();
            $members->name = $request->name;
            $members->description = $request->description;
            $members->number = $request->number;
            $members->address = $request->address;
            if ($request->image && $request->image->isValid()) {
                $file_name = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $file_name);
                $path = "public/images/$file_name";
                $members->image = $path;
            }
            $members->save();

            return response()->json(array('status' => 'success', 'data' => $members));
        }
    }

    public function edit($id)
    {
        $members = Member::findOrFail($id);
        return response()->json(array('status' => 'success', 'data' => $members));
    }

    public function update(Request $request, $id)
    {
        
        $rules = [
            "name" => "required|min:3",
            "description" => "nullable|string",
            "number" => "required|max:11",
            "address" => "required|string",
            "image" => "required|mimes:jpeg,png,jpg||max:2048",
        ];

        //$request->all()
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $errors[] = $validator->errors()->all();

            return response()->json(array('message' => $errors), 422);
        } else {
            $members = Member::findOrFail($id);
            $members->name = $request->name;
            $members->description = $request->description;
            $members->number = $request->number;
            $members->address = $request->address;
            if ($request->image && $request->image->isValid()) {
                $file_name = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $file_name);
                $path = "public/images/$file_name";
                $members->image = $path;
            }
            
            $members->update();

            return response()->json(array('status' => 'success', 'data' => $members));
        }
    }
}
