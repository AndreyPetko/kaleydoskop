<?php

namespace App\Filter;

use App\Brend;
use App\Product;
use App\Repository\AttributeRepository;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Mockery\Exception;


/**
 * Class BrendFilterBuilder
 * @package App\Filter
 */
class BrendFilterBuilder implements FilterBuilderInterface
{
    /**
     *
     */
    const SLUG = 'brend';

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var AttributeRepository
     */
    private $attributeRepository;
    /**
     * @var BrandRepository
     */
    private $brandRepository;

    /**
     * BrendFilterBuilder constructor.
     */
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

        if(!$brand) {
            throw new Exception('Такого бренда не существует');
        }

        $products = Product::where('brend_id', $brand->id)->where('active', true)->orderBy('name')->get();

        $list = $this->productRepository->getProductSubcatListByBrand($brand);

        $subcategories = $this->categoryRepository->getBrandSubcategories($list);

        $attributes = $this->productRepository->getProductAttributesListByBrand($brand);

        $products = $this->productRepository->productsToArray($products, $list, $attributes);

        $attributes = $this->attributeRepository->getBrandInfo($brand);
        $brands = [];

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