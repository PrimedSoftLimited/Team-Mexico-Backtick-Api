<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Cloudder;
use App\User;

class ImageController extends Controller
{
    public function upload(Request $request)
    {
        $this->validate($request, [
            'cover_image' => 'image|nullable|max:1999'
        ]);

            // Handle file upload
            if($request->hasFile('cover_image'))
            {
                $fileNameWithExt = $request->file('cover_image')->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file('cover_image')->getClientOriginalExtension();
                $fileNameToStore = $fileName.'_'.'.'.$extension;
                $path = $request->file('cover_image')->storeAs('public/cover_image', $fileNameToStore);

            } else {
                $fileNameToStore = 'noimage.jpg';
            }

        // Upload Image
        $user->cover_image = $fileNameToStore; 
        $user->save();

        return response()->json($user->cover_image, 200);

    }

}