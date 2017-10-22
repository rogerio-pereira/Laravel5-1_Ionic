<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ClientCheckoutController extends Controller
{
    private $orderRepository;
    private $userRepository;
    private $productRepository;

    private $service;

    public function __construct(
                                    OrderRepository $orderRepository, 
                                    UserRepository $userRepository,
                                    ProductRepository $productRepository,
                                    OrderService $service
                                )
    {
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;

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
    public function store(Request $request)
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
        return ['Meu Pedido'];
    }
}
