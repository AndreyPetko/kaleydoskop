<?php

namespace App\Repository;


use App\Attribute;
use App\Brend;
use App\Category;

/**
 * Class AttributeRepository
 * @package App\Repository
 */
class AttributeRepository
{

    /**
     * AttributeRepository constructor.
     */
    function __construct()
    {
        $this->attribute = new Attribute();
    }

    /**
     * @param Category $category
     * @return array
     */
    public function getCategoryInfo(Category $category)
    {
        $result = \DB::table('product_attrs_value')
            ->select('attribute_id', 'value')
            ->leftjoin('products', 'products.id', '=', 'product_attrs_value.product_id')
            ->where('products.category_id', $category->id)
            ->where('value', '!=', '')
            ->get();

        return $this->prepareResult($result);
    }


    /**
     * @param Brend $brand
     * @return array
     */
    public function getBrandInfo(Brend $brand)
    {
        $result = \DB::table('product_attrs_value')
            ->select('attribute_id', 'value')
            ->leftjoin('products', 'products.id', '=', 'product_attrs_value.product_id')
            ->where('products.brend_id', $brand->id)
            ->where('value', '!=', '')
            ->get();

        return $this->prepareResult($result);
    }

    /**
     * @return array
     */
    public function getIdNameArr()
    {
        $list = $this->attribute->all();
        $result = [];

        foreach ($list as $item) {
            $result[$item->id] = $item->name;
        }

        return $result;
    }

    /**
     * @param array $result
     * @return array
     */
    private function prepareResult(array $result) : array
    {
        $list = [];

        foreach ($result as $item) {
            if (!isset($list[$item->attribute_id])) {
                $list[$item->attribute_id] = [];
            }

            if (!in_array($item->value, $list[$item->attribute_id])) {
                $list[$item->attribute_id][] = $item->value;
            }
        }

        foreach ($list as &$item) {
            sort($item);
        }

        return $list;
    }
}