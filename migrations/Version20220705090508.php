<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705090508 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shop (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, stock INT NOT NULL, price VARCHAR(255) NOT NULL, ref VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pet ADD weight_goal DOUBLE PRECISION DEFAULT NULL, ADD status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE toy ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE toy ADD CONSTRAINT FK_6705A76EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6705A76EA76ED395 ON toy (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE shop');
        $this->addSql('ALTER TABLE pet DROP weight_goal, DROP status');
        $this->addSql('ALTER TABLE toy DROP FOREIGN KEY FK_6705A76EA76ED395');
        $this->addSql('DROP INDEX IDX_6705A76EA76ED395 ON toy');
        $this->addSql('ALTER TABLE toy DROP user_id');
    }
}
