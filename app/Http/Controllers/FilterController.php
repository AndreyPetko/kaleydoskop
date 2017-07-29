<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Repository\ProductRepository;


/**
 * Class FilterController
 * @package App\Http\Controllers
 */
class FilterController extends Controller
{

    /**
     * @param string $url
     * @return array
     */
    public function getCategoryProducts(string $url)
    {
        $category = Category::where('url', $url)->first();
        $products = Product::where('category_id', $category->id)->get();

        $productRepository = new ProductRepository();
        $data = $productRepository->productsToArray($products);


        return $data;
    }
}