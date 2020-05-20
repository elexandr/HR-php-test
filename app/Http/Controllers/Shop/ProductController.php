<?php

namespace App\Http\Controllers\Shop;

use App\Http\Requests\ProductUpdateRequest;
use App\Product;
use App\Repositories\ShopProductRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class ProductController extends BaseController
{

    private $shopProductRepository;

    /**
     * ProductCotroller conctructor
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->shopProductRepository = app(ShopProductRepository::class);
    }

    public function index()
    {
        $products = $this->shopProductRepository->getAllWithPaginate();

        return view('shop.products.index', compact('products'));
    }

    public function updatePrice(ProductUpdateRequest $request){

        $data = $request->validated();
        $res = Product::where('id', $data['id'])->update(['price' => $data['price']]);
        Log::debug($res);



        return response()->json(['result' => true]);


    }
}
