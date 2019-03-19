<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Cloudder;
use App\User;
use Illuminate\Support\Facades\Auth;


class ImageController extends Controller
{
    public function upload(Request $request)
    {

       $user = Auth::user();
       
       $this->validate($request, [
           'cover_image' => 'required',
       ]);

       $extension = strtolower($request->file('cover_image')->extension());

       $allowed_ext = array("png", "jpg", "jpeg");

       $file_size = filesize($request->file('cover_image'));

       if ($request->hasFile('cover_image') && $request->file('cover_image')->isValid()){

           if (in_array($extension, $allowed_ext)){
           
            if ($file_size > 500000) {
           
                return response()->json('file too large', 401);
           
            }
           
            if ($user->cover_image != "noimage.jpg"){
           
                $image_filename = pathinfo($user->cover_image, PATHINFO_FILENAME);

                   try{
                       Cloudder::destroyImage($image_filename);
                   } catch (Exception $e){
                       return response()->json('Try again', 400);
                   }
               }
               try {
                   Cloudder::upload($request->file('cover_image')->getRealPath());
               } catch (Exception $e) {
                   return response()->json('try again', 400);
               }

               if ($cloudder) {
                   $uploadResult = $cloudder->getResult();
                   $file_url - $uploadResult["public_ic"];
                   $format = $uploadResult["format"];
                   $cover_image = $file_url.".".$format;
                   $user->cover_image = $cover_image;
                   $user->save();

                   return response()->json('success', 200);
               }
           }
       }
        // $file_url = "https://res.cloudinary.com/iro/image/upload/v1552487696/Backtick";
        // if ($request->hasFile('image') && $request->file('image')->isValid()){
        //     $cloudder = Cloudder::upload($request->file('image')->getRealPath());
        //     $uploadResult = $cloudder->getResult();
        //     $file_url = $uploadResult["url"];
        // }
        // return response()->json(['file_url' => $file_url], 200);

    }

}