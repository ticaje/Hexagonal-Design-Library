<?php
declare(strict_types=1);
/**
 * Application Use Case Class
 * @author Ticaje <ticaje@filetea.me>
 */

namespace Ticaje\Hexagonal\Application\Implementors\UseCase\Bus;

use League\Tactician\CommandBus;
use League\Tactician\Setup\QuickStart as BusBootstrapper;
use Ticaje\Hexagonal\Application\Signatures\UseCase\ImplementorInterface;

/**
 * Class Tactician
 * @package Ticaje\Hexagonal\Application\Implementors\UseCase\Bus
 * This is specific bus implementation, in this case it use Tactician agency implementation.
 */
class Tactician implements ImplementorInterface
{
    /**
     * @inheritDoc
     */
    public function provide(array $machinery)
    {
        /** @var CommandBus $result */
        $result = BusBootstrapper::create($machinery);

        return $result;
    }
}
