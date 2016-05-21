<?php

namespace CodeDelivery\Http\Controllers;

use Illuminate\Http\Request;

use CodeDelivery\Http\Requests\AdminOrderRequest;

use CodeDelivery\Services\OrderService;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Repositories\OrderStatusRepository;

use Illuminate\Support\Facades\DB;
use Illuminate\Routing\UrlGenerator;
use CodeDelivery\Models\Order;

class OrdersController extends Controller
{

    /**
    * @var UrlGenerator
    */
    protected $url;

    /**
    * @var OrderRepository
    */
    protected $repository;

    /**
    * @var ProductRepository
    */
    protected $productRepository;

    /**
    * @var UserRepository
    */
    protected $userRepository;

    /**
    * @var OrderStatusRepository
    */
    protected $orderStatusRepository;

    /**
    * @var OrderService
    */
    protected $service;

    public function __construct(
        UrlGenerator $url,
        OrderRepository $repository,
        OrderService $service,
        ProductRepository $productRepository,
        UserRepository $userRepository,
        OrderStatusRepository $orderStatusRepository
    ) {
        $this->repository = $repository;
        $this->productRepository = $productRepository;
        $this->userRepository = $userRepository;
        $this->orderStatusRepository = $orderStatusRepository;
        $this->service = $service;
        $this->url = $url;
    }    

    public function index()
    {
        $orders = $this->repository->paginate(30);
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $clients = $this->userRepository->lists('name', 'id');
        $products = $this->productRepository->all();
        //$list_status = [ 0 => 'Pendente', 1 => 'A caminho', 2 => 'Entregue' ];
        $list_status = $this->orderStatusRepository->lists('name', 'id');
        $url = $this->url;
        $icont = 0;
		return view('admin.orders.create', 
            compact(
                'clients', 
                'products', 
                'list_status', 
                'icont',
                'url'
            ));
    }

    public function edit($id)
    {
    	$order = $this->repository->find($id);
        $products = $this->productRepository->all();
        $clients = $this->userRepository->lists('name', 'id');
        $deliveryman = $this->userRepository->getDeliverymen();
        //$list_status = [ 0 => 'Pendente', 1 => 'A caminho', 2 => 'Entregue' ];
        $list_status = $this->orderStatusRepository->lists('name', 'id');
        $url = $this->url;
        $icont = 0;
		return view('admin.orders.edit', 
            compact(
                'order', 
                'clients', 
                'products', 
                'list_status', 
                'icont',
                'url',
                'deliveryman'
            ));
    }

    public function store(AdminOrderRequest $request)
    {
        $data = $request->all();
        $this->service->create($data);
        return redirect()->route('admin.orders.index');
    }

    public function update(Request $request, $id)
    {
    	$data = $request->all();
		$this->repository->update($data, $id);
		return redirect()->route('admin.orders.index');
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return redirect()->route('admin.orders.index');
    }

}
