<?php
declare(strict_types=1);
/**
 * Application Use Case Class
 * @author Ticaje <ticaje@filetea.me>
 */

namespace Ticaje\Hexagonal\Application\UseCase\Bus;

use Ticaje\Hexagonal\Application\Signatures\Responder\ResponseInterface;
use Ticaje\Hexagonal\Application\Signatures\UseCase\BusFacadeInterface;
use Ticaje\Hexagonal\Application\Signatures\UseCase\ImplementorInterface;
use Ticaje\Hexagonal\Application\Signatures\UseCase\UseCaseCommandInterface;

class BusOrchrestator implements BusFacadeInterface
{
    /** @var ImplementorInterface */
    private $implementor;

    /**
     * Bus constructor.
     *
     * @param ImplementorInterface $implementor
     */
    public function __construct(
        ImplementorInterface $implementor
    ) {
        $this->implementor = $implementor;
    }

    /**
     * @inheritDoc
     */
    public function execute(UseCaseCommandInterface $command): ResponseInterface
    {
        $bus = $this->implementor->provide([]);

        return $bus->handle($command);
    }
}
