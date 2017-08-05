<?php

namespace App\Repository;


use App\Category;
use App\Subcategory;

/**
 * Class CategoryRepository
 * @package App\Repository
 */
class CategoryRepository
{

    /**
     * @param Category $category
     * @return array
     */
    public function getSubcategoriesArr(Category $category)
    {
        $result = [];
        $subcategories = Subcategory::where('category_id', $category->id)->get();


        foreach ($subcategories as $subcategory) {
            $item = new \StdClass();
            $item->name = $subcategory->name;
            $item->id = $subcategory->id;

            $result[] = $item;
        }

        return $result;
    }
}