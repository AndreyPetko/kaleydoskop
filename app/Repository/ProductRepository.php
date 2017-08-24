<?php


namespace App\Repository;

use App\Category;
use App\Product;
use App\Wishlist;


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
        $attributes = $this->getProductAttributesListByCategory($category);


        /**
         * @var Product $product
         */
        foreach ($products as $product) {
            $item = new \StdClass();

            $item->id = $product->id;
            $item->name = $product->name;
            $item->price = $product->price;
            $item->url = $product->url;
            $item->image = $product->image;
            $item->brand = $product->brend_id;
            $item->subcats = $list[$product->id] ?? [];
            $item->attributes = $attributes[$product->id] ?? [];
            $item->wish = false;

            $data[] = $item;
        }

        $this->setWish($data);

        return $data;
    }


    /**
     * @param Category $category
     * @return mixed
     */
    public function getProductSubcatListByCategory(Category $category)
    {
        $list = \DB::table('product_subcat')
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

    /**
     * @param Category $category
     * @return array
     */
    public function getProductAttributesListByCategory(Category $category)
    {
        $list = \DB::table('product_attrs_value')
            ->select('product_attrs_value.product_id', 'product_attrs_value.attribute_id', 'product_attrs_value.value')
            ->leftjoin('products', 'products.id', '=', 'product_attrs_value.product_id')
            ->whereNotNull('products.id')
            ->where('product_attrs_value.value', '!=', '')
            ->where('products.category_id', $category->id)
            ->get();


        $result = [];

        foreach ($list as $item) {
            $result[$item->product_id][$item->attribute_id] = $item->value;
        }

        return $result;
    }


    /**
     * @param $products
     * @return mixed
     */
    private function setWish($products)
    {
        $wishlistObj = Wishlist::getInstance();
        $wishlist = $wishlistObj->get();

        $wishIds = [];
        foreach ($wishlist as $wishItem) {
            $wishIds[] = $wishItem->id;
        }

        foreach ($products as &$product) {
            $product->wish = in_array($product->id, $wishIds);
        }

        return $products;
    }

}