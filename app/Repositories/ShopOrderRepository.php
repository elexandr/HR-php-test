<?php

namespace App\Repositories;

use App\Order as Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
    public function getAll()
    {
        $columns = [
            'id',
            'status',
            'partner_id',
            'delivery_dt',
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->with([
                'partner:id,name',
                'orderproduct:id,order_id,product_id,quantity,price',
                'product'])
            ->get();

        //Получаем сумму позиции
        $result->each(function ($item) {
            $item->orderproduct->each(function ($item) {
                $item['item_sum'] = $item->quantity * $item->price;
                return $item;
            });
        });

        //Получаем сумму заказа
        $result->each(function ($item) {
            $item['order_sum'] = $item->orderproduct->sum('item_sum');
        });

        //Объединяем продукты в строку и получем статус заказа текстом
        $result->each(function ($item) {
            $item['products'] = $item->product->implode('name', ', ');
            $item['text_status'] = $this->getTextStatus($item->status);
        });

        return $result;
    }

    /** Получаем все заказы с заданным к-вом пагинации (по умолчанию 0)
     *
     * @param null $perPage
     * @return mixed
     */
    public function getAllWithPaginate($perPage = NULL)
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
            ->paginate($perPage);

        //Получаем сумму позиции
        $result->getCollection()->each(function ($item) {
            $item->orderproduct->each(function ($item) {
                $item['item_sum'] = $item->quantity * $item->price;
                return $item;
            });
        });

        //Получаем сумму заказа
        $result->getCollection()->each(function ($item) {
            $item['order_sum'] = $item->orderproduct->sum('item_sum');
        });

        //Объединяем продукты в строку и получем статус заказа текстом
        $result->getCollection()->each(function ($item) {
            $item['products'] = $item->product->implode('name', ', ');
            $item['text_status'] = $this->getTextStatus($item->status);
        });

        return $result;
    }

    /**
     * Получить конкретный заказ
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection
     */

    public function getOne($id)
    {
        $columns = [
            'id',
            'status',
            'client_email',
            'partner_id',
        ];
         $order = $this->startConditions()
            ->with(['partner:id,name', 'orderproduct', 'product'])
            ->find($id);

        return $order;
    }

    public function getOrderEmails($id)
    {
        // Получаем emails клиента и поставщиков товаров по заказу
        $query = <<<TAG
            select client_email from orders where id = '$id'
            union
            select 
            distinct
            vendors.email
            from vendors
            inner join products 
            on products.vendor_id = vendors.id 
            inner join order_products 
            on order_products.product_id = products.id
            inner join orders 
            on orders.id = order_products.order_id
            where orders.id = '$id';
TAG;

        $emails = collect(DB::select($query));


        return $emails;
    }

    public function getOrderProducts($id)
    {
         $order = $this->startConditions()
            ->with(['product'])
            ->find($id);

         $products = $order->product;
        return $products;
    }

    public function getOrderSUm($id){
        $columns = [
            'id',
        ];

        $result = $this->startConditions()
            ->select($columns)
            ->with([
                'orderproduct:order_id,quantity,price',
                ])
            ->find($id);

        $sum = 0;
        foreach ($result->orderproduct as $item) {
            $sum += $item->quantity * $item->price;
        }

        return $sum;

    }

    /** Возвращаем статусы. Вынес в репозиторий, так как сами статусы могут стать редактируемыми и храниться в бд
     *
     * @return array
     */
    public function getOrderStatuses()
    {
        $statuses = [
            0 => 'Новый',
            10 => 'Подтвержден',
            20 => 'Завершен',
        ];
        return $statuses;
    }

    public function getTextStatus($status){
        $statuses = $this->getOrderStatuses();

        return $statuses[$status];
    }

}
