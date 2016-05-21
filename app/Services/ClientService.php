<?php

namespace CodeDelivery\Services;

use CodeDelivery\Repositories\ClientRepository;
use CodeDelivery\Repositories\UserRepository;

use \Prettus\Validator\Exceptions\ValidatorException;

class ClientService 
{

	/**
	* @var ClientRepository
	*/
	protected $repository;

	/**
	* @var UserRepository
	*/
	protected $userRepository;

	public function __construct(
		ClientRepository $repository,
		UserRepository $userRepository)
	{
		$this->repository = $repository;
		$this->userRepository = $userRepository;
	}
	
	public function create(array $data)
	{
		try {
			$data['user']['password'] = bcrypt(123456);
			$user = $this->userRepository->create($data['user']);
			$data['user_id'] = $user->id;
			$this->repository->create($data);
		} catch(Exception $e) {
			return [
				'error' => true,
				'message' => $e->getMessage()
			];
		}
	}

	public function update(array $data, $id)
	{
		try {
			$this->repository->update($data, $id);
			$userId = $this->repository->find($id, ['user_id'])->user_id;
			$this->userRepository->update($data['user'], $userId);
		} catch(Exception $e) {
			return [
				'error' => true,
				'message' => $e->getMessage()
			];
		}
	}

}