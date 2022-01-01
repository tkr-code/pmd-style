<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211231203910 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence (id INT AUTO_INCREMENT NOT NULL, cv_id INT NOT NULL, name VARCHAR(255) NOT NULL, value INT NOT NULL, INDEX IDX_94D4687FCFE419E2 (cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cv (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, experiences_id INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_B66FFE92A76ED395 (user_id), UNIQUE INDEX UNIQ_B66FFE92423DE140 (experiences_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience (id INT AUTO_INCREMENT NOT NULL, entreprise VARCHAR(255) NOT NULL, poste VARCHAR(255) NOT NULL, duree VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, cv_id INT NOT NULL, formation_at VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, diplome VARCHAR(255) NOT NULL, ecole VARCHAR(255) NOT NULL, INDEX IDX_404021BFCFE419E2 (cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE langue (id INT AUTO_INCREMENT NOT NULL, cv_id INT NOT NULL, name VARCHAR(255) NOT NULL, value INT NOT NULL, INDEX IDX_9357758ECFE419E2 (cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logiciel (id INT AUTO_INCREMENT NOT NULL, cv_id INT NOT NULL, name VARCHAR(255) NOT NULL, value INT NOT NULL, INDEX IDX_2C50669CCFE419E2 (cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competence ADD CONSTRAINT FK_94D4687FCFE419E2 FOREIGN KEY (cv_id) REFERENCES cv (id)');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT FK_B66FFE92A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT FK_B66FFE92423DE140 FOREIGN KEY (experiences_id) REFERENCES experience (id)');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BFCFE419E2 FOREIGN KEY (cv_id) REFERENCES cv (id)');
        $this->addSql('ALTER TABLE langue ADD CONSTRAINT FK_9357758ECFE419E2 FOREIGN KEY (cv_id) REFERENCES cv (id)');
        $this->addSql('ALTER TABLE logiciel ADD CONSTRAINT FK_2C50669CCFE419E2 FOREIGN KEY (cv_id) REFERENCES cv (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE competence DROP FOREIGN KEY FK_94D4687FCFE419E2');
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BFCFE419E2');
        $this->addSql('ALTER TABLE langue DROP FOREIGN KEY FK_9357758ECFE419E2');
        $this->addSql('ALTER TABLE logiciel DROP FOREIGN KEY FK_2C50669CCFE419E2');
        $this->addSql('ALTER TABLE cv DROP FOREIGN KEY FK_B66FFE92423DE140');
        $this->addSql('DROP TABLE competence');
        $this->addSql('DROP TABLE cv');
        $this->addSql('DROP TABLE experience');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE langue');
        $this->addSql('DROP TABLE logiciel');
    }
}
