<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
final class Version20230223174834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created subscription table. Removed series image.';
    }
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE manga_content_context.subscription (id UUID NOT NULL, series_id VARCHAR(255) NOT NULL, chat_id TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN manga_content_context.subscription.id IS \'(DC2Type:aggregate_id)\'');
        $this->addSql('ALTER TABLE manga_content_context.series DROP image');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE manga_content_context.subscription');
        $this->addSql('ALTER TABLE manga_content_context.series ADD image TEXT DEFAULT NULL');
    }
}
