<?php

namespace CodeDelivery\Transformers;

use Illuminate\Database\Eloquent\Collection;
use League\Fractal\TransformerAbstract;
use CodeDelivery\Models\Order;

/**
 * Class OrderTransformer
 * @package namespace CodeDelivery\Transformers;
 */
class OrderTransformer extends TransformerAbstract
{

    protected $defaultIncludes =['cupom', 'items', 'client', 'deliveryman'];
    protected $availableIncludes = ['cupom', 'items', 'client', 'deliveryman'];

    /**
     * Transform the \Order entity
     * @param \Order $model
     *
     * @return array
     */
    public function transform(Order $model)
    {
        return [
            'id'            => (int) $model->id,
            'client'        => $this->includeClient($model),
            'deliveryMan'   => $this->includeDeliveryman($model),
            'items'         => $this->includeItems($model),
            'cupom'         => $this->includeCupom($model),
            'total'         => (float) $model->total,
            'product_names' => $this->getArrayProductNames($model->items),
            'status'        => $model->status,
            'created_at'    => $model->created_at,
            'updated_at'    => $model->updated_at,
        ];
    }

    //Many to one (Cupom)
    public function includeCupom(Order $model){
        if (!$model->cupom){
            return null;
        }
        return $this->item($model->cupom, new CupomTransformer());
    }
    
    //One to many (Items)
    public function includeItems(Order $model){
        return $this->collection($model->items, new OrderItemTransformer());
    }
    
    public function includeClient(Order $model){
        return $this->item($model->client, new ClientTransformer());
    }
    
    protected function getArrayProductNames(Collection $items){
        $names = [];
        foreach ($items as $item){
            $names[] = $item->product->name;
        }
        return $names;
    }
    
    public function includeDeliveryman(Order $model){
        if (!$model->deliveryman){
            return null;
        }
        
        return $this->item($model->deliveryman, new DeliveryManTransformer());
    }

}
