<?php

namespace CodeDelivery\Http\Controllers;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests\AdminClientRequest;

use CodeDelivery\Repositories\ClientRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\ClientService;

class ClientsController extends Controller
{

    /**
    * @var ClientRepository
    */
    protected $repository;

    /**
    * @var UserRepository
    */
    protected $userRepository;

    /**
    * @var ClientService
    */
    protected $clientService;

    public function __construct(
        ClientRepository $repository,
        UserRepository $userRepository,
        ClientService $clientService) {
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->clientService = $clientService;
    }    

    public function index()
    {
		$clients = $this->repository->paginate(30);
		return view('admin.clients.index', compact('clients'));
    }

    public function create()
    {
        $users = $this->userRepository->lists('name', 'id');
		return view('admin.clients.create', compact('users'));
    }

    public function store(Request $request)
    {
    	$data = $request->all();
		$this->clientService->create($data);
		return redirect()->route('admin.clients.index');
    }

    public function edit($id)
    {
    	$client = $this->repository->find($id);
        $users = $this->userRepository->lists('name', 'id');
		return view('admin.clients.edit', compact('client', 'users'));
    }

    public function update(Request $request, $id)
    {
    	$data = $request->all();
		$this->clientService->update($data, $id);
		return redirect()->route('admin.clients.index');
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return redirect()->route('admin.clients.index');
    }

}
