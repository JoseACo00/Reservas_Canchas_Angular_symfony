<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240601150031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rol ADD usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rol ADD CONSTRAINT FK_E553F37DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_E553F37DB38439E ON rol (usuario_id)');
        $this->addSql('ALTER TABLE usuario ADD rol_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE usuario ADD CONSTRAINT FK_2265B05D4BAB96C FOREIGN KEY (rol_id) REFERENCES rol (id)');
        $this->addSql('CREATE INDEX IDX_2265B05D4BAB96C ON usuario (rol_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usuario DROP FOREIGN KEY FK_2265B05D4BAB96C');
        $this->addSql('DROP INDEX IDX_2265B05D4BAB96C ON usuario');
        $this->addSql('ALTER TABLE usuario DROP rol_id');
        $this->addSql('ALTER TABLE rol DROP FOREIGN KEY FK_E553F37DB38439E');
        $this->addSql('DROP INDEX IDX_E553F37DB38439E ON rol');
        $this->addSql('ALTER TABLE rol DROP usuario_id');
    }
}
