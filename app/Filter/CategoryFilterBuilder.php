<?php

namespace App\Filter;

use App\Category;
use App\Product;
use App\Repository\AttributeRepository;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;

/**
 * Class CategoryFilterBuilder
 * @package App\Filter
 */
class CategoryFilterBuilder implements FilterBuilderInterface
{

    const SLUG = 'category';

    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var AttributeRepository
     */
    private $attributeRepository;
    /**
     * @var BrandRepository
     */
    private $brandRepository;

    /**
     * CategoryFilterBuilder constructor.
     */
    function __construct()
    {
        $this->productRepository = new ProductRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->attributeRepository = new AttributeRepository();
        $this->brandRepository = new BrandRepository();
    }

    /**
     * @param string $url
     * @return array
     */
    public function getData(string $url): array
    {
        $category = Category::where('url', $url)->first();
        $products = Product::where('category_id', $category->id)->where('active', true)->orderBy('name')->get();

        $subcategories = $this->categoryRepository->getSubcategoriesArr($category);


        $list = $this->productRepository->getProductSubcatListByCategory($category);
        $attributes = $this->productRepository->getProductAttributesListByCategory($category);

        $products = $this->productRepository->productsToArray($products, $list, $attributes);

        $attributes = $this->attributeRepository->getCategoryInfo($category);
        $brands = $this->brandRepository->getBrandsInfo($category);

        $attributesList = $this->attributeRepository->getIdNameArr();

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