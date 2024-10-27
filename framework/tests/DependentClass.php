<?php

namespace ChidoUkaigwe\Framework\Tests;

use ChidoUkaigwe\Framework\Tests\DependencyClass;

class DependentClass 
{
    public function __construct(private DependencyClass $dependency)
    {
        
    }

    /**
     * Get the value of dependency
     */ 
    public function getDependency()
    {
        return $this->dependency;
    }
}