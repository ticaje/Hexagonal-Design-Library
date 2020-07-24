<?php
declare(strict_types=1);

/**
 * Application Use Case Class
 * @author Ticaje <ticaje@filetea.me>
 */

namespace Ticaje\Hexagonal\Application\UseCase\Bus;

use League\Tactician\CommandBus;
use League\Tactician\Setup\QuickStart as BusBootstrapper;

use Ticaje\Hexagonal\Application\Signatures\Responder\ResponseInterface;
use Ticaje\Hexagonal\Application\Signatures\UseCase\BusFacadeInterface;
use Ticaje\Hexagonal\Application\Signatures\UseCase\UseCaseCommandInterface;

/**
 * Class Bus
 * @package Ticaje\Hexagonal\Application\UseCase\Bus
 */
class Bus implements BusFacadeInterface
{
    /** @var CommandBus $bus */
    private $bus;

    /** @var array $commands */
    private $commands;

    /** @var array $handlers */
    private $handlers;

    /**
     * Bus constructor.
     * @param array $commands
     * @param array $handlers
     * I will define business deps by means DC.
     */
    public function __construct(
        array $commands,
        array $handlers
    ) {
        $this->commands = $commands;
        $this->handlers = $handlers;
        $this->bus = BusBootstrapper::create($this->orchestrate());
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
    private function orchestrate()
    {
        $result = [];
        foreach ($this->commands as $index => $command) {
            $result[get_class($command)] = $this->handlers[$index];
        }
        return $result;
    }
}
