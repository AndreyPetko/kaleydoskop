<?php

namespace App\BreadcrumbsClasses;
use App\Breadcrumbs;
use App\Subcategory;
use DB;

/**
 * Class ProductBreadcrumbs
 * @package App\BreadcrumbsClasses
 */
class ProductBreadcrumbs extends Breadcrumbs {

    /**
     * @param $product
     * @return mixed
     */
    function generate($product) {
		if($product->category_id) {
			$category = DB::table('categories')->where('id', $product->category_id)->first();
			$this->addParam('/category/' . $category->url, $category->name);
		}

		$subcatId = DB::table('product_subcat')->where('product_id', $product->id)->value('subcat_id');

		if($subcatId) {
			$subcategory = Subcategory::find($subcatId);
			$this->addParam('/subcategory/' . $subcategory->url, $subcategory->name);
		}

		$this->addParam('/product/' . $product->url, $product->name);

		return $this->params;
	}
}