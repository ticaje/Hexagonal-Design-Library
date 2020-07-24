<?php
declare(strict_types=1);

/**
 * Test Suite Class
 * @author Max Demian <ticaje@filetea.me>
 */

namespace Ticaje\Hexagonal\Test\Unit\Responder;

use Ticaje\Hexagonal\Test\Unit\BaseTest;

use Ticaje\Hexagonal\Application\Implementors\Responder\Response;
use Ticaje\Hexagonal\Application\Signatures\Responder\ResponseInterface;
use Ticaje\Hexagonal\Test\Unit\Traits\DtoTestTrait;

/**
 * Class ResponseTest
 * @package Ticaje\Hexagonal\Test\Unit\Responder
 */
class ResponseTest extends BaseTest
{
    use DtoTestTrait;

    protected $class = Response::class;

    protected $interface = ResponseInterface::class;

    protected $attributes = ['success', 'message', 'content'];

    protected $propertiesNumber = 6;
}
