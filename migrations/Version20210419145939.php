<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419145939 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_languages ADD relation_language_id INT NOT NULL');
        $this->addSql('ALTER TABLE project_languages ADD CONSTRAINT FK_B1ED16AEE67002EE FOREIGN KEY (relation_language_id) REFERENCES project (id)');
        $this->addSql('CREATE INDEX IDX_B1ED16AEE67002EE ON project_languages (relation_language_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project_languages DROP FOREIGN KEY FK_B1ED16AEE67002EE');
        $this->addSql('DROP INDEX IDX_B1ED16AEE67002EE ON project_languages');
        $this->addSql('ALTER TABLE project_languages DROP relation_language_id');
    }
}
