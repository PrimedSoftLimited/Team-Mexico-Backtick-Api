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
        $user = Auth::user();
        return response()->json($user, 200);
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

        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        if(!empty($request->input('password')))
        {
            $user->password = Hash::make($request->input('password'));
        }
        $user->api_token = $token;

        $user->save();

		$res['message'] = "{$user->username} Updated Successfully!";        
        return response()->json($res, 200);
    }

    public function validateRequest(Request $request){
        
        $id = Auth::id();
        $rules = [
            'username' => 'unique:users,username,'.$id.'|required',
            'email' => 'unique:users,email,'.$id.'|required|email',
            'phone' => 'unique:users,phone,'.$id.'|required|phone:NG,US,mobile',
            'first_name' => 'string',
            'last_name' => 'string',
            'password' => 'nullable|min:6|different:current_password|confirmed',
        ];
        $messages = [
            'required' => ':attribute is required',
			'phone' => ':attribute number is invalid'
        ];
        $this->validate($request, $rules);
    }
}