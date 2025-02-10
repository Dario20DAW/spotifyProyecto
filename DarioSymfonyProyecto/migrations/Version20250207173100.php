<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250207173100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE perfil_estilo (perfil_id INT NOT NULL, estilo_id INT NOT NULL, INDEX IDX_8C8A3EBE57291544 (perfil_id), INDEX IDX_8C8A3EBE43798DA7 (estilo_id), PRIMARY KEY(perfil_id, estilo_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario_cancion (usuario_id INT NOT NULL, cancion_id INT NOT NULL, INDEX IDX_9D44A5E7DB38439E (usuario_id), INDEX IDX_9D44A5E79B1D840F (cancion_id), PRIMARY KEY(usuario_id, cancion_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE perfil_estilo ADD CONSTRAINT FK_8C8A3EBE57291544 FOREIGN KEY (perfil_id) REFERENCES perfil (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE perfil_estilo ADD CONSTRAINT FK_8C8A3EBE43798DA7 FOREIGN KEY (estilo_id) REFERENCES estilo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE usuario_cancion ADD CONSTRAINT FK_9D44A5E7DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE usuario_cancion ADD CONSTRAINT FK_9D44A5E79B1D840F FOREIGN KEY (cancion_id) REFERENCES cancion (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cancion CHANGE genero_id genero_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE perfil DROP FOREIGN KEY FK_966576471C9C8804');
        $this->addSql('DROP INDEX IDX_966576471C9C8804 ON perfil');
        $this->addSql('ALTER TABLE perfil DROP estilo_musical_preferido_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE perfil_estilo DROP FOREIGN KEY FK_8C8A3EBE57291544');
        $this->addSql('ALTER TABLE perfil_estilo DROP FOREIGN KEY FK_8C8A3EBE43798DA7');
        $this->addSql('ALTER TABLE usuario_cancion DROP FOREIGN KEY FK_9D44A5E7DB38439E');
        $this->addSql('ALTER TABLE usuario_cancion DROP FOREIGN KEY FK_9D44A5E79B1D840F');
        $this->addSql('DROP TABLE perfil_estilo');
        $this->addSql('DROP TABLE usuario_cancion');
        $this->addSql('ALTER TABLE cancion CHANGE genero_id genero_id INT NOT NULL');
        $this->addSql('ALTER TABLE perfil ADD estilo_musical_preferido_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE perfil ADD CONSTRAINT FK_966576471C9C8804 FOREIGN KEY (estilo_musical_preferido_id) REFERENCES estilo (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_966576471C9C8804 ON perfil (estilo_musical_preferido_id)');
    }
}
