<?php

namespace CodeDelivery\Services;

use CodeDelivery\Repositories\OrderItemRepository;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Validators\OrderValidator;

use \Prettus\Validator\Exceptions\ValidatorException;

class OrderService 
{

	/**
	* @var OrderRepository
	*/
	protected $repository;

	/**
	* @var OrderItemRepository
	*/
	protected $itemRepository;

	/**
	* @var OrderValidator
	*/
	protected $validator;

	public function __construct(
		OrderRepository $repository,
		OrderItemRepository $itemRepository,
		OrderValidator $validator)
	{
		$this->repository = $repository;
		$this->itemRepository = $itemRepository;
		$this->validator = $validator;
	}
	
	public function create(array $data)
	{
		try {
			$this->validator->with($data)->passesOrFail();
			$data['total'] = $this->calcTotal($data);
			$order = $this->repository->create($data);
			$this->saveItems($data, $order->id);
		} catch(ValidatorException $e) {
			return [
				'error' => true,
				'message' => $e->getMessageBag()
			];
		}
	}

	public function update(array $data, $id)
	{
		try {
			$this->validator->with($data)->passesOrFail();
			$this->deleteItems($data); 
			$data['total'] = $this->calcTotal($data);
			if ($data['user_deliveryman_id'] == 0) {
				$data['user_deliveryman_id'] = NULL;
			}
			$this->repository->update($data, $id);
			$this->saveItems($data, $id);
		} catch(ValidatorException $e) {
			return [
				'error' => true,
				'message' => $e->getMessageBag()
			];
		}
	}

	public function calcTotal(array $data) 
	{
		$total = 0;
	    foreach($data as $k => $v) {
	        $pos = strpos($k, 'product_id_');
	        if ($pos !== false) {
	            $mat = explode("_", $k);
	            $icont = $mat[2]; 
	            $total += intval($data['quantity_'.$icont]) * floatval($data['price_'.$icont]);
	        }
	    }
	    return $total;
	}

	public function deleteItems(array $data) 
	{
		if (strlen($data['destroy']) > 0) {
        	$mat = explode("|", $data['destroy']);
    		foreach($mat as $item) {
				$this->itemRepository->delete($item);
			}
		}
	}

	public function saveItems(array $data, $order_id) 
	{
	    foreach($data as $k => $v) {
	        $pos = strpos($k, 'product_id_');
	        if ($pos !== false) {
	            $mat = explode("_", $k);
	            $icont = $mat[2]; 
	            $resp = Array(
	            	'order_id' => $order_id,
	                'product_id' => $data['product_id_'.$icont],
	                'price' => $data['price_'.$icont],
	                'qtd' => $data['quantity_'.$icont],
	            );
	            if ($data['item_'.$icont] == '0') {
					$this->itemRepository->create($resp);
				} else {
					$this->itemRepository->update($resp, $data['item_'.$icont]);
				}
	        }
	    }
	}

}