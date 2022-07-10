<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707135026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture ADD pet_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, ADD picture_path VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89966F7FB6 FOREIGN KEY (pet_id) REFERENCES pet (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_16DB4F89966F7FB6 ON picture (pet_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_16DB4F89A76ED395 ON picture (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89966F7FB6');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89A76ED395');
        $this->addSql('DROP INDEX UNIQ_16DB4F89966F7FB6 ON picture');
        $this->addSql('DROP INDEX UNIQ_16DB4F89A76ED395 ON picture');
        $this->addSql('ALTER TABLE picture DROP pet_id, DROP user_id, DROP picture_path');
    }
}
