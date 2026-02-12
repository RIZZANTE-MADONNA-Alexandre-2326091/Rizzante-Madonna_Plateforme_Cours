<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260211030934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE qcm DROP INDEX UNIQ_D7A1FEF4CCFA12B8, ADD INDEX IDX_D7A1FEF4CCFA12B8 (profile_id)');
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(100) NOT NULL, ADD last_name VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `qcm` DROP INDEX IDX_D7A1FEF4CCFA12B8, ADD UNIQUE INDEX UNIQ_D7A1FEF4CCFA12B8 (profile_id)');
        $this->addSql('ALTER TABLE `user` DROP first_name, DROP last_name');
    }
}
