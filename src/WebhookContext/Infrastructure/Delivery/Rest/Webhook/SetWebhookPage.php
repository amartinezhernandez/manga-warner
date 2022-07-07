<?php

declare(strict_types=1);

namespace App\WebhookContext\Infrastructure\Delivery\Rest\Webhook;

use App\Shared\Infrastructure\Delivery\Rest\ApiCommandPage;
use App\WebhookContext\Infrastructure\Telegram\Client\TelegramWebhookClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class SetWebhookPage extends ApiCommandPage
{
    public function __construct(MessageBusInterface $commandBus, private readonly TelegramWebhookClient $client)
    {
        parent::__construct($commandBus);
    }

    public function __invoke(Request $request): JsonResponse
    {
        $webhook = $request->request->get('url');
        $success = $this->client->setWebhook($webhook);
        if ($success) {
            return new JsonResponse(['success' => true], Response::HTTP_OK);
        }

        return new JsonResponse([], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
