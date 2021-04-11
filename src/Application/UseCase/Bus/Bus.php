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

/**
 * Class Bus
 * @package Ticaje\Hexagonal\Application\UseCase\Bus
 * This is the wrapper, the facade to our API that exposes service contract to modules using Command-Bus approach under a Hexagonal context.
 */
class Bus implements BusFacadeInterface
{
    /** @var ImplementorInterface */
    private $implementor;

    /** @var array $commands */
    private $commands;

    /** @var array $handlers */
    private $handlers;

    /**
     * Bus constructor.
     *
     * @param array                $commands
     * @param array                $handlers
     * @param ImplementorInterface $implementor
     */
    public function __construct(
        array $commands,
        array $handlers,
        ImplementorInterface $implementor
    ) {
        $this->commands = $commands;
        $this->handlers = $handlers;
        $this->implementor = $implementor;
    }

    /**
     * @inheritDoc
     */
    public function execute(UseCaseCommandInterface $command): ResponseInterface
    {
        $bus = $this->implementor->provide($this->orchestrate());
        return $bus->handle($command);
    }

    /**
     * @return array
     * Orchestrating service contract, no virtual types allowed
     */
    private function orchestrate()
    {
        $result = [];
        foreach ($this->commands as $index => $command) {
            $result[get_class($command)] = $this->handlers[$index];
        }

        return $result;
    }
}
