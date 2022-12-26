<?php
declare(strict_types=1);
/**
 * Application Use Case Class
 * @author Ticaje <ticaje@filetea.me>
 */

namespace Ticaje\Hexagonal\Application\UseCase\Bus\Decorator;

use Ticaje\Hexagonal\Application\Signatures\Responder\ResponseInterface;
use Ticaje\Hexagonal\Application\Signatures\UseCase\BusFacadeInterface;
use Ticaje\Hexagonal\Application\Signatures\UseCase\ImplementorInterface;
use Ticaje\Hexagonal\Application\Signatures\UseCase\UseCaseCommandInterface;

/**
 * Class ProxyBus
 * @package Ticaje\Hexagonal\Application\UseCase\Bus\Decorator
 */
class ProxyBus implements BusFacadeInterface
{
    /** @var ImplementorInterface [] */
    private $providers;

    /**
     * Bus constructor.
     *
     * @param array $providers
     */
    public function __construct(
        array $providers
    ) {
        $this->providers = $providers;
    }

    /**
     * @inheritDoc
     */
    public function execute(UseCaseCommandInterface $command): ?ResponseInterface
    {
        if (!isset($this->providers[get_class($command)])) {
            throw new \InvalidArgumentException('There are no commands assigned to this Handler');
        }
        $provider = $this->providers[get_class($command)];
        $bus = $provider->provide([]);
        if (!$bus) {
            throw new \Exception('Bus not found');
        }

        return $bus->handle($command);
    }
}
