<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240823095626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depannage_content CHANGE description description VARCHAR(1000) NOT NULL');
        $this->addSql('ALTER TABLE reparation_content CHANGE description description VARCHAR(1000) NOT NULL');
        $this->addSql('ALTER TABLE voiture_content CHANGE description description VARCHAR(1000) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depannage_content CHANGE description description VARCHAR(500) NOT NULL');
        $this->addSql('ALTER TABLE reparation_content CHANGE description description VARCHAR(500) NOT NULL');
        $this->addSql('ALTER TABLE voiture_content CHANGE description description VARCHAR(500) NOT NULL');
    }
}
