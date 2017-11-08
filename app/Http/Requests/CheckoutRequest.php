<?php

namespace CodeDelivery\Http\Requests;

use CodeDelivery\Http\Requests\Request;
use Illuminate\Http\Request as HttpRequest;

class CheckoutRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(HttpRequest $request)
    {
        $rules = [
            'cupom_code' => 'exists:cupoms,code,used,0',
        ];

        $this->buildRulesItem(0, $rules);

        $items = $request->get('items',[]);     //Obtem o campo items, e se estiver vazio atribui um array vazio
        $items = !is_array($items) ? [] : $items; //Verifica se os items não forem um array, então receberá um array vazio, se for recebe ele mesmo

        foreach($items as $key => $value) {
            $this->buildRulesItem($key, $rules);
        }

        return $rules;
    }

    public function buildRulesItem($key, array &$rules)
    {
        $rules["items.$key.product_id"] = 'required';
        $rules["items.$key.qtd"]        = 'required';
    }
}
