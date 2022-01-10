<?php
declare(strict_types=1);
/**
 * Application Use Case Class
 * @author Ticaje <ticaje@filetea.me>
 */

namespace Ticaje\Hexagonal\Application\Implementors\UseCase\Bus;

use League\Tactician\CommandBus;
use Ticaje\Hexagonal\Application\Signatures\UseCase\ImplementorInterface;

class TacticianMiddleWare implements ImplementorInterface
{
    /** @var array $recipes */
    private $recipes;

    /**
     * TacticianMiddleWare constructor.
     *
     * @param array $recipes
     */
    public function __construct(
        array $recipes
    ) {
        $this->recipes = $recipes;
    }

    /**
     * @inheritDoc
     */
    public function provide(array $machinery)
    {
        $result = new CommandBus($this->recipes);

        return $result;
    }
}
