<?php
namespace App\Http\Controllers;

use App\User;
use JD\Cloudder\Facades\Cloudder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    public function upload(Request $request)
   {
    // $this->validate($request,[
    //     'image_name'=>'required|mimes:jpeg,bmp,jpg,png|between:1, 6000',
    // ]);

    $image_name = $request->file('image_name')->getRealPath();

    Cloudder::upload($image_name, null);

    return response()->json('Successful', 200);

   }

    // public function upload(Request $request)
    // {
    //     $user = Auth::user();

    //     $this->validate($request, [
    //     'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);

    //      // Handle file upload
    //      if($request->hasFile('cover_image'))
    //      {
    //          $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
    //          $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
    //          $extension = $request->file('cover_image')->getClientOriginalExtension();
    //          $fileNameToStore = $fileName.'_'.time().'.'.$extension;
    //          $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);
    //      }
    //      else {
    //          $fileNameToStore = 'noimage.jpg';
    //      }

    //      if($request->hasFile('cover_image'))
    //      {
    //          $user->cover_image = $fileNameToStore;
    //      }
    //      $user->save();

    //     // $file_url = "https://res.cloudinary.com/iro/image/upload/v1552487696/Backtick/noimage.png";
    //     // if ($request->hasFile('cover_image') && $request->file('cover_image')->isValid()){
    //     // $cover_image = Cloudder::upload($request->file('cover_image')->getPathName());
    //     // $uploadResult = $cover_image->getResult();
    //     // $file_url = $uploadResult["url"];
    //     // }
    //     // return response()->json(['file_url' => $file_url], 200);
 
    // //     $cover_image = $request->file('cover_name')->getPathName();;
 
    // //     Cloudder::upload($cover_image, null);
    // //     // $user->cover_images = Cloudder::getResult()['url'];
 
    //     $res['message'] = "{$user->cover_image} Upload Successfully!";        
    //     return response()->json($res, 200);
    // }  
}