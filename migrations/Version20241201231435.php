<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241201231435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE examen_exercice (examen_id INT NOT NULL, exercice_id INT NOT NULL, INDEX IDX_D8B8A3FB5C8659A (examen_id), INDEX IDX_D8B8A3FB89D40298 (exercice_id), PRIMARY KEY(examen_id, exercice_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE exercice (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE examen_exercice ADD CONSTRAINT FK_D8B8A3FB5C8659A FOREIGN KEY (examen_id) REFERENCES examen (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE examen_exercice ADD CONSTRAINT FK_D8B8A3FB89D40298 FOREIGN KEY (exercice_id) REFERENCES exercice (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE exam');
        $this->addSql('ALTER TABLE cours DROP horaires');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE exam (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date_remise DATE NOT NULL, classe_concernee INT NOT NULL, professeurs VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, exercice VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE examen_exercice DROP FOREIGN KEY FK_D8B8A3FB5C8659A');
        $this->addSql('ALTER TABLE examen_exercice DROP FOREIGN KEY FK_D8B8A3FB89D40298');
        $this->addSql('DROP TABLE examen_exercice');
        $this->addSql('DROP TABLE exercice');
        $this->addSql('ALTER TABLE cours ADD horaires TIME DEFAULT NULL');
    }
}
