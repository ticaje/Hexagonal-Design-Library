<?php
declare(strict_types=1);

/**
 * Test Suite Class
 * @author Max Demian <ticaje@filetea.me>
 */

namespace Ticaje\Hexagonal\Test\Unit\Traits;

use ReflectionClass;

/**
 * Trait DtoTestTrait
 * @package Ticaje\Hexagonal\Test\Unit\Traits
 */
trait DtoTestTrait
{
    /** @var ReflectionClass $reflection */
    protected $reflection;

    public function setUp()
    {
        parent::setUp();
        $this->reflection = new ReflectionClass($this->instance);
    }

    public function testAttributes()
    {
        ($formalAttributes = function () {
            foreach ($this->attributes as $attribute) {
                $this->assertObjectHasAttribute($attribute, $this->instance);
            }
        })();

        ($actualParameters = function () {
            $properties = $this->reflection->getProperties();
            $this->assertEquals(count($this->attributes), count($properties), 'Assert exact amount of properties');
            $this->assertEquals($this->propertiesNumber, count(get_class_methods($this->instance)), 'Assert proper amount of public/api methods');
        })();
    }
}
