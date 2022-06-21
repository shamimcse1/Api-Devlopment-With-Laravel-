<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\ValidationException;

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
            "image" => "nullable|string|mimes:jpeg,png,jpg||max:2048",
            
        ];

        //$request->all()
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            $errors[] = $validator->errors()->all();

            return response()->json(array('message' => $errors), 422);
        } else {
            // $members = Member::find($request->members->id);
            $members = new Member();
            $members->name = $request->name;
            $members->description = $request->description;
            $members->number = $request->numner;
            $members->address = $request->address;
            if ($request->image && $request->image->isValid()) {
                $file_name = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $file_name);
                $path = "public/images/$file_name";
                $members->image = $path;
            }



            // if (request()->hasFile('image')) {
            //     $file = request()->file('image');
            //     $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
            //     $destinationPath = public_path('/images/'); //// I assume you have a folder named images in public.
            //     $file->move($destinationPath, $fileName);
        
            //     $members['image'] = $destinationPath.$fileName; // I assume you have a field named avatar in users table.
            // }


            // if($request->file('image')){
            //     $file= $request->file('image');
            //     $filename= date('YmdHi').$file->getClientOriginalName();
            //     $file-> move(public_path('public/Image'), $filename);
            //     $members['image']= $filename;
            // }


            // if(!$request->hasFile('image')) {
            //     return response()->json(['upload_file_not_found'], 400);
            // }
            // $file = $request->file('image');
            // if(!$file->isValid()) {
            //     return response()->json(['invalid_file_upload'], 400);
            // }
            // $path = public_path() . '/uploads/images/store/';
            // $file->move($path, $file->getClientOriginalName());
            // $members->image = $path;
        
            $members->save();

            return response()->json(array('status' => 'success', 'data' => $members));
        }
    }
}
