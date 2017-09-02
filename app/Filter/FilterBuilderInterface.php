<?php

namespace App\Filter;


/**
 * Interface FilterBuilderInterface
 * @package App\Filter
 */
interface FilterBuilderInterface
{

    /**
     * @param string $url
     * @return array
     */
    public function getData(string $url) : array;
}