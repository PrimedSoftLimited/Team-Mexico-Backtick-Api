<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $user = Auth::user();
        
        $this->validate($request, [
        'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

         // Handle file upload
         if($request->hasFile('cover_image'))
         {
             $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
             $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
             $extension = $request->file('cover_image')->getClientOriginalExtension();
             $fileNameToStore = $fileName.'_'.time().'.'.$extension;
             $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
         }

         if($request->hasFile('cover_image'))
         {
             $user->cover_image = $fileNameToStore;
         }
         $user->save();

         $res['message'] = "{$user->cover_image} Updated Successfully!";        
         return response()->json($res, 200);
    }  
}