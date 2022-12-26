<?php
declare(strict_types=1);

/**
 * Application Use Case Class
 * @author Max Demian <ticaje@filetea.me>
 */

namespace Ticaje\Hexagonal\Application\Signatures\UseCase;

use Ticaje\Hexagonal\Application\Signatures\Responder\ResponseInterface;

/**
 * Interface BusFacadeInterface
 * @package Ticaje\Hexagonal\Application\Signatures\UseCase
 */
interface BusFacadeInterface
{
    /**
     * @param UseCaseCommandInterface $command
     * @return ResponseInterface
     */
    public function execute(UseCaseCommandInterface $command): ?ResponseInterface;
}
