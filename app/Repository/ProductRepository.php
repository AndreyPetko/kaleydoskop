<?php


namespace App\Repository;

use App\Brend;
use App\Category;
use App\Product;
use App\Wishlist;
use DB;

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
     * @param $products
     * @param Brend $brand
     */
    public function productsToArrayBrand($products, Brend $brand)
    {

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


    public function insertProduct($product)
    {
        DB::table('products')->insert([
            'article' => $product['article'],
            'code' => $product['code'],
            'name' => $product['name'],
            'price' => $product['price'],
            'no1c' => 1,
            'quantity' => $product['count'],
            'group' => $product['group'],
            'wholesale_price' => $product['priceWholesale'],
            'active' => 1,
            'active_wholesale' => 1,
            'url' => $product['url']
        ]);
    }

    public function updateProduct($product, $item)
    {
        $data = [
            'group' => $product['group'],
            'article' => $product['article'],
            'quantity' => $product['count'],
            'wholesale_price' => $product['priceWholesale'],
        ];

        if($item->no1c === false) {
            $data['name'] = $product['name'];
            $data['url'] = $product['url'];
        }

        if($item->no_price_1c === false) {
            $data['price'] = $product['price'];
        }

        DB::table('products')->where('code', $product['code'])->update($data);
    }


    public function updateByArray($products)
    {
        foreach ($products as $product) {
            $item = DB::table('products')->where('code', $product['code'])->first();

            if ($item) { // Если товар уже есть то обновляем его
                $this->updateProduct($product, $item);

            } else { // Если нету то создаем новый
                $this->insertProduct($product);
            }
        }

        return true;
    }

}