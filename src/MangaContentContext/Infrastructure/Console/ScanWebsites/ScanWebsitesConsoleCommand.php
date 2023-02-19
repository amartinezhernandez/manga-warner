<?php

declare(strict_types=1);

namespace App\MangaContent\Infrastructure\Console\ScanWebsites;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ScanWebsitesConsoleCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('scan:websites');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {

    }
}