<?php
declare(strict_types=1);

/**
 * Application Use Case Class
 * @author Max Demian <ticaje@filetea.me>
 */

namespace Ticaje\Hexagonal\Application\Signatures\UseCase;

use Ticaje\Hexagonal\Application\Signatures\Responder\ResponseInterface;

/**
 * Interface HandlerInterface
 * @package Ticaje\Hexagonal\Application\Signatures\UseCase
 */
interface HandlerInterface
{
    /**
     * @param UseCaseCommandInterface $command
     * @return ResponseInterface
     */
    public function handle(UseCaseCommandInterface $command): ResponseInterface;
}
