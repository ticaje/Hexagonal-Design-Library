<?php
declare(strict_types=1);
/**
 * Test Suite Class
 * @author Max Demian <ticaje@filetea.me>
 */

namespace Ticaje\Hexagonal\Test\Unit\Responder;

use Ticaje\Hexagonal\Application\Implementors\Responder\Response;
use Ticaje\Hexagonal\Application\Signatures\Responder\ResponseInterface;
use Ticaje\Hexagonal\Application\Signatures\UseCase\BusFacadeInterface;
use Ticaje\Hexagonal\Application\Signatures\UseCase\ImplementorInterface;
use Ticaje\Hexagonal\Application\Signatures\UseCase\UseCaseCommandInterface;
use Ticaje\Hexagonal\Application\UseCase\Bus\Bus;
use Ticaje\Hexagonal\Test\Unit\BaseTest;

/**
 * Class BusTest
 * @package Ticaje\Hexagonal\Test\Unit\Responder
 */
class BusTest extends BaseTest
{
    /** @var ImplementorInterface */
    private $implementor;

    /** @var string  */
    private $implementorInterface = ImplementorInterface::class;

    /** @var string  */
    protected $class = Bus::class;

    /** @var string  */
    protected $interface = BusFacadeInterface::class;

    /** @var array */
    protected $attributes = [
        'implementor',
        'commands',
        'handlers',
    ];

    /** @var int */
    protected $propertiesNumber = 6;

    public function setUp()
    {
        $this->implementor = $this->createMock($this->implementorInterface);
        $this->instance = $this->getMockBuilder($this->class)
            ->setConstructorArgs([
                'commands'    => [],
                'handlers'    => [],
                'implementor' => $this->implementor,
            ])
            ->setMethods([
                'execute',
            ])
            ->getMock();
    }

    public function testExecuteWithWrongParameter()
    {
        $invalidArgument = [];
        $pattern = '/must implement interface .*UseCaseCommandInterface/';
        $this->expectExceptionMessageRegExp($pattern, 'Expect proper error when wrong parameter passed along');
        $this->instance->execute($invalidArgument);
    }

    public function testExecuteWithProperParameter()
    {
        $response = (new Response())->setSuccess(false);
        $validArgument = new MyCommand();
        $this->instance->method('execute')
            ->willReturn($response);
        /** @var Response $result */
        $result = $this->instance->execute($validArgument);
        $this->assertInstanceOf(ResponseInterface::class, $result, 'always return an instance of ResponseInterface');
        $this->assertEquals(0, $result->getSuccess(), 'Since no concretion is passed along responder must return not success');
    }
}

/**
 * Class MyCommand
 * @package Ticaje\Hexagonal\Test\Unit\Responder
 * Dummy command for testing purposes
 */
class MyCommand implements UseCaseCommandInterface
{
}
