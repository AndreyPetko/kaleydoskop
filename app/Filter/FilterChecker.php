<?php

namespace App\Filter;


/**
 * Class FilterChecker
 * @package App\Filter
 */
class FilterChecker
{
    /**
     * @var
     */
    private $builders;


    /**
     * @param FilterBuilderInterface $builder
     * @param string $type
     */
    public function addBuilder(FilterBuilderInterface $builder, string $type)
    {
        $this->builders[$type] = $builder;
    }

    /**
     * @param string $type
     * @return mixed
     */
    public function getBuilder(string $type)
    {
        return $this->builders[$type];
    }
}