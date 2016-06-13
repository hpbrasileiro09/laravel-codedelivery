<?php

namespace CodeDelivery\Http\Controllers\Api\Deliveryman;

use Illuminate\Http\Request;

use CodeDelivery\Http\Controllers\Controller;

use CodeDelivery\Http\Requests\AdminCategoryRequest;

use CodeDelivery\Services\OrderService;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Auth;

class DeliverymanCheckoutController extends Controller
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
    * @var OrderService
    */
    protected $service;

    private $with = ['client', 'cupom', 'items'];

    public function __construct(
        OrderService $service,
        OrderRepository $repository,
        UserRepository $userRepository) {
        $this->service = $service;
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }    

    public function index()
    {
        $id = Authorizer::getResourceOwnerId();
        $orders = $this->repository
            ->skipPresenter(false)
            ->with($this->with)->scopeQuery(function($query) use($id) {
            return $query->where('user_deliveryman_id', '=', $id);
        })->paginate();
        return $orders;
    }

    public function show($id){
        $idDeliveryman = Authorizer::getResourceOwnerId();
        return $this->repository
            ->skipPresenter(false)
            ->getByIdAndDeliveryman($id, $idDeliveryman);
    }
    
    public function updateStatus(Request $request, $id){
        $idDeliveryman = Authorizer::getResourceOwnerId();
        $order = $this->service->updateStatus($id, $idDeliveryman, $request->get('status'));
        if ($order){
            return $this->repository->find($order->id);
        }
        abort(400, 'Pedido não encontrado');
    }

}
