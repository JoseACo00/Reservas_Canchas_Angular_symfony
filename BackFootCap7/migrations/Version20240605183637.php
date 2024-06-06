<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605183637 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserva ADD usuario_id INT NOT NULL, ADD arbitro_id INT DEFAULT NULL, ADD cancha_id INT NOT NULL');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3BDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B66FE4594 FOREIGN KEY (arbitro_id) REFERENCES arbitro (id)');
        $this->addSql('ALTER TABLE reserva ADD CONSTRAINT FK_188D2E3B7997F36E FOREIGN KEY (cancha_id) REFERENCES cancha (id)');
        $this->addSql('CREATE INDEX IDX_188D2E3BDB38439E ON reserva (usuario_id)');
        $this->addSql('CREATE INDEX IDX_188D2E3B66FE4594 ON reserva (arbitro_id)');
        $this->addSql('CREATE INDEX IDX_188D2E3B7997F36E ON reserva (cancha_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3BDB38439E');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3B66FE4594');
        $this->addSql('ALTER TABLE reserva DROP FOREIGN KEY FK_188D2E3B7997F36E');
        $this->addSql('DROP INDEX IDX_188D2E3BDB38439E ON reserva');
        $this->addSql('DROP INDEX IDX_188D2E3B66FE4594 ON reserva');
        $this->addSql('DROP INDEX IDX_188D2E3B7997F36E ON reserva');
        $this->addSql('ALTER TABLE reserva DROP usuario_id, DROP arbitro_id, DROP cancha_id');
    }
}
