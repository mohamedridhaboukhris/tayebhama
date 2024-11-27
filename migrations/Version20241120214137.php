<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120214137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE classe ADD salle_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('CREATE INDEX IDX_8F87BF96DC304035 ON classe (salle_id)');
        $this->addSql('DROP INDEX UNIQ_717E22E34C62E638 ON etudiant');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96DC304035');
        $this->addSql('DROP INDEX IDX_8F87BF96DC304035 ON classe');
        $this->addSql('ALTER TABLE classe DROP salle_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_717E22E34C62E638 ON etudiant (contact)');
    }
}
