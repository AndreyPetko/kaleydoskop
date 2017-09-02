<?php

namespace App\Http\Controllers;

use App\Category;
use App\Filter\BrendFilterBuilder;
use App\Filter\CategoryFilterBuilder;
use App\Filter\FilterChecker;
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
     * @param string $type
     * @return array
     */
    public function getCategoryData(string $url, string $type)
    {
//        $productRepository = new ProductRepository();
//        $categoryRepository = new CategoryRepository();
//        $attributeRepository = new AttributeRepository();
//        $brandRepository = new BrandRepository();

        $filterChecker = new FilterChecker();
        $filterChecker->addBuilder(new BrendFilterBuilder(), BrendFilterBuilder::SLUG);
        $filterChecker->addBuilder(new CategoryFilterBuilder(), CategoryFilterBuilder::SLUG);

        $builder = $filterChecker->getBuilder($type);
        return $builder->getData($url);

//        if($type === 'brend') {
//            $brend = Brend::where('url', $url)->first();
//            $products = Product::where('brend_id', $brend->id)->where('active', true)->orderBy('name')->get();
//        } else {
//            $category = Category::where('url', $url)->first();
//            $products = Product::where('category_id', $category->id)->where('active', true)->orderBy('name')->get();
//        }

//        $subcategories = $categoryRepository->getSubcategoriesArr($category);
//        $products = $productRepository->productsToArray($products, $category);
//
//        $attributes = $attributeRepository->getCategoryInfo($category);
//        $brands = $brandRepository->getBrandsInfo($category);
//
//        $attributesList = $attributeRepository->getIdNameArr();

//        return [
//            'name' => $category->name,
//            'products' => $products,
//            'attributes' => $attributes,
//            'subcategories' => $subcategories,
//            'attributesList' => $attributesList,
//            'brands' => $brands
//        ];
    }
}