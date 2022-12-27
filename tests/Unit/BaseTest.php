<?php
declare(strict_types=1);

/**
 * Test Suite Class
 * @author Max Demian <ticaje@filetea.me>
 */

namespace Ticaje\Hexagonal\Test\Unit;

use PHPUnit\Framework\TestCase as ParentClass;

/**
 * Class BaseTest
 * @package Ticaje\Hexagonal\Test\Unit
 */
abstract class BaseTest extends ParentClass
{
    protected $class;

    protected $instance;

    protected $interface;

    public function setUp(): void
    {
        $this->instance = new $this->class();
    }

    public function testProperInstance()
    {
        $this->assertInstanceOf($this->interface, $this->instance);
    }

    public function testProofOfLife()
    {
        $this->assertTrue(true);
    }
}
