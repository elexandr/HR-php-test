<?php

namespace App\Repositories;

use App\Models\Product as Model;
use Illuminate\Pagination\LengthAwarePaginator;

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
    public function getAllWithPaginate($perPage = 15)
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
            ->paginate($perPage);

        return $result;
    }



}
