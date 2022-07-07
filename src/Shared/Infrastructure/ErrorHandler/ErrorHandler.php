<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\ErrorHandler;

use Assert\Assert;
use Assert\AssertionFailedException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\OptimisticLockException;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Throwable;
use App\Shared\Domain\ClassFunctions;
use App\Shared\Domain\DomainException;
use App\Shared\Domain\Exception\Http\BadRequestException;
use App\Shared\Domain\Exception\Http\ConflictException;
use App\Shared\Domain\Exception\Http\NotFoundException;
use App\Shared\Domain\Exception\Http\UnprocessableEntityException;

/** @see https://datatracker.ietf.org/doc/html/rfc7807 */
final class ErrorHandler
{
    private const DEFAULT_STATUS = Response::HTTP_INTERNAL_SERVER_ERROR;
    private const DEFAULT_TITLE = 'UNKNOWN_ERROR';
    private const BASE_PROBLEM_TYPE_URI = 'https://documentation.whalar.com/errors#';

    /** @var array<string, int> */
    private array $exceptions = [
        NotFoundHttpException::class => Response::HTTP_NOT_FOUND,
        Assert::class => Response::HTTP_UNPROCESSABLE_ENTITY,
        AssertionFailedException::class => Response::HTTP_UNPROCESSABLE_ENTITY,
        NotFoundException::class => Response::HTTP_NOT_FOUND,
        UnprocessableEntityException::class => Response::HTTP_UNPROCESSABLE_ENTITY,
        BadRequestException::class => Response::HTTP_BAD_REQUEST,
        ConflictException::class => Response::HTTP_CONFLICT,
        OptimisticLockException::class => Response::HTTP_CONFLICT,
        ResourceNotFoundException::class => Response::HTTP_NOT_FOUND,
        UniqueConstraintViolationException::class => Response::HTTP_CONFLICT,
    ];

    /** @throws InvalidArgumentException */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $httpStatusCode = $this->httpStatusCodeFor($exception);

        $event->setResponse(new JsonResponse(
            [
                'status' => "${httpStatusCode}",
                'title' => $this->titleFor($exception),
                'detail' => $this->detailFor($exception),
                'type' => $this->typeFor($exception),
                'code' => $this->codeFor($exception),
            ],
            $httpStatusCode,
        ));
    }

    private function httpStatusCodeFor(Throwable $exception): int
    {
        if ($exception instanceof HttpExceptionInterface) {
            return $exception->getStatusCode();
        }

        foreach ($this->exceptions as $key => $value) {
            if (!($exception instanceof $key)) {
                continue;
            }

            return $value;
        }

        return self::DEFAULT_STATUS;
    }

    private function titleFor(Throwable $exception): string
    {
        if ($exception instanceof DomainException) {
            return strtoupper($exception->code());
        }

        if ($exception instanceof \Assert\InvalidArgumentException) {
            return 'BAD_REQUEST';
        }

        return self::DEFAULT_TITLE;
    }

    private function detailFor(Throwable $exception): string
    {
        if ($exception instanceof DomainException) {
            return $exception->detail();
        }

        return $exception->getMessage();
    }

    private function typeFor(Throwable $exception): string
    {
        return self::BASE_PROBLEM_TYPE_URI.$this->codeFor($exception);
    }

    private function codeFor(Throwable $exception): string
    {
        if ($exception instanceof DomainException) {
            return $exception->code();
        }

        return str_replace('_exception', '', ClassFunctions::toSnakeCase(ClassFunctions::extractClassName($exception)));
    }
}
