<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use Illuminate\Http\Request;

use CodeDelivery\Http\Controllers\Controller;

use CodeDelivery\Http\Requests\CheckoutRequest;

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

    private $with = ['client', 'cupom', 'items'];

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
        $orders = $this->repository
            ->skipPresenter(false)
            ->with($this->with)->scopeQuery(function($query) use($clientId) {
            return $query->where('client_id', '=', $clientId);
        })->paginate();
        return $orders;
    }

    public function store(CheckoutRequest $request)
    {
        $data = $request->all();
        $id = Authorizer::getResourceOwnerId();
        $clientId = $this->userRepository->find($id)->client->id;
        $data['client_id'] = $clientId;
        $o = $this->service->create($data);
        return $this->repository
            ->skipPresenter(false)
            ->with($this->with)->find($o->id);
    }

    public function show($id)
    {
        $o = $this->repository
            ->skipPresenter(false)
            ->with($this->with)->find($id);
        return $o;
    }

}
