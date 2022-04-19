<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220418141720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dinosaurs (id INT AUTO_INCREMENT NOT NULL, enclosure_id INT DEFAULT NULL, length INT NOT NULL, genus VARCHAR(255) NOT NULL, is_carnivorous TINYINT(1) NOT NULL, INDEX IDX_B1DE6E91D04FE1E5 (enclosure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enclosures (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE securities (id INT AUTO_INCREMENT NOT NULL, enclosure_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_A8210B24D04FE1E5 (enclosure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dinosaurs ADD CONSTRAINT FK_B1DE6E91D04FE1E5 FOREIGN KEY (enclosure_id) REFERENCES enclosures (id)');
        $this->addSql('ALTER TABLE securities ADD CONSTRAINT FK_A8210B24D04FE1E5 FOREIGN KEY (enclosure_id) REFERENCES enclosures (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dinosaurs DROP FOREIGN KEY FK_B1DE6E91D04FE1E5');
        $this->addSql('ALTER TABLE securities DROP FOREIGN KEY FK_A8210B24D04FE1E5');
        $this->addSql('DROP TABLE dinosaurs');
        $this->addSql('DROP TABLE enclosures');
        $this->addSql('DROP TABLE securities');
    }
}
