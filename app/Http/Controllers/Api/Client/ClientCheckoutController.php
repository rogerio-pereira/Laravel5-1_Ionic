<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Http\Requests\CheckoutRequest;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ClientCheckoutController extends Controller
{
    private $orderRepository;
    private $userRepository;    

    private $service;

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
        $userId = Authorizer::getResourceOwnerId();

        $clientId = $this->userRepository->find($userId)->client->id;
        $orders = $this->orderRepository->with(['items'])->scopeQuery(function($query) use($clientId) {
            return $query->where('client_id', '=', $clientId);
        })->paginate();

        return $orders;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CheckoutRequest $request)
    {
        $data = $request->all();

        $userId = Authorizer::getResourceOwnerId();

        $clientId = $this->userRepository->find($userId)->client->id;
        $data['client_id'] = $clientId;

        $order = $this->service->create($data);
        $order = $this->orderRepository->with(['items'])->find($order->id);
        return $order;
    }

    public function show($id)
    {
        $order = $this->orderRepository->with(['client', 'items', 'cupom'])->find($id);
        /*$order->items->each(function($item){
            $item->product;
        });*/
        return $order;
    }
}
