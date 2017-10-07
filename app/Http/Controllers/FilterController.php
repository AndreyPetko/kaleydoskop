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
use Illuminate\Http\Response;


/**
 * Class FilterController
 * @package App\Http\Controllers
 */
class FilterController extends Controller
{
    /**
     * @param string $url
     * @param string $type
     * @return string
     */
    public function getCategoryData(string $url, string $type)
    {
        $filterChecker = new FilterChecker();
        $filterChecker->addBuilder(new BrendFilterBuilder(), BrendFilterBuilder::SLUG);
        $filterChecker->addBuilder(new CategoryFilterBuilder(), CategoryFilterBuilder::SLUG);

        $builder = $filterChecker->getBuilder($type);

        try {
            return $builder->getData($url);
        } catch (\Exception $e) {
            return Response::create($e->getMessage(), 500);
        }
    }
}