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
        $orders = Order::select(
                'orders.id',
                'orders.client_id',
                'orders.user_deliveryman_id',
                'orders.total',
                'orders.created_at',
                DB::raw("COALESCE(DATE_FORMAT(orders.created_at, '%d/%m/%Y %H:%I:%S'),'') AS created_at_br"),
                'orders.updated_at',
                'orders.total',
                DB::raw('order_status.name AS ds_status'),
                DB::raw('users.name AS nm_client'))
                ->leftJoin('order_status', function($join){
                    $join->on('orders.status', '=', 'order_status.id');
                })
                ->leftJoin('users', function($join){
                    $join->on('orders.client_id', '=', 'users.id');
                })
                ->orderBy('orders.id','desc')
                ->paginate(30);
        return view('admin.orders.index', compact('orders'));
    }

    public function __index()
    {
		$orders = $this->repository->paginate(30);
		return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
        $clients = $this->userRepository->lists('name', 'id');
        $products = $this->productRepository->all();
        $status = $this->orderStatusRepository->lists('name', 'id');
        $url = $this->url;
        $icont = 0;
		return view('admin.orders.create', 
            compact(
                'clients', 
                'products', 
                'status', 
                'icont',
                'url'
            ));
    }

    public function edit($id)
    {
    	$order = $this->repository->find($id);
        $products = $this->productRepository->all();
        $clients = $this->userRepository->lists('name', 'id');
        $deliveryman = $this->userRepository->lists('name', 'id', '<Selecione um entregador>');
        $status = $this->orderStatusRepository->lists('name', 'id');
        $url = $this->url;
        $icont = 0;
		return view('admin.orders.edit', 
            compact(
                'order', 
                'clients', 
                'products', 
                'status', 
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

    public function update(AdminOrderRequest $request, $id)
    {
    	$data = $request->all();
		$this->service->update($data, $id);
		return redirect()->route('admin.orders.index');
    }

    public function destroy($id)
    {
        $this->repository->delete($id);
        return redirect()->route('admin.orders.index');
    }

}
