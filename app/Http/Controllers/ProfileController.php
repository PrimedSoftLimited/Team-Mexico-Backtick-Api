<?php

namespace App\Http\Controllers;

use App\User;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use libphonenumber\PhoneNumberType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;

class ProfileController extends Controller
{
        /**
     * @var \Tymon\JWTAuth\JWTAuth
     */
    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function show()
    {
        return response()->json(['auth'=>Auth::user()]);
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        $user->delete();
        $res['message'] = "{$user->username} Deleted Successfully!";
        return response()->json($res, 201);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $token = (str_random(60));
        
        $this->validateRequest($request);

        $user->update([
			'username' => $request->input('username'),
			'email' => $request->get('email'),
			'phone' => $request->input('phone'),
			'first_name' => $request->input('first_name'),
			'last_name' => $request->input('last_name'),
			'password'=> Hash::make($request->get('password')),
			'api_token' => $token
        ]);

		$res['message'] = "{$user->username} Updated Successfully!";        
        return response()->json($res, 200);
    }

    public function validateRequest(Request $request){
        
        $id = Auth::id();
        
        $rules = [
            'username' => 'unique:users,username,'.$id.'|required',
            'email' => 'unique:users,email,'.$id.'|required|email',
            'phone' => 'unique:users,phone,'.$id.'|required|phone:NG,US,mobile',
            'password' => 'required|min:6|confirmed',
        ];
        $messages = [
            'required' => ':attribute is required',
			'phone' => ':attribute number is invalid'
        ];
        $this->validate($request, $rules);
    }
}