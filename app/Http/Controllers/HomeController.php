<?php 

namespace CodeDelivery\Http\Controllers;

class HomeController extends Controller {

	public function __construct()
	{
	}

	public function index()
	{

		\Storage::append('codedelivery.log', '00-Home-index');

		return view('app');
	}

}