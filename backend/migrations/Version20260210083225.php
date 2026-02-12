<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260210083225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qcm ADD note INT NOT NULL, ADD profile_id INT NOT NULL');
        $this->addSql('ALTER TABLE qcm ADD CONSTRAINT FK_D7A1FEF4CCFA12B8 FOREIGN KEY (profile_id) REFERENCES `user` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D7A1FEF4CCFA12B8 ON qcm (profile_id)');
        $this->addSql('ALTER TABLE response ADD type VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `qcm` DROP FOREIGN KEY FK_D7A1FEF4CCFA12B8');
        $this->addSql('DROP INDEX UNIQ_D7A1FEF4CCFA12B8 ON `qcm`');
        $this->addSql('ALTER TABLE `qcm` DROP note, DROP profile_id');
        $this->addSql('ALTER TABLE `response` DROP type');
    }
}
