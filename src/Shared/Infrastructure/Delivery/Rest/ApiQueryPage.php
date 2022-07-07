<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Delivery\Rest;

use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Throwable;
use App\Shared\Application\Query\Query;

abstract class ApiQueryPage
{
    use HandleTrait;

    public function __construct(MessageBusInterface $queryBus)
    {
        $this->messageBus = $queryBus;
    }

    /** @throws Throwable */
    protected function ask(Query $message): mixed
    {
        try {
            return $this->handle($message);
        } catch (NoHandlerForMessageException) {
            throw QueryNotRegisteredException::from($message);
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
