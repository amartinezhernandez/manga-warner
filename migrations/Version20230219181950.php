<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230219181950 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates website table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SCHEMA manga_content_context');
        $this->addSql('CREATE TABLE manga_content_context.website (id UUID NOT NULL, name VARCHAR(255) NOT NULL, feed_url TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN manga_content_context.website.id IS \'(DC2Type:aggregate_id)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE manga_content_context.website');
    }
}
