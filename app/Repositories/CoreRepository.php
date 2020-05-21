<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/** Базовый
 *
 *  Class CoreRepository
 * * @package App\Repositories
  */

abstract class coreRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * CoreRepository constructor
     */
    public function __construct()
    {
        $this->model = app($this->getModelClass());
    }

    /**
     * @return mixed
     */
    abstract protected function getModelClass();

    /**
     * @return Model|\Illuminate\Foundation\Application|mixed
     */
    protected function startConditions()
    {
        return clone $this->model;
    }
}
