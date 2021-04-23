<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210421115619 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panne ADD materiel_id INT NOT NULL');
        $this->addSql('ALTER TABLE panne ADD CONSTRAINT FK_3885B26016880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id)');
        $this->addSql('CREATE INDEX IDX_3885B26016880AAF ON panne (materiel_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE panne DROP FOREIGN KEY FK_3885B26016880AAF');
        $this->addSql('DROP INDEX IDX_3885B26016880AAF ON panne');
        $this->addSql('ALTER TABLE panne DROP materiel_id');
    }
}
