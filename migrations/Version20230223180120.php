<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230223180120 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Added last chapter to series';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE manga_content_context.series ADD last_chapter INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE manga_content_context.series DROP last_chapter');
    }
}
