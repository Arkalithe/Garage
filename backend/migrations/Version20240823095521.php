<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240823095521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depannage_content ADD intro VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reparation_content ADD intro VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE voiture_content ADD intro VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE depannage_content DROP intro');
        $this->addSql('ALTER TABLE reparation_content DROP intro');
        $this->addSql('ALTER TABLE voiture_content DROP intro');
    }
}
