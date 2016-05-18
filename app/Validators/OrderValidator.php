<?php

namespace CodeDelivery\Validators;

use Prettus\Validator\LaravelValidator;

class OrderValidator extends LaravelValidator 
{

	protected $rules = [
        'client_id' => 'required',
        'status' => 'required',		
	];

}