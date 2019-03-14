<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use libphonenumber\PhoneNumberType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;

class ProfileController extends Controller
{
    public function showAllUsers()
    {   
        $user = User::all();
        return response()->json($user, 201);
    }

    public function showOneUser(Request $request, $id)
    {   
        $user = User::findOrFail($id);
        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $this->validateRequest($request);
        $token = (str_random(60));

        // Update User Account
        $user = User::findOrFail($id);
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->phone = $request->input('password');
        $user->password = Hash::make($request->get('password'));
        $user->api_token = $token;
        $user->save();

		$res['message'] = "{$user->username} Updated Successfully!";        
        return response()->json($res, 200);
    }

    public function destroy(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // if(Auth::user()->id !== $user_id)
        // {        
        //     return response()->json('Unauthorized Access!', 400);
        // }
        $user->delete();
        $res['message'] = "{$user->username} Deleted Successfully!";
        return response()->json($res, 201);
    }

    public function validateRequest(Request $request){
        $rules = [
            'username' => 'required',
            'email' => 'required|email',
            'phone' => 'required|phone:NG,US,mobile',
            'password' => 'required|min:6|confirmed',
        ];
        $messages = [
            'phone' => 'The :attribute number is invalid.',
        ];
        $this->validate($request, $rules, $messages);
    }
}