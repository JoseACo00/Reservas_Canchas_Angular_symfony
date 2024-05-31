<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240531180807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arbitro ADD surname1 VARCHAR(255) NOT NULL, ADD surname2 VARCHAR(255) NOT NULL, DROP username1, DROP username2');
        $this->addSql('ALTER TABLE usuario ADD surname1 VARCHAR(255) NOT NULL, ADD surname2 VARCHAR(255) NOT NULL, DROP username1, DROP username2');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arbitro ADD username1 VARCHAR(255) NOT NULL, ADD username2 VARCHAR(255) NOT NULL, DROP surname1, DROP surname2');
        $this->addSql('ALTER TABLE usuario ADD username1 VARCHAR(255) NOT NULL, ADD username2 VARCHAR(255) NOT NULL, DROP surname1, DROP surname2');
    }
}
