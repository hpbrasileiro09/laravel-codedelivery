<?php

namespace CodeDelivery\Transformers;

use CodeDelivery\Models\User;
use League\Fractal\TransformerAbstract;
use CodeDelivery\Models\DeliveryMan;

/**
 * Class DeliveryManTransformer
 * @package namespace CodeDelivery\Transformers;
 */
class DeliveryManTransformer extends TransformerAbstract
{
    /**
     * Transform the \DeliveryMan entity
     * @param \DeliveryMan $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'    => (int) $model->id,
            'name'  => $model->name,
            'email' => $model->email
        ];
    }
}