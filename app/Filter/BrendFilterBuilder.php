<?php

namespace App\Filter;

use App\Brend;
use App\Product;
use App\Repository\AttributeRepository;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;


/**
 * Class BrendFilterBuilder
 * @package App\Filter
 */
class BrendFilterBuilder implements FilterBuilderInterface
{
    const SLUG = 'brend';

    private $categoryRepository;
    private $productRepository;
    private $attributeRepository;
    private $brandRepository;

    public function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
        $this->productRepository = new ProductRepository();
        $this->attributeRepository = new AttributeRepository();
        $this->brandRepository = new BrandRepository();
    }

    /**
     * @param string $url
     * @return array
     */
    public function getData(string $url): array
    {
        $brand = Brend::where('url', $url)->first();
        $products = Product::where('brend_id', $brend->id)->where('active', true)->orderBy('name')->get();

        $subcategories = $this->categoryRepository->getSubcategoriesArr($brand);
        $products = $this->productRepository->productsToArrayBrand($products, $brand);

        $attributes = $this->attributeRepository->getBrandInfo($brand);
        $brands = $this->brandRepository->getBrandsInfo($category);

        $attributesList = $this->attributeRepository->getIdNameArr();

        return [
            'name' => $brand->name,
            'products' => $products,
            'attributes' => $attributes,
            'subcategories' => $subcategories,
            'attributesList' => $attributesList,
            'brands' => $brands
        ];
    }
}