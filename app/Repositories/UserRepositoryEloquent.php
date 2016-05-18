<?php

namespace CodeDelivery\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeDelivery\Repositories\UserRepository;
use CodeDelivery\Models\User;
use CodeDelivery\Validators\UserValidator;

/**
 * Class UserRepositoryEloquent
 * @package namespace CodeDelivery\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    public function lists($column, $key = NULL, $labelNull = NULL)
    {
        $_resp = Array();
        $_items = $this->model->lists($column, $key);
        if ($labelNull != NULL) $_resp[0] = $labelNull;
        foreach($_items as $k => $v) {
            $_resp[$k] = $v;
        }
        return $_resp;        
    }
    
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
