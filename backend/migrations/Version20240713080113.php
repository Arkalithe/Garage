<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240713080113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE caracteristique (id INT AUTO_INCREMENT NOT NULL, caracteristique VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cvvoiture (id INT AUTO_INCREMENT NOT NULL, voiture_id INT NOT NULL, caracteristique_id INT NOT NULL, INDEX IDX_9D566FA9181A8BA (voiture_id), INDEX IDX_9D566FA91704EEB7 (caracteristique_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipement (id INT AUTO_INCREMENT NOT NULL, equipement VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evvoiture (id INT AUTO_INCREMENT NOT NULL, voiture_id INT NOT NULL, equipement_id INT NOT NULL, INDEX IDX_EE4C1623181A8BA (voiture_id), INDEX IDX_EE4C1623806F0F5C (equipement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, image_path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, prix INT NOT NULL, kilometrage INT NOT NULL, annee_circulation INT NOT NULL, modele VARCHAR(50) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, numero VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture_caracteristique (voiture_id INT NOT NULL, caracteristique_id INT NOT NULL, INDEX IDX_12CE44C9181A8BA (voiture_id), INDEX IDX_12CE44C91704EEB7 (caracteristique_id), PRIMARY KEY(voiture_id, caracteristique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture_equipement (voiture_id INT NOT NULL, equipement_id INT NOT NULL, INDEX IDX_C99F3755181A8BA (voiture_id), INDEX IDX_C99F3755806F0F5C (equipement_id), PRIMARY KEY(voiture_id, equipement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture_image (id INT AUTO_INCREMENT NOT NULL, voiture_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_E890A1A8181A8BA (voiture_id), INDEX IDX_E890A1A83DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cvvoiture ADD CONSTRAINT FK_9D566FA9181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
        $this->addSql('ALTER TABLE cvvoiture ADD CONSTRAINT FK_9D566FA91704EEB7 FOREIGN KEY (caracteristique_id) REFERENCES caracteristique (id)');
        $this->addSql('ALTER TABLE evvoiture ADD CONSTRAINT FK_EE4C1623181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
        $this->addSql('ALTER TABLE evvoiture ADD CONSTRAINT FK_EE4C1623806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id)');
        $this->addSql('ALTER TABLE voiture_caracteristique ADD CONSTRAINT FK_12CE44C9181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voiture_caracteristique ADD CONSTRAINT FK_12CE44C91704EEB7 FOREIGN KEY (caracteristique_id) REFERENCES caracteristique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voiture_equipement ADD CONSTRAINT FK_C99F3755181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voiture_equipement ADD CONSTRAINT FK_C99F3755806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voiture_image ADD CONSTRAINT FK_E890A1A8181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id)');
        $this->addSql('ALTER TABLE voiture_image ADD CONSTRAINT FK_E890A1A83DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cvvoiture DROP FOREIGN KEY FK_9D566FA9181A8BA');
        $this->addSql('ALTER TABLE cvvoiture DROP FOREIGN KEY FK_9D566FA91704EEB7');
        $this->addSql('ALTER TABLE evvoiture DROP FOREIGN KEY FK_EE4C1623181A8BA');
        $this->addSql('ALTER TABLE evvoiture DROP FOREIGN KEY FK_EE4C1623806F0F5C');
        $this->addSql('ALTER TABLE voiture_caracteristique DROP FOREIGN KEY FK_12CE44C9181A8BA');
        $this->addSql('ALTER TABLE voiture_caracteristique DROP FOREIGN KEY FK_12CE44C91704EEB7');
        $this->addSql('ALTER TABLE voiture_equipement DROP FOREIGN KEY FK_C99F3755181A8BA');
        $this->addSql('ALTER TABLE voiture_equipement DROP FOREIGN KEY FK_C99F3755806F0F5C');
        $this->addSql('ALTER TABLE voiture_image DROP FOREIGN KEY FK_E890A1A8181A8BA');
        $this->addSql('ALTER TABLE voiture_image DROP FOREIGN KEY FK_E890A1A83DA5256D');
        $this->addSql('DROP TABLE caracteristique');
        $this->addSql('DROP TABLE cvvoiture');
        $this->addSql('DROP TABLE equipement');
        $this->addSql('DROP TABLE evvoiture');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE voiture');
        $this->addSql('DROP TABLE voiture_caracteristique');
        $this->addSql('DROP TABLE voiture_equipement');
        $this->addSql('DROP TABLE voiture_image');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
