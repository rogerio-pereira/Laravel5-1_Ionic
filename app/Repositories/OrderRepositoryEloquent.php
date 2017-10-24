<?php

namespace CodeDelivery\Repositories;

use CodeDelivery\Models\Order;
use CodeDelivery\Repositories\OrderRepository;
use CodeDelivery\Validators\OrderValidator;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class OrderRepositoryEloquent
 * @package namespace CodeDelivery\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getByIdAndDeliveryman($idOrder, $idDeliveryman)
    {
        $result = $this->with(['client', 'items', 'cupom'])->findWhere([
            'id' => $idOrder,
            'user_delivery_man_id' => $idDeliveryman
        ]);

        //Se for Collection pega o primeiro resultado que vai ser uma Order
        if($result instanceof Collection) {
            $result = $result->first();
            
            $result->items->each(function($item){
                $item->product;
            });
        }

        return $result;
    }
}
