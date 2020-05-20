<?php

namespace App\Repositories;

use App\Order as Model;
use Illuminate\Pagination\LengthAwarePaginator;
use mysql_xdevapi\Collection;

/**
 * Class ShopOrderRepository
 * @package App\Repositories
 */
class ShopOrderRepository extends CoreRepository
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
            'status',
            'partner_id',
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->orderBy('id', 'DESC')
            ->with([
                'partner:id,name',
                'orderproduct:id,order_id,product_id,quantity,price',
                'product'])
            ->paginate(20);

        $result->getCollection()->each(function ($item) {                         //Получаем сумму позиции
            $item->orderproduct->each(function ($item) {
                $item['item_sum'] = $item->quantity * $item->price;
                return $item;
            });
        });

        $result->getCollection()->each(function ($item) {                         //Получаем сумму заказа
            $item['order_sum'] = $item->orderproduct->sum('item_sum');
        });

        $result->getCollection()->each(function ($item) {                         //Объединяем продукты в строку
            $item['products'] = $item->product->implode('name', ', ');
        });

        return $result;
    }

    /**
     * Получить модeль для редкатирования
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function getEdit($id)
    {
        return $this->startConditions()
            ->with(['partner:id,name', 'orderproduct', 'product'])
            ->find($id);
    }

}
