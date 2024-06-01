<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240601144754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arbitro ADD rol_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE arbitro ADD CONSTRAINT FK_C0670F704BAB96C FOREIGN KEY (rol_id) REFERENCES rol (id)');
        $this->addSql('CREATE INDEX IDX_C0670F704BAB96C ON arbitro (rol_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE arbitro DROP FOREIGN KEY FK_C0670F704BAB96C');
        $this->addSql('DROP INDEX IDX_C0670F704BAB96C ON arbitro');
        $this->addSql('ALTER TABLE arbitro DROP rol_id');
    }
}
