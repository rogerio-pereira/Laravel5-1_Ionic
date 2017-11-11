<?php

namespace CodeDelivery\Http\Controllers\Api\Deliveryman;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class DeliverymanCheckoutController extends Controller
{
    private $orderRepository;
    private $userRepository;

    private $service;

    private $with = ['client', 'cupom', 'items'];

    public function __construct(
                                    OrderRepository $orderRepository, 
                                    UserRepository $userRepository,
                                    OrderService $service
                                )
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;

        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliverymanId = Authorizer::getResourceOwnerId();

        $orders = $this->orderRepository
            ->skipPresenter(false)
            ->with($this->with)
            ->scopeQuery(function($query) use($deliverymanId) {
                return $query->where('user_delivery_man_id', '=', $deliverymanId);
        })->paginate();

        return $orders;
    }

    public function show($id)
    {
        $deliverymanId = Authorizer::getResourceOwnerId();
        return $this->orderRepository
            ->skipPresenter(false)
            ->getByIdAndDeliveryman($id, $deliverymanId);
    }

    public function updateStatus(Request $request, $id)
    {
        $status = $request->get('status');
        $deliverymanId = Authorizer::getResourceOwnerId();

        $order = $this->service->updateStatus($id, $deliverymanId, $status);

        if($order) {
            return $this->orderRepository->find($order->id);
        }

        abort(400, 'Order não encontrado');
    }
}
