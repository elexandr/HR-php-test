<?php

namespace App\Repositories;

use App\Product as Model;
use Illuminate\Pagination\LengthAwarePaginator;
use mysql_xdevapi\Collection;

/**
 * Class ShopOrderRepository
 * @package App\Repositories
 */
class ShopProductRepository extends CoreRepository
{

    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllWithPaginate()
    {
        $columns = [
            'id',
            'name',
            'vendor_id',
            'price',
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->orderBy('name', 'ASC')
            ->with(['vendor:id,name'])
            ->paginate(25);

        return $result;
    }



}
