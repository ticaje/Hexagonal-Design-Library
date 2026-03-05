<?php
declare(strict_types=1);
/**
 * Application Use Case Class
 * @author Ticaje <ticaje@filetea.me>
 */

namespace Ticaje\Hexagonal\Application\UseCase\Bus;

use League\Tactician\CommandBus;
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
            if (!array_key_exists($index, $this->handlers)) {
                throw new \InvalidArgumentException(
                    sprintf('No handler configured for command key "%s".', (string) $index)
                );
            }

            $commandClass = $this->resolveCommandClass($command);
            $result[$commandClass] = $this->handlers[$index];
        }

        return $result;
    }

    /**
     * Resolves command class name from object instance or class-string.
     *
     * @param mixed $command
     * @return string
     */
    private function resolveCommandClass(mixed $command): string
    {
        if (is_object($command)) {
            if (!$command instanceof UseCaseCommandInterface) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Configured command object "%s" must implement %s.',
                        $command::class,
                        UseCaseCommandInterface::class
                    )
                );
            }

            return $command::class;
        }

        if (is_string($command)) {
            $commandClass = ltrim($command, '\\');

            if (!class_exists($commandClass)) {
                throw new \InvalidArgumentException(
                    sprintf('Configured command class "%s" does not exist.', $commandClass)
                );
            }

            if (!is_subclass_of($commandClass, UseCaseCommandInterface::class)) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Configured command class "%s" must implement %s.',
                        $commandClass,
                        UseCaseCommandInterface::class
                    )
                );
            }

            return $commandClass;
        }

        throw new \InvalidArgumentException(
            sprintf(
                'Command mapping entries must be object|string, "%s" given.',
                get_debug_type($command)
            )
        );
    }
}
