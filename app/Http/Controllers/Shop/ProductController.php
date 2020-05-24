<?php

namespace App\Http\Controllers\Shop;

use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Repositories\ShopProductRepository;

class ProductController extends BaseController
{
    // Логика получения в репозитории
    private $shopProductRepository;

    /**
     * ProductController constructor
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->shopProductRepository = app(ShopProductRepository::class);
    }

    /** Получаем список товаров с пагинацией
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = $this->shopProductRepository->getAllWithPaginate(25);

        return view('shop.products.index', compact('products'));
    }

    /** Обработчик ajax обновления цены из списка продуктов
     *
     * @param ProductUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePrice(ProductUpdateRequest $request){
        $data = $request->validated();
        $res = Product::where('id', $data['id'])->update(['price' => $data['price']]);

        return response()->json(['result' => $res]);
    }
}
