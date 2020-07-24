<?php
declare(strict_types=1);

/**
 * Application Use Case Class
 * @author Max Demian <ticaje@filetea.me>
 */

namespace Ticaje\Hexagonal\Application\Signatures\Responder;

/**
 * Interface ResponseInterface
 * @package Ticaje\Hexagonal\Application\Signatures\Responder
 */
interface ResponseInterface
{
    /**
     * @param bool $success
     * @return ResponseInterface
     */
    public function setSuccess(bool $success): ResponseInterface;

    /**
     * @param string $message
     * @return ResponseInterface
     */
    public function setMessage(string $message): ResponseInterface;

    /**
     * @param $content
     * @return ResponseInterface
     */
    public function setContent($content): ResponseInterface;

    /**
     * @return bool
     */
    public function getSuccess():bool;

    /**
     * @return string
     */
    public function getMessage():string;

    /**
     * @return mixed
     */
    public function getContent();
}
