<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230219191210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates series table';
    }
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE manga_content_context.series (id UUID NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, image TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN manga_content_context.series.id IS \'(DC2Type:aggregate_id)\'');
    }
    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE manga_content_context.series');
    }
}
