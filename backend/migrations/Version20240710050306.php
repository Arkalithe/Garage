<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240710050306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE caracteristique (id INT AUTO_INCREMENT NOT NULL, caracteristique VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cv_voiture (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cv_voiture_voiture (cv_voiture_id INT NOT NULL, voiture_id INT NOT NULL, INDEX IDX_2C1583027E773D28 (cv_voiture_id), INDEX IDX_2C158302181A8BA (voiture_id), PRIMARY KEY(cv_voiture_id, voiture_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cv_voiture_caracteristique (cv_voiture_id INT NOT NULL, caracteristique_id INT NOT NULL, INDEX IDX_F4B7F4797E773D28 (cv_voiture_id), INDEX IDX_F4B7F4791704EEB7 (caracteristique_id), PRIMARY KEY(cv_voiture_id, caracteristique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipement (id INT AUTO_INCREMENT NOT NULL, equipement VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ev_voiture (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ev_voiture_voiture (ev_voiture_id INT NOT NULL, voiture_id INT NOT NULL, INDEX IDX_22693F87DE92E2F5 (ev_voiture_id), INDEX IDX_22693F87181A8BA (voiture_id), PRIMARY KEY(ev_voiture_id, voiture_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ev_voiture_equipement (ev_voiture_id INT NOT NULL, equipement_id INT NOT NULL, INDEX IDX_57BE559EDE92E2F5 (ev_voiture_id), INDEX IDX_57BE559E806F0F5C (equipement_id), PRIMARY KEY(ev_voiture_id, equipement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, image_url VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture (id INT AUTO_INCREMENT NOT NULL, prix INT NOT NULL, kilometrage INT NOT NULL, annee_circulation INT NOT NULL, modle VARCHAR(50) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, numero VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture_image (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture_image_voiture (voiture_image_id INT NOT NULL, voiture_id INT NOT NULL, INDEX IDX_1CDECCF639D7EC (voiture_image_id), INDEX IDX_1CDECC181A8BA (voiture_id), PRIMARY KEY(voiture_image_id, voiture_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voiture_image_images (voiture_image_id INT NOT NULL, images_id INT NOT NULL, INDEX IDX_7DE5486CF639D7EC (voiture_image_id), INDEX IDX_7DE5486CD44F05E5 (images_id), PRIMARY KEY(voiture_image_id, images_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cv_voiture_voiture ADD CONSTRAINT FK_2C1583027E773D28 FOREIGN KEY (cv_voiture_id) REFERENCES cv_voiture (id)');
        $this->addSql('ALTER TABLE cv_voiture_voiture ADD CONSTRAINT FK_2C158302181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cv_voiture_caracteristique ADD CONSTRAINT FK_F4B7F4797E773D28 FOREIGN KEY (cv_voiture_id) REFERENCES cv_voiture (id)');
        $this->addSql('ALTER TABLE cv_voiture_caracteristique ADD CONSTRAINT FK_F4B7F4791704EEB7 FOREIGN KEY (caracteristique_id) REFERENCES caracteristique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ev_voiture_voiture ADD CONSTRAINT FK_22693F87DE92E2F5 FOREIGN KEY (ev_voiture_id) REFERENCES ev_voiture (id)');
        $this->addSql('ALTER TABLE ev_voiture_voiture ADD CONSTRAINT FK_22693F87181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ev_voiture_equipement ADD CONSTRAINT FK_57BE559EDE92E2F5 FOREIGN KEY (ev_voiture_id) REFERENCES ev_voiture (id)');
        $this->addSql('ALTER TABLE ev_voiture_equipement ADD CONSTRAINT FK_57BE559E806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voiture_image_voiture ADD CONSTRAINT FK_1CDECCF639D7EC FOREIGN KEY (voiture_image_id) REFERENCES voiture_image (id)');
        $this->addSql('ALTER TABLE voiture_image_voiture ADD CONSTRAINT FK_1CDECC181A8BA FOREIGN KEY (voiture_id) REFERENCES voiture (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE voiture_image_images ADD CONSTRAINT FK_7DE5486CF639D7EC FOREIGN KEY (voiture_image_id) REFERENCES voiture_image (id)');
        $this->addSql('ALTER TABLE voiture_image_images ADD CONSTRAINT FK_7DE5486CD44F05E5 FOREIGN KEY (images_id) REFERENCES images (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cv_voiture_voiture DROP FOREIGN KEY FK_2C1583027E773D28');
        $this->addSql('ALTER TABLE cv_voiture_voiture DROP FOREIGN KEY FK_2C158302181A8BA');
        $this->addSql('ALTER TABLE cv_voiture_caracteristique DROP FOREIGN KEY FK_F4B7F4797E773D28');
        $this->addSql('ALTER TABLE cv_voiture_caracteristique DROP FOREIGN KEY FK_F4B7F4791704EEB7');
        $this->addSql('ALTER TABLE ev_voiture_voiture DROP FOREIGN KEY FK_22693F87DE92E2F5');
        $this->addSql('ALTER TABLE ev_voiture_voiture DROP FOREIGN KEY FK_22693F87181A8BA');
        $this->addSql('ALTER TABLE ev_voiture_equipement DROP FOREIGN KEY FK_57BE559EDE92E2F5');
        $this->addSql('ALTER TABLE ev_voiture_equipement DROP FOREIGN KEY FK_57BE559E806F0F5C');
        $this->addSql('ALTER TABLE voiture_image_voiture DROP FOREIGN KEY FK_1CDECCF639D7EC');
        $this->addSql('ALTER TABLE voiture_image_voiture DROP FOREIGN KEY FK_1CDECC181A8BA');
        $this->addSql('ALTER TABLE voiture_image_images DROP FOREIGN KEY FK_7DE5486CF639D7EC');
        $this->addSql('ALTER TABLE voiture_image_images DROP FOREIGN KEY FK_7DE5486CD44F05E5');
        $this->addSql('DROP TABLE caracteristique');
        $this->addSql('DROP TABLE cv_voiture');
        $this->addSql('DROP TABLE cv_voiture_voiture');
        $this->addSql('DROP TABLE cv_voiture_caracteristique');
        $this->addSql('DROP TABLE equipement');
        $this->addSql('DROP TABLE ev_voiture');
        $this->addSql('DROP TABLE ev_voiture_voiture');
        $this->addSql('DROP TABLE ev_voiture_equipement');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP TABLE voiture');
        $this->addSql('DROP TABLE voiture_image');
        $this->addSql('DROP TABLE voiture_image_voiture');
        $this->addSql('DROP TABLE voiture_image_images');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
