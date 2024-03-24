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
use League\Tactician\CommandBus;

/**
 * Class Bus
 * @package Ticaje\Hexagonal\Application\UseCase\Bus
 * This is the wrapper, the facade to our API that exposes service contract to modules using Command-Bus approach under a Hexagonal context.
 */
class Bus implements BusFacadeInterface
{
    /** @var ImplementorInterface */
    private ImplementorInterface $implementor;

    /** @var array $commands */
    private array $commands;

    /** @var array $handlers */
    private array $handlers;

    /** @var ?CommandBus $bus */
    private ?CommandBus $bus;

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
        $this->bus = $this->implementor->provide($this->orchestrate());
    }

    /**
     * @inheritDoc
     */
    public function execute(UseCaseCommandInterface $command): ResponseInterface
    {
        return $this->bus->handle($command);
    }

    /**
     * @return array
     * Orchestrating service contract, no virtual types allowed
     */
    private function orchestrate(): array
    {
        $result = [];
        foreach ($this->commands as $index => $command) {
            $result[get_class($command)] = $this->handlers[$index];
        }

        return $result;
    }
}
