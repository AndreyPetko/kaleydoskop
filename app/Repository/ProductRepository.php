<?php


namespace App\Repository;
use App\Image;
use App\Product;


/**
 * Class ProductRepository
 */
class ProductRepository
{

    /**
     * @param $products
     * @return array
     */
    public function productsToArray($products)
    {
        $data = [];

        /**
         * @var Product $product
         */
        foreach ($products as $product) {
            $item = new \StdClass();

            $item->name = $product->name;
            $item->price = $product->price;
            $item->url = $product->url;
            $item->image = $product->image;

            $data[] = $item;
        }

        return $data;
    }

}