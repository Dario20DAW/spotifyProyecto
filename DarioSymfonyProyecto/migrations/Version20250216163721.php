<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250216163721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usuario CHANGE nombre nombre VARCHAR(255) DEFAULT NULL, CHANGE fecha_nacimiento fecha_nacimiento DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE usuario RENAME INDEX uniq_2265b05de7927c74 TO UNIQ_IDENTIFIER_EMAIL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE usuario CHANGE nombre nombre VARCHAR(255) NOT NULL, CHANGE fecha_nacimiento fecha_nacimiento DATE NOT NULL');
        $this->addSql('ALTER TABLE usuario RENAME INDEX uniq_identifier_email TO UNIQ_2265B05DE7927C74');
    }
}
