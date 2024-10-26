<?php

namespace ChidoUkaigwe\Framework\Tests;

use ChidoUkaigwe\Framework\Container\Container;
use PHPUnit\Framework\TestCase;
use ChidoUkaigwe\Framework\Tests\DependentClass;

class ContainerTest extends TestCase
{
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

}