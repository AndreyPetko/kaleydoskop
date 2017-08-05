<?php


namespace App\Repository;
use App\Category;
use App\Product;


/**
 * Class ProductRepository
 */
class ProductRepository
{


    /**
     * @param $products
     * @param Category $category
     * @return array
     */
    public function productsToArray($products, Category $category)
    {
        $data = [];

        $list = $this->getProductSubcatListByCategory($category);

        /**
         * @var Product $product
         */
        foreach ($products as $product) {
            $item = new \StdClass();

            $item->name = $product->name;
            $item->price = $product->price;
            $item->url = $product->url;
            $item->image = $product->image;
            $item->subcats = $list[$product->id] ?? [];

            $data[] = $item;
        }

        return $data;
    }


    /**
     * @param Category $category
     * @return mixed
     */
    public function getProductSubcatListByCategory(Category $category)
    {
        $list =  \DB::table('product_subcat')
            ->select('product_subcat.product_id', 'product_subcat.subcat_id')
            ->leftjoin('subcategories', 'subcategories.id', '=', 'product_subcat.subcat_id')
            ->where('subcategories.category_id', $category->id)
            ->get();

        $result = [];

        foreach ($list as $item) {
            $result[$item->product_id][] = $item->subcat_id;
        }

        return $result;
    }

}