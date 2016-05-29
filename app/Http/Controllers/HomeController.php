<?php 

namespace CodeDelivery\Http\Controllers;

class HomeController extends Controller {

	public function __construct()
	{
	}

	public function index()
	{
		return view('dashboard');
	}

}