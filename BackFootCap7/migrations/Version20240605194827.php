<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605194827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3B66FE4594');
        $this->addSql('DROP INDEX IDX_188D2E3B66FE4594 ON reserva');
        $this->addSql('ALTER TABLE reserva DROP arbitro_id, CHANGE arbitro arbitro_opcion TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserva ADD arbitro_id INT DEFAULT NULL, CHANGE arbitro_opcion arbitro TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B66FE4594 FOREIGN KEY (arbitro_id) REFERENCES arbitro (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_188D2E3B66FE4594 ON reserva (arbitro_id)');
    }
}
