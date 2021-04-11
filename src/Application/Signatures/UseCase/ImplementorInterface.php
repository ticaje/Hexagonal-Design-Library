<?php
declare(strict_types=1);
/**
 * Application Use Case Class
 * @author Max Demian <ticaje@filetea.me>
 */

namespace Ticaje\Hexagonal\Application\Signatures\UseCase;

/**
 * Interface ImplementorInterface
 * @package Ticaje\Hexagonal\Application\Signatures\UseCase
 * This interface uses Hexagonal approach since any concretion can be passed along via composition to modules
 * using this pattern.
 */
interface ImplementorInterface
{
    /**
     * @param array $machinery
     *
     * @return mixed
     */
    public function provide(array $machinery);
}
