<?php

namespace App\Repository;

use App\Brend;
use App\Category;
use DB;

/**
 * Class BrandRepository
 * @package App\Repository
 */
class BrandRepository
{
    /**
     * @param Category $category
     */
    public function getBrandsInfo(Category $category)
    {
        return DB::select("SELECT DISTINCT(brends.id), brends.name FROM products
                      LEFT JOIN brends ON products.brend_id = brends.id
                      WHERE category_id = $category->id
                      AND brends.id IS NOT NULL ORDER BY name");
    }
}