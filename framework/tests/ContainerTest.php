<?php

namespace ChidoUkaigwe\Framework\Tests;

use ChidoUkaigwe\Framework\Container\Container;
use ChidoUkaigwe\Framework\Container\ContainerException;
use PHPUnit\Framework\TestCase;
use ChidoUkaigwe\Framework\Tests\DependentClass;

class ContainerTest extends TestCase
{
     /** @test */
    public function test_can_check_if_the_container_has_a_service()
    {   
        //  Setup
        $container = new Container();
        //  Do Something 
        $container->add('dependent-class', DependentClass::class);
        //  Make Assertions
        $this->assertTrue($container->has('dependent-class'));
        $this->assertFalse($container->has('non-existent-class'));

    }

    /** @test */
    public function test_a_service_can_be_retrieved_from_the_container()
    {
        // Setup
        $container = new Container();
        // Do something 
        // id of service (string) + concreate class to obtain from service container
        $container->add('dependent-class', DependentClass::class );
        //  Make assertions
        $this->assertInstanceOf(DependentClass::class, $container->get('dependent-class'));
    }

    /** @test */
    public function test_a_ContainerException_is_thrown_if_a_service_cannot_be_found()
    {
        //  Setup
        $container = new Container();
        //  Expect Exception
        $this->expectException(ContainerException::class);
        // Do Something 
        $container->add('foobar');
    }

       /** @test */
       public function test_services_can_be_recursively_autowired()
       {
        $container = new Container();
        
        $dependentService = $container->get(DependentClass::class);
        $dependencyService = $dependentService->getDependency();

        $this->assertInstanceOf(DependencyClass::class, $dependentService->getDependency());
        $this->assertInstanceOf(SubDependencyClass::class, $dependencyService->getSubDependency());
       }

}