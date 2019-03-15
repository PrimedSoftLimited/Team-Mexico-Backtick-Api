<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use libphonenumber\PhoneNumberType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;

class RegisterController extends Controller
{
    public function register(Request $request){
		$this->validateRequest($request);
								 
		$token = (str_random(60));

		$user = User::create([
			'username' => $request->input('username'),
			'email' => $request->get('email'),
			'phone' => $request->input('phone'),
			'password'=> Hash::make($request->get('password')),
			'api_token' => $token
		]);
		$res['message'] = "{$user->username} Created Successfully!";
		$res['user'] = $user;
		return response()->json($res, 201);
    }

    public function validateRequest(Request $request){
		$rules = [
            'username' => 'required|unique:users',
						'email' => 'required|email|unique:users',
            'phone' => 'required|phone:NG,US,mobile|unique:users',
						'password' => 'required|min:6|confirmed',
		];
		$messages = [
			'required' => ':attribute is required',
			'phone' => ':attribute number is invalid'
	];
		$this->validate($request, $rules, $messages);
    }
}