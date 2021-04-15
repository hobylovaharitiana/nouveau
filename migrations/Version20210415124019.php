<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210415124019 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, personne_type_id INT NOT NULL, nom_personne VARCHAR(255) NOT NULL, prenom_personne VARCHAR(255) NOT NULL, email_personne VARCHAR(255) NOT NULL, telephone INT NOT NULL, adresse VARCHAR(255) NOT NULL, INDEX IDX_FCEC9EF1BC3686E (personne_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne_type (id INT AUTO_INCREMENT NOT NULL, nom_type VARCHAR(255) NOT NULL, specialite VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EF1BC3686E FOREIGN KEY (personne_type_id) REFERENCES personne_type (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EF1BC3686E');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE personne_type');
    }
}
