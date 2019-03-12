<?php
namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller as BaseController;

class RegisterController extends Controller
{
    public function register(Request $request){
		$this->validateRequest($request);

		$hasher = app()->make('hash');
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
		return response()->json($res, 202);
    }

    public function validateRequest(Request $request){
		$rules = [
            'username' => 'required|unique:users',
						'email' => 'required|email|unique:users',
            'phone' => 'required|numeric|min:11' ,
            'password' => 'required|min:6|confirmed'
		];
		$this->validate($request, $rules);

    }
}