<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220102150444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE social ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE social ADD CONSTRAINT FK_7161E187A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7161E187A76ED395 ON social (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE social DROP FOREIGN KEY FK_7161E187A76ED395');
        $this->addSql('DROP INDEX IDX_7161E187A76ED395 ON social');
        $this->addSql('ALTER TABLE social DROP user_id');
    }
}
