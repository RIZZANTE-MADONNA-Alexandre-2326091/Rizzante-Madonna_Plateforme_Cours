<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260212100315 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pdf CHANGE qcm_id qcm_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE qcm CHANGE profile_id profile_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE response CHANGE qcm_id qcm_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE video CHANGE qcm_id qcm_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `pdf` CHANGE qcm_id qcm_id INT NOT NULL');
        $this->addSql('ALTER TABLE `qcm` CHANGE profile_id profile_id INT NOT NULL');
        $this->addSql('ALTER TABLE `response` CHANGE qcm_id qcm_id INT NOT NULL');
        $this->addSql('ALTER TABLE `video` CHANGE qcm_id qcm_id INT NOT NULL');
    }
}
