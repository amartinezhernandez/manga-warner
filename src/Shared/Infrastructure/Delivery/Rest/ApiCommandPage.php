<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Delivery\Rest;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;
use App\Shared\Application\Command\Command;

abstract class ApiCommandPage
{
    use HandleTrait;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->messageBus = $commandBus;
    }

    /** @throws Throwable */
    protected function dispatch(Command $message): mixed
    {
        try {
            return $this->handle($message);
        } catch (NoHandlerForMessageException) {
            throw CommandNotRegisteredException::from($message);
        } catch (HandlerFailedException $e) {
            throw $this->raiseException($e);
        }
    }

    protected function raiseException(Throwable $e): Throwable
    {
        while ($e instanceof HandlerFailedException) {
            $e = $e->getPrevious();
            \assert($e instanceof Throwable);
        }

        return $e;
    }
}
