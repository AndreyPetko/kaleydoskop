<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\Repository\AttributeRepository;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
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
    public function getCategoryData(string $url)
    {
        $productRepository = new ProductRepository();
        $categoryRepository = new CategoryRepository();
        $attributeRepository = new AttributeRepository();
        $brandRepository = new BrandRepository();

        $category = Category::where('url', $url)->first();
        $products = Product::where('category_id', $category->id)->where('active', true)->orderBy('name')->get();

        $subcategories = $categoryRepository->getSubcategoriesArr($category);

        $products = $productRepository->productsToArray($products, $category);

        $attributes = $attributeRepository->getCategoryInfo($category);
        $brands = $brandRepository->getBrandsInfo($category);

        $attributesList = $attributeRepository->getIdNameArr();

        return [
            'name' => $category->name,
            'products' => $products,
            'attributes' => $attributes,
            'subcategories' => $subcategories,
            'attributesList' => $attributesList,
            'brands' => $brands
        ];
    }
}