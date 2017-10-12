<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Controllers\Controller;
use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Repositories\UserRepository;
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

    public function edit($id, UserRepository $userRepository)
    {
        $order = $this->repository->find($id);
        $deliverymen = $userRepository->getDeliverymenCombobox();

        $statusList = [
            0 => 'Pendente',
            1 => 'A Caminho',
            2 => 'Entregue',
            2 => 'Cancelado',
        ];

        return view('admin.orders.edit', compact('order', 'statusList', 'deliverymen'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $this->repository->update($data, $id);

        return redirect()->route('admin.orders.index');
    }
}
