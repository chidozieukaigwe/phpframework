<?php
namespace ChidoUkaigwe\Framework\Tests;

use ChidoUkaigwe\Framework\Session\Session;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{

    protected function setUp(): void
    {
        unset($_SESSION);
    }

    /** @test */
    public function testSetAndGetFlash(): void
    {
        $session = new Session();
        $session->setFlash('success', 'Great Job');
        $session->setFlash('error', 'Oops');
        $this->assertTrue($session->hasFlash('success'));
        $this->assertTrue($session->hasFlash('error'));
        $this->assertEquals(['Great Job'], $session->getFlash('success'));
        $this->assertEquals(['Oops'], $session->getFlash('error'));
        $this->assertEquals([], $session->getFlash('warning'));

    }
    
}