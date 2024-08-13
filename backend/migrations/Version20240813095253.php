<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240813095253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE depannage_content (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(60) NOT NULL, description VARCHAR(500) NOT NULL, image_path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reparation_content (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(60) NOT NULL, description VARCHAR(500) NOT NULL, image_path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture_content (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(60) NOT NULL, description VARCHAR(500) NOT NULL, image_path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE voiture_caracteristique DROP FOREIGN KEY FK_12CE44C9181A8BA');
        $this->addSql('ALTER TABLE voiture_caracteristique DROP FOREIGN KEY FK_12CE44C91704EEB7');
        $this->addSql('ALTER TABLE voiture_equipement DROP FOREIGN KEY FK_C99F3755181A8BA');
        $this->addSql('ALTER TABLE voiture_equipement DROP FOREIGN KEY FK_C99F3755806F0F5C');
        $this->addSql('DROP TABLE voiture_caracteristique');
        $this->addSql('DROP TABLE voiture_equipement');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE voiture_caracteristique (voiture_id INT NOT NULL, caracteristique_id INT NOT NULL, INDEX IDX_12CE44C9181A8BA (voiture_id), INDEX IDX_12CE44C91704EEB7 (caracteristique_id), PRIMARY KEY(voiture_id, caracteristique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE voiture_equipement (voiture_id INT NOT NULL, equipement_id INT NOT NULL, INDEX IDX_C99F3755806F0F5C (equipement_id), INDEX IDX_C99F3755181A8BA (voiture_id), PRIMARY KEY(voiture_id, equipement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE voiture_caracteristique ADD CONSTRAINT FK_12CE44C9181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voiture_caracteristique ADD CONSTRAINT FK_12CE44C91704EEB7 FOREIGN KEY (caracteristique_id) REFERENCES caracteristique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voiture_equipement ADD CONSTRAINT FK_C99F3755181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voiture_equipement ADD CONSTRAINT FK_C99F3755806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE depannage_content');
        $this->addSql('DROP TABLE reparation_content');
        $this->addSql('DROP TABLE voiture_content');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
    }
}
