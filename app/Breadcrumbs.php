<?php

namespace App;

use App\BreadcrumbsClasses\CategoryBreadcrumbs;
use App\BreadcrumbsClasses\ProductBreadcrumbs;

/**
 * Class Breadcrumbs
 * @package App
 */
abstract class Breadcrumbs {

    /**
     * @param $type
     * @return CategoryBreadcrumbs|ProductBreadcrumbs
     */
    public static function getInstance($type) {
		if($type === 'product') {
			return new ProductBreadcrumbs();
		}
		if($type === 'category') {
			return new CategoryBreadcrumbs();
		}
	}


    /**
     * @param $url
     * @param $word
     */
    public function addParam($url, $word) {
		$this->params[$url] = $word;
	}

    /**
     * @param $params
     * @return mixed
     */
    abstract function generate($params);

}