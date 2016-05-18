<?php

namespace CodeDelivery\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeDelivery\Repositories\OrderStatusRepository;
use CodeDelivery\Models\OrderStatus;
use CodeDelivery\Validators\OrderStatusValidator;

/**
 * Class OrderStatusRepositoryEloquent
 * @package namespace CodeDelivery\Repositories;
 */
class OrderStatusRepositoryEloquent extends BaseRepository implements OrderStatusRepository
{
    public function lists($column, $key = NULL)
    {
        return $this->model->lists($column, $key);        
    }
    
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OrderStatus::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
