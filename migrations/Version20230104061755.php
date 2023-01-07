<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230104061755 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE playlist_single (playlist_id INT NOT NULL, single_id INT NOT NULL, INDEX IDX_25D12B2A6BBD148 (playlist_id), INDEX IDX_25D12B2AE7C1D92B (single_id), PRIMARY KEY(playlist_id, single_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE playlist_single ADD CONSTRAINT FK_25D12B2A6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE playlist_single ADD CONSTRAINT FK_25D12B2AE7C1D92B FOREIGN KEY (single_id) REFERENCES single (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE playlist_single DROP FOREIGN KEY FK_25D12B2A6BBD148');
        $this->addSql('ALTER TABLE playlist_single DROP FOREIGN KEY FK_25D12B2AE7C1D92B');
        $this->addSql('DROP TABLE playlist_single');
    }
}
