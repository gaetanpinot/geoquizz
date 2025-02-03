<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250203152232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE coup_joue (id SERIAL NOT NULL, partie_id INT NOT NULL, id_image INT NOT NULL, date_joue TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, lat DOUBLE PRECISION DEFAULT NULL, long DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FD9D3291E075F7A4 ON coup_joue (partie_id)');
        $this->addSql('CREATE TABLE partie (id SERIAL NOT NULL, id_serie INT NOT NULL, id_joueur UUID NOT NULL, status INT NOT NULL, difficulte INT NOT NULL, score INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE coup_joue ADD CONSTRAINT FK_FD9D3291E075F7A4 FOREIGN KEY (partie_id) REFERENCES partie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE coup_joue DROP CONSTRAINT FK_FD9D3291E075F7A4');
        $this->addSql('DROP TABLE coup_joue');
        $this->addSql('DROP TABLE partie');
    }
}
