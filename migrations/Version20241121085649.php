<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241121085649 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE examen (id INT AUTO_INCREMENT NOT NULL, professeur_de_garde_id INT NOT NULL, name VARCHAR(255) NOT NULL, date DATETIME NOT NULL, duration INT NOT NULL, location VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_514C8FEC51291DD9 (professeur_de_garde_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE examen_classe (examen_id INT NOT NULL, classe_id INT NOT NULL, INDEX IDX_B3E0EFF45C8659A (examen_id), INDEX IDX_B3E0EFF48F5EA509 (classe_id), PRIMARY KEY(examen_id, classe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE examen ADD CONSTRAINT FK_514C8FEC51291DD9 FOREIGN KEY (professeur_de_garde_id) REFERENCES professor (id)');
        $this->addSql('ALTER TABLE examen_classe ADD CONSTRAINT FK_B3E0EFF45C8659A FOREIGN KEY (examen_id) REFERENCES examen (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE examen_classe ADD CONSTRAINT FK_B3E0EFF48F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE examen DROP FOREIGN KEY FK_514C8FEC51291DD9');
        $this->addSql('ALTER TABLE examen_classe DROP FOREIGN KEY FK_B3E0EFF45C8659A');
        $this->addSql('ALTER TABLE examen_classe DROP FOREIGN KEY FK_B3E0EFF48F5EA509');
        $this->addSql('DROP TABLE examen');
        $this->addSql('DROP TABLE examen_classe');
    }
}
