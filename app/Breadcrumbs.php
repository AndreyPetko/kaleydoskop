<?php

namespace App;

abstract class Breadcrumbs {

	public static function getInstance($type) {
		if($type == 'product') {
			return new \App\BreadcrumbsClasses\ProductBreadcrumbs();
		}
		if($type == 'category') {
			return new \App\BreadcrumbsClasses\CategoryBreadcrumbs();
		}
	}


	public function addParam($url, $word) {
		$this->params[$url] = $word;
	}

	abstract function generate($params);

}