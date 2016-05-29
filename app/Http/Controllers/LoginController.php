<?php 

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Controllers\Controller;

use Auth;
use Request;

class LoginController extends Controller {

	public function login()
	{
		$credenciais = Request::only('email', 'password');

		if(Auth::attempt($credenciais)) {
			return view('admin.panel.index');
		}

		$_success_message = "1";
		$message = "As credencias não são válidas";

		$data = [ 
			'message' => $message,
			'base_path' => env('BASE_PATH'),
		];

		return view('auth.login')->with($data);		
	}

	public function logout()
	{
		Auth::logout();

		return view('welcome');
	}

}
