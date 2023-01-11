<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230111155609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nom VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, prix DOUBLE PRECISION DEFAULT NULL, INDEX IDX_39986E43A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nom_playlist VARCHAR(255) NOT NULL, image_playlist VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, INDEX IDX_D782112DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist_single (playlist_id INT NOT NULL, single_id INT NOT NULL, INDEX IDX_25D12B2A6BBD148 (playlist_id), INDEX IDX_25D12B2AE7C1D92B (single_id), PRIMARY KEY(playlist_id, single_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, pseudo VARCHAR(30) DEFAULT NULL, nbre_followers INT DEFAULT NULL, certified TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E43A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE playlist ADD CONSTRAINT FK_D782112DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE playlist_single ADD CONSTRAINT FK_25D12B2A6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE playlist_single ADD CONSTRAINT FK_25D12B2AE7C1D92B FOREIGN KEY (single_id) REFERENCES single (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE single ADD album_id INT DEFAULT NULL, ADD user_id INT NOT NULL, ADD genre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE single ADD CONSTRAINT FK_CAA727191137ABCF FOREIGN KEY (album_id) REFERENCES album (id)');
        $this->addSql('ALTER TABLE single ADD CONSTRAINT FK_CAA72719A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE single ADD CONSTRAINT FK_CAA727194296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)');
        $this->addSql('CREATE INDEX IDX_CAA727191137ABCF ON single (album_id)');
        $this->addSql('CREATE INDEX IDX_CAA72719A76ED395 ON single (user_id)');
        $this->addSql('CREATE INDEX IDX_CAA727194296D31F ON single (genre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE single DROP FOREIGN KEY FK_CAA727191137ABCF');
        $this->addSql('ALTER TABLE single DROP FOREIGN KEY FK_CAA727194296D31F');
        $this->addSql('ALTER TABLE single DROP FOREIGN KEY FK_CAA72719A76ED395');
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E43A76ED395');
        $this->addSql('ALTER TABLE playlist DROP FOREIGN KEY FK_D782112DA76ED395');
        $this->addSql('ALTER TABLE playlist_single DROP FOREIGN KEY FK_25D12B2A6BBD148');
        $this->addSql('ALTER TABLE playlist_single DROP FOREIGN KEY FK_25D12B2AE7C1D92B');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE genre');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE playlist_single');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP INDEX IDX_CAA727191137ABCF ON single');
        $this->addSql('DROP INDEX IDX_CAA72719A76ED395 ON single');
        $this->addSql('DROP INDEX IDX_CAA727194296D31F ON single');
        $this->addSql('ALTER TABLE single DROP album_id, DROP user_id, DROP genre_id');
    }
}
