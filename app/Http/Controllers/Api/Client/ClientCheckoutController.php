<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use Illuminate\Http\Request;

use CodeDelivery\Http\Controllers\Controller;

use CodeDelivery\Http\Requests\AdminCategoryRequest;

use CodeDelivery\Services\OrderService;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Repositories\ProductRepository;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Auth;

class ClientCheckoutController extends Controller
{

    /**
    * @var OrderRepository
    */
    protected $repository;

    /**
    * @var UserRepository
    */
    protected $userRepository;

    /**
    * @var ProductRepository
    */
    protected $productRepository;

    /**
    * @var OrderService
    */
    protected $service;

    public function __construct(
        OrderService $service,
        OrderRepository $repository,
        UserRepository $userRepository,
        ProductRepository $productRepository) {
        $this->service = $service;
        $this->repository = $repository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
    }    

    public function index()
    {
        $id = Authorizer::getResourceOwnerId();
        $clientId = $this->userRepository->find($id)->client->id;
        $orders = $this->repository->with(['items'])->scopeQuery(function($query) use($clientId) {
            return $query->where('client_id', '=', $clientId);
        })->paginate();
        return $orders;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $id = Authorizer::getResourceOwnerId();
        $clientId = $this->userRepository->find($id)->client->id;
        $data['client_id'] = $clientId;
        $o = $this->service->create($data);
        $o = $this->repository->with(['items'])->find($o->id);
        return $o;
    }

    public function show($id)
    {
        $o = $this->repository->with(['items','client','cupom'])->find($id);
        $o->items->each(function($item) {
            $item->product;
        });
        return $o;
    }

}
