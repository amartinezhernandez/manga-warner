<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Service\Feed;

use App\MangaContentContext\Domain\Aggregate\Website;

final class RssFeedService
{
    /**
     * @param Website $website
     * @return array<array{title: string, link: string, chapter:integer, date: string}>
     */
    public function scan(Website $website): array
    {
        // Hack to work around 403 errors
        $context  = stream_context_create(array('http' => array('header' => 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.110 Safari/537.36')));

        $feed = file_get_contents($website->feedUrl(), false, $context);
        $feedElements = simplexml_load_string($feed);

        $feedItems = [];
        foreach ($feedElements->channel->item as $element) {
            $feedItems[] = [
                'title' => (string) $element->title,
                'link' => (string) $element->link,
                'chapter' => $this->findChapter((string) $element->title),
                'date' => date('c', strtotime((string) $element->pubDate))
            ];
        }

        return $feedItems;
    }

    private function findChapter(string $title): int
    {
        $mod = strstr(strtolower($title), 'chapter ');
        $chapter = 0;

        if (false !== $mod) {
            $data = substr($mod, strlen('chapter '));
            $chapter = explode(' ', $data);
            $chapter = reset($chapter);
        }


        return (int) $chapter;
    }
}