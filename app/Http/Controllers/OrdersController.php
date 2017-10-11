<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\OrderRepository;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    private $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $orders = $this->repository->all();

        return view('admin.orders.index', compact('orders'));
    }
}
