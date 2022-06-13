<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613103010 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE toy (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, INDEX IDX_6705A76EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE toy ADD CONSTRAINT FK_6705A76EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pet ADD toy_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B85B524FDDC FOREIGN KEY (toy_id) REFERENCES toy (id)');
        $this->addSql('CREATE INDEX IDX_E4529B85B524FDDC ON pet (toy_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pet DROP FOREIGN KEY FK_E4529B85B524FDDC');
        $this->addSql('DROP TABLE toy');
        $this->addSql('DROP INDEX IDX_E4529B85B524FDDC ON pet');
        $this->addSql('ALTER TABLE pet DROP toy_id');
    }
}
