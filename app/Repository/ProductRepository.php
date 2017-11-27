<?php


namespace App\Repository;

use App\Brend;
use App\Category;
use App\Product;
use App\User;
use App\Wishlist;
use DB;

/**
 * Class ProductRepository
 */
class ProductRepository
{

    /**
     * @param $products
     * @param $list
     * @param $attributes
     * @return array
     */
    public function productsToArray($products, $list, $attributes)
    {
        $data = [];

        /**
         * @var Product $product
         */
        foreach ($products as $product) {
            $item = new \StdClass();

            $item->id = $product->id;
            $item->name = $product->name;
            
            if(\Auth::user() && \Auth::user()->role === User::WHOLESALER_ROLE_SLUG) {
                $item->price = $product->wholesale_price;
            } else {
                $item->price = $product->price;
            }

            $item->url = $product->url;
            $item->quantity = $product->quantity;

            if(!$product->image) {
                $item->image = $product->getImage();
            } else {
                $item->image = $product->image;
            }

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
     * @param Brend $brand
     * @return array
     */
    public function getProductSubcatListByBrand(Brend $brand)
    {
        $list = \DB::table('product_subcat')
            ->select('product_subcat.product_id', 'product_subcat.subcat_id')
            ->leftjoin('products', 'products.id', '=', 'product_subcat.product_id')
            ->where('products.brend_id', $brand->id)
            ->where('products.active', true)
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
            ->where('products.active', true)
            ->get();


        $result = [];

        foreach ($list as $item) {
            $result[$item->product_id][$item->attribute_id] = $item->value;
        }

        return $result;
    }

    /**
     * @param Brend $brand
     * @return array
     */
    public function getProductAttributesListByBrand(Brend $brand)
    {
        $list = \DB::table('product_attrs_value')
            ->select('product_attrs_value.product_id', 'product_attrs_value.attribute_id', 'product_attrs_value.value')
            ->leftjoin('products', 'products.id', '=', 'product_attrs_value.product_id')
            ->whereNotNull('products.id')
            ->where('product_attrs_value.value', '!=', '')
            ->where('products.brend_id', $brand->id)
            ->where('products.active', true)
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

    /**
     * @param $product
     */
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

    /**
     * @param array $products
     */
    public function insertProducts(array $products)
    {
        $data = [];

        foreach ($products as $product) {
            $data[] = [
                'article' => $product['article'],
                'code' => $product['code'] ? $product['code'] : null,
                'name' => $product['name'],
                'price' => $product['price'],
                'no1c' => 1,
                'quantity' => $product['count'],
                'group' => $product['group'],
                'wholesale_price' => $product['priceWholesale'],
                'active' => 1,
                'active_wholesale' => 1,
                'url' => $product['url']
            ];
        }

        DB::table('products')->insert($data);
    }

    /**
     * @param $product
     * @param $item
     */
    public function updateProduct($product, $item)
    {
        $data = [
            'group' => $product['group'],
            'article' => $product['article'],
            'quantity' => $product['count'],
            'wholesale_price' => $product['priceWholesale'],
        ];

        if($item->no1c == false) {
            $data['name'] = $product['name'];
            $data['url'] = $product['url'];
        }
        
        if($item->no_price_1c == false) {
            $data['price'] = $product['price'];
        }

        DB::table('products')->where('code', $product['code'])->update($data);
    }

    /**
     * @param $updateProducts
     */
    public function updateProducts($updateProducts)
    {
//        dump($updateProducts[0]);
//        die;
//        $sql = "UPDATE a
//                    SET fruit = (CASE id WHEN 1 THEN 'apple'
//                                         WHEN 2 THEN 'orange'
//                                         WHEN 3 THEN 'peach'
//                                 END)
//                    WHERE id IN(1,2 ,3)";
    }


    /**
     * @param $products
     * @return bool
     */
    public function updateByArray($products)
    {
        $updateProducts = [];
        $insertProducts = [];

        $codes = [];

        foreach ($products as $product) {
            $codes[] = $product['code'];
        }

        $items = DB::table('products')->whereIn('code', $codes)->get();

        $realCodes = [];

        foreach ($items as $item) {
            $realCodes[] = $item->code;
        }

        foreach ($products as $product) {
            $key = array_search($product['code'], $realCodes);

            if($key !== false) {
                $item = $items[$key];
//                $updateProducts[] = $product;
                $this->updateProduct($product, $item);
            } else {
                $insertProducts[] = $product;
//                $insertProducts[] = $product;
            }
        }

        $this->insertProducts($insertProducts);

//        $this->updateProducts($updateProducts);

//        foreach ($products as $product) {
//            $item = DB::table('products')->where('code', $product['code'])->first();
//
//            if ($item) { // Если товар уже есть то обновляем его
////                $updateProducts[] = $item;
//                $this->updateProduct($product, $item);
//            } else { // Если нет то создаем новый
//                $this->insertProduct($product);
////                $insertProducts[] = $item;
//            }
//        }


//        $this->updateProducts($updateProducts);

        return true;
    }

}