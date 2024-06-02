<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240602164525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `admin` ADD rol_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `admin` ADD CONSTRAINT FK_880E0D764BAB96C FOREIGN KEY (rol_id) REFERENCES rol (id)');
        $this->addSql('CREATE INDEX IDX_880E0D764BAB96C ON `admin` (rol_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `admin` DROP FOREIGN KEY FK_880E0D764BAB96C');
        $this->addSql('DROP INDEX IDX_880E0D764BAB96C ON `admin`');
        $this->addSql('ALTER TABLE `admin` DROP rol_id');
    }
}
