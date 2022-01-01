<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220101182407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE interet (id INT AUTO_INCREMENT NOT NULL, cv_id INT NOT NULL, nom VARCHAR(255) NOT NULL, valeur INT NOT NULL, INDEX IDX_A9816FA5CFE419E2 (cv_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE interet ADD CONSTRAINT FK_A9816FA5CFE419E2 FOREIGN KEY (cv_id) REFERENCES cv (id)');
        $this->addSql('ALTER TABLE competence CHANGE name nom VARCHAR(255) NOT NULL, CHANGE value valeur INT NOT NULL');
        $this->addSql('ALTER TABLE cv DROP FOREIGN KEY FK_B66FFE92423DE140');
        $this->addSql('DROP INDEX UNIQ_B66FFE92423DE140 ON cv');
        $this->addSql('ALTER TABLE cv ADD poste VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD adresse VARCHAR(255) NOT NULL, ADD tel VARCHAR(255) NOT NULL, DROP experiences_id');
        $this->addSql('ALTER TABLE experience ADD cv_id INT NOT NULL, ADD nom VARCHAR(255) NOT NULL, ADD annee VARCHAR(255) NOT NULL, ADD valeur INT NOT NULL, ADD description LONGTEXT DEFAULT NULL, DROP entreprise, DROP duree');
        $this->addSql('ALTER TABLE experience ADD CONSTRAINT FK_590C103CFE419E2 FOREIGN KEY (cv_id) REFERENCES cv (id)');
        $this->addSql('CREATE INDEX IDX_590C103CFE419E2 ON experience (cv_id)');
        $this->addSql('ALTER TABLE formation CHANGE formation_at annee VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE langue DROP value, CHANGE name nom VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE logiciel CHANGE name nom VARCHAR(255) NOT NULL, CHANGE value valeur INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE interet');
        $this->addSql('ALTER TABLE competence CHANGE nom name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE valeur value INT NOT NULL');
        $this->addSql('ALTER TABLE cv ADD experiences_id INT DEFAULT NULL, DROP poste, DROP email, DROP adresse, DROP tel');
        $this->addSql('ALTER TABLE cv ADD CONSTRAINT FK_B66FFE92423DE140 FOREIGN KEY (experiences_id) REFERENCES experience (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B66FFE92423DE140 ON cv (experiences_id)');
        $this->addSql('ALTER TABLE experience DROP FOREIGN KEY FK_590C103CFE419E2');
        $this->addSql('DROP INDEX IDX_590C103CFE419E2 ON experience');
        $this->addSql('ALTER TABLE experience ADD entreprise VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD duree VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP cv_id, DROP nom, DROP annee, DROP valeur, DROP description');
        $this->addSql('ALTER TABLE formation CHANGE annee formation_at VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE langue ADD value INT NOT NULL, CHANGE nom name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE logiciel CHANGE nom name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE valeur value INT NOT NULL');
    }
}
