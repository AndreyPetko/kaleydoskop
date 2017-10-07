<?php

namespace App\Repository;


use App\Brend;
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
        $subcategories = Subcategory::where('category_id', $category->id)->get();

        return $this->subcategoriesListToArrayOfStd($subcategories);
    }


    public function getBrandSubcategories($list)
    {
        $subcategoryIds = [];

        foreach ($list as $item) {
            foreach ($item as $subcategoryId) {
                if(!in_array($subcategoryId, $subcategoryIds)) {
                    $subcategoryIds[] = $subcategoryId;
                }
            }
        }

        $subcategories = Subcategory::whereIn('id', $subcategoryIds)->get();

        return $this->subcategoriesListToArrayOfStd($subcategories);
    }

    private function subcategoriesListToArrayOfStd($subcategories): array
    {
        $result = [];

        foreach ($subcategories as $subcategory) {
            $item = new \StdClass();
            $item->name = $subcategory->name;
            $item->id = $subcategory->id;

            $result[] = $item;
        }

        usort($result, function($a, $b) {
            return strcmp($a->name, $b->name);
        });

        return $result;
    }
}