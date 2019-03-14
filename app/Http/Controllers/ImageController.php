<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cloudder;
class ImageController extends Controller
{
    public function upload(Request $request)
    {
     $file_url = "http://yourdomain/defaultimage.png";
    if ($request->hasFile('image') && $request->file('image')->isValid()){
        $cloudder = Cloudder::upload($request->file('image')->getRealPath());
        $uploadResult = $cloudder->getResult();
        $file_url = $uploadResult["url"];
    }
    return response()->json(['file_url' => $file_url], 200);
    }
}
