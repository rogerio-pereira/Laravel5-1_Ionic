<?php

namespace CodeDelivery\Http\Controllers\Api\Client;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\ProductRepository;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $clientId = $this->userRepository->find(Auth::user()->id)->client->id;
        $orders = $this->orderRepository->scopeQuery(function($query) use($clientId) {
            return $query->where('client_id', '=', $clientId);
        })->paginate();

        return view('customer.orders.index', compact('orders'));
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

        $clientId = $this->userRepository->find(Auth::user()->id)->client->id;
        $data['client_id'] = $clientId;

        $this->service->create($data);

        return redirect()->route('customer.orders.index');
    }

    public function show($id)
    {
        return ['Meu Pedido'];
    }
}
