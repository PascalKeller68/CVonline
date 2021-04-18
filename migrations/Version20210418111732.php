<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210418111732 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, relation_user_id INT NOT NULL, project_name VARCHAR(255) NOT NULL, project_description LONGTEXT NOT NULL, project_link VARCHAR(255) DEFAULT NULL, project_languages LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_2FB3D0EEBE15C1E4 (relation_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EEBE15C1E4 FOREIGN KEY (relation_user_id) REFERENCES user (id)');

        $this->addSql('INSERT INTO user (name, last_name, email, password, role) 
        VALUES ("Keller", "pascal", "pascalkeller99@gmail.com", "$2y$12$gPiPxVqblvxBwUkDve.D4ekuFVDwhMxeOPCubxr/NNwGzDeoNL6lq", "ROLE_ADMIN")');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EEBE15C1E4');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE user');
    }
}
