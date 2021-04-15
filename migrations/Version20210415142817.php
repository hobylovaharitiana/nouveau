<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415142817 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EF1BC3686E');
        $this->addSql('CREATE TABLE materiel (id INT AUTO_INCREMENT NOT NULL, personnes_id INT NOT NULL, nom_materiel VARCHAR(255) NOT NULL, marque_materiel VARCHAR(255) NOT NULL, caracteristique LONGTEXT DEFAULT NULL, INDEX IDX_18D2B091146AD7BC (personnes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE materiel ADD CONSTRAINT FK_18D2B091146AD7BC FOREIGN KEY (personnes_id) REFERENCES personne (id)');
        $this->addSql('DROP TABLE personne_type');
        $this->addSql('DROP INDEX IDX_FCEC9EF1BC3686E ON personne');
        $this->addSql('ALTER TABLE personne DROP personne_type_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personne_type (id INT AUTO_INCREMENT NOT NULL, nom_type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, specialite VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('ALTER TABLE personne ADD personne_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EF1BC3686E FOREIGN KEY (personne_type_id) REFERENCES personne_type (id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EF1BC3686E ON personne (personne_type_id)');
    }
}
