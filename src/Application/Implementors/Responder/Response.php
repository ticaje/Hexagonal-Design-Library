<?php
declare(strict_types=1);

/**
 * Application Use Case Class
 * @author Max Demian <ticaje@filetea.me>
 */

namespace Ticaje\Hexagonal\Application\Implementors\Responder;

use Ticaje\Hexagonal\Application\Signatures\Responder\ResponseInterface;

/**
 * Class Response
 * @package Ticaje\Hexagonal\Application\Implementors\Responder
 */
class Response implements ResponseInterface
{
    private $success = true;

    private $message = '';

    private $content = null;

    /**
     * @return mixed
     */
    public function getSuccess():bool
    {
        return $this->success;
    }

    /**
     * @param mixed $success
     * @return Response
     */
    public function setSuccess(bool $success): ResponseInterface
    {
        $this->success = $success;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage():string
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     * @return Response
     */
    public function setMessage(string $message): ResponseInterface
    {
        $this->message = $message;
        return $this;
    }

    public function setContent($content): ResponseInterface
    {
        $this->content = $content;
        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }
}
