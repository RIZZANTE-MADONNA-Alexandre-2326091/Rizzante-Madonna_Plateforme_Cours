<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260209090332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `pdf` (id INT AUTO_INCREMENT NOT NULL, file_name VARCHAR(255) NOT NULL, file LONGBLOB NOT NULL, qcm_id INT NOT NULL, INDEX IDX_EF0DB8CFF6241A6 (qcm_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE `pdf` ADD CONSTRAINT FK_EF0DB8CFF6241A6 FOREIGN KEY (qcm_id) REFERENCES `qcm` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `pdf` DROP FOREIGN KEY FK_EF0DB8CFF6241A6');
        $this->addSql('DROP TABLE `pdf`');
    }
}
