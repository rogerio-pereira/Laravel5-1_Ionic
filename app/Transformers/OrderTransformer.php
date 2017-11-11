<?php

namespace CodeDelivery\Transformers;

use League\Fractal\TransformerAbstract;
use CodeDelivery\Models\Order;

/**
 * Class OrderTransformer
 * @package namespace CodeDelivery\Transformers;
 */
class OrderTransformer extends TransformerAbstract
{
    
    /*
        SÃO CHAMADOS TODAS AS VEZES
        USAR COM DADOS EXTREMAMENTE NECESSÁRIOS
     */
    //protected $defaultIncludes = ['cupom', 'items'];

    /*
        SÃO CHAMADOS SOB DEMANDA
        PARA SEREM CHAMADOS A REQUISIÇÃO DEVE CONTER UM PARAMETRO NA URL INCLUDE E O NOME DO RELACIONAMENTO

        EX: http://laravelionic/api/client/order/1?include=cupom,items

        USAR QUANDO OS DADOS NÃO FOREM TÃO NECESSÁRIOS
        DIMINUI O VOLUME DE DADOS, DEIXANDO O APP MAIS RAPIDO
     */
    protected $availableIncludes = ['cupom', 'items'];

    /**
     * Transform the \Order entity
     * @param \Order $model
     *
     * @return array
     */
    public function transform(Order $model)
    {
        return [
            'id' => (int) $model->id,
            'total' => (float) $model->total,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    //Relacionamento ManyToOne
    public function includeCupom(Order $model)
    {
        if(!$model->cupom)
            return null;
        
        return $this->item($model->cupom, new CupomTransformer()); 
    }

    //Relacionamento OneToMany
    public function includeItems(Order $model)
    {
        return $this->collection($model->items, new OrderItemTransformer()); 
    }
}
