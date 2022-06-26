<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220626101107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE necklace ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE necklace ADD CONSTRAINT FK_52A27115A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_52A27115A76ED395 ON necklace (user_id)');
        $this->addSql('ALTER TABLE user ADD firstname VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD adress VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE necklace DROP FOREIGN KEY FK_52A27115A76ED395');
        $this->addSql('DROP INDEX IDX_52A27115A76ED395 ON necklace');
        $this->addSql('ALTER TABLE necklace DROP user_id');
        $this->addSql('ALTER TABLE user DROP firstname, DROP lastname, DROP adress');
    }
}
