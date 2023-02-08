<?php

declare(strict_types=1);

namespace App\WebhookContext\Infrastructure\Delivery\Rest\Webhook;

use App\Shared\Infrastructure\Delivery\Rest\ApiCommandPage;
use App\WebhookContext\Application\Comand\SetWebhook\SetWebhookCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SetWebhookPage extends ApiCommandPage
{
    /** @throws \Throwable */
    public function __invoke(Request $request): JsonResponse
    {
        $webhook = $request->request->get('url');

        $this->dispatch(
            new SetWebhookCommand($webhook)
        );

        return new JsonResponse([], Response::HTTP_OK);
    }
}
