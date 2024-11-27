<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120183359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant ADD matricule VARCHAR(20) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_717E22E34C62E638 ON etudiant (contact)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_717E22E312B2DC9C ON etudiant (matricule)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_717E22E34C62E638 ON etudiant');
        $this->addSql('DROP INDEX UNIQ_717E22E312B2DC9C ON etudiant');
        $this->addSql('ALTER TABLE etudiant DROP matricule');
    }
}
