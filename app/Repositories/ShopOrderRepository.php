<?php

namespace App\Repositories;

use App\Order as Model;

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

    public function getAllWithPaginate()
    {
        $columns = [
            'id',
            'status',
            'partner_id',
            'delivery_dt',
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->orderBy('id', 'DESC')
            ->with(['partner:id,name', 'orderproduct', 'product'])
            ->paginate(20);


        //TODO: Посмотреть на предмет оптимизации

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
     * Получить модeль для редкатирования в админке
     * @param $id
     * @return mixed
     */


    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }

}
