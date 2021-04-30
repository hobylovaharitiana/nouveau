<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210426090729 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panne ADD personnes_id INT NOT NULL');
        $this->addSql('ALTER TABLE panne ADD CONSTRAINT FK_3885B26016880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id)');
        $this->addSql('ALTER TABLE panne ADD CONSTRAINT FK_3885B260146AD7BC FOREIGN KEY (personnes_id) REFERENCES personne (id)');
        $this->addSql('CREATE INDEX IDX_3885B26016880AAF ON panne (materiel_id)');
        $this->addSql('CREATE INDEX IDX_3885B260146AD7BC ON panne (personnes_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panne DROP FOREIGN KEY FK_3885B26016880AAF');
        $this->addSql('ALTER TABLE panne DROP FOREIGN KEY FK_3885B260146AD7BC');
        $this->addSql('DROP INDEX IDX_3885B26016880AAF ON panne');
        $this->addSql('DROP INDEX IDX_3885B260146AD7BC ON panne');
        $this->addSql('ALTER TABLE panne DROP personnes_id');
    }
}
