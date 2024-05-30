<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240530174419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE arbitro (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, username1 VARCHAR(255) NOT NULL, username2 VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, age INT NOT NULL, phone INT NOT NULL, experiences LONGTEXT NOT NULL, created_at DATETIME NOT NULL, created_by INT NOT NULL, modified_at DATETIME NOT NULL, modified_by INT NOT NULL, deleted_at DATETIME NOT NULL, deleted_by INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE arbitro');
    }
}
