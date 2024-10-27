<?php
namespace ChidoUkaigwe\Framework\Tests;

class DependencyClass
{
    public function __construct(private SubDependencyClass $subDependency)
    {
        
    }

    /**
     * Get the value of subDependency
     */ 
    public function getSubDependency()
    {
        return $this->subDependency;
    }
}