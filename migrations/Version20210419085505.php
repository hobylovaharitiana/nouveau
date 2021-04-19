<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419085505 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personne ADD personne_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE personne ADD CONSTRAINT FK_FCEC9EF1BC3686E FOREIGN KEY (personne_type_id) REFERENCES personne_type (id)');
        $this->addSql('CREATE INDEX IDX_FCEC9EF1BC3686E ON personne (personne_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personne DROP FOREIGN KEY FK_FCEC9EF1BC3686E');
        $this->addSql('DROP INDEX IDX_FCEC9EF1BC3686E ON personne');
        $this->addSql('ALTER TABLE personne DROP personne_type_id');
    }
}
