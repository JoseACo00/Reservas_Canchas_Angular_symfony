<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605235050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partido ADD usuario_id INT NOT NULL, ADD arbitro_id INT DEFAULT NULL, ADD cancha_id INT NOT NULL, ADD reserva_id INT NOT NULL');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750B66FE4594 FOREIGN KEY (arbitro_id) REFERENCES arbitro (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750B7997F36E FOREIGN KEY (cancha_id) REFERENCES cancha (id)');
        $this->addSql('ALTER TABLE partido ADD CONSTRAINT FK_4E79750BD67139E8 FOREIGN KEY (reserva_id) REFERENCES reserva (id)');
        $this->addSql('CREATE INDEX IDX_4E79750BDB38439E ON partido (usuario_id)');
        $this->addSql('CREATE INDEX IDX_4E79750B66FE4594 ON partido (arbitro_id)');
        $this->addSql('CREATE INDEX IDX_4E79750B7997F36E ON partido (cancha_id)');
        $this->addSql('CREATE INDEX IDX_4E79750BD67139E8 ON partido (reserva_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750BDB38439E');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750B66FE4594');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750B7997F36E');
        $this->addSql('ALTER TABLE partido DROP FOREIGN KEY FK_4E79750BD67139E8');
        $this->addSql('DROP INDEX IDX_4E79750BDB38439E ON partido');
        $this->addSql('DROP INDEX IDX_4E79750B66FE4594 ON partido');
        $this->addSql('DROP INDEX IDX_4E79750B7997F36E ON partido');
        $this->addSql('DROP INDEX IDX_4E79750BD67139E8 ON partido');
        $this->addSql('ALTER TABLE partido DROP usuario_id, DROP arbitro_id, DROP cancha_id, DROP reserva_id');
    }
}
