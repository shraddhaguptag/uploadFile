<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documents; 
use Validator; 

class FileUploadController extends Controller
{
    public function upload(Request $request) 
    {
        $validator = Validator::make($request->all(),[
              'user_id' => 'required', 
              'file' => 'required|mimes:doc,docx,pdf,txt,jpeg,png,jpg,gif|max:2048',
        ]);   
  
        if($validator->fails()) {          
             
            return response()->json(['error'=>$validator->errors()], 401);                        
        }
   
        if ($file = $request->file('file')) {
            $path = $file->store('public/files');
            $name = $file->getClientOriginalName();
  
            //store file into directory and db
            $document = new Documents();
            $document->title = $name;
            $document->path= $path;
            $document->user_id = $request->user_id;
            $document->save();
               
            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "status" => 200
            ]);
   
        }
    }
}
