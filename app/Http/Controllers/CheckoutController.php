<?php

namespace CodeDelivery\Http\Controllers;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests\AdminCategoryRequest;

use CodeDelivery\Services\OrderService;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Repositories\ProductRepository;

use Auth;

class CheckoutController extends Controller
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
        $clientId = $this->userRepository->find(Auth::user()->id)->client->id;
        $orders = $this->repository->scopeQuery(function($query) use($clientId) {
            return $query->where('client_id', '=', $clientId);
        })->paginate();
        return view('customer.order.index', compact('orders'));
    }

    public function create()
    {
        $products = $this->productRepository->listsPrice();
		return view('customer.order.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $clientId = $this->userRepository->find(Auth::user()->id)->client->id;
        $data['client_id'] = $clientId;
        $this->service->create($data);
        return redirect()->route('customer.order.index');
    }

}
