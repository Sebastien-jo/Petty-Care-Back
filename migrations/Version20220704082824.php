<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220704082824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE necklace DROP FOREIGN KEY FK_52A27115A76ED395');
        $this->addSql('DROP INDEX IDX_52A27115A76ED395 ON necklace');
        $this->addSql('ALTER TABLE necklace DROP user_id, CHANGE pet_id pet_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pet DROP FOREIGN KEY FK_E4529B85B524FDDC');
        $this->addSql('DROP INDEX IDX_E4529B85B524FDDC ON pet');
        $this->addSql('ALTER TABLE pet CHANGE toy_id necklace_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B8572502E8A FOREIGN KEY (necklace_id) REFERENCES necklace (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E4529B8572502E8A ON pet (necklace_id)');
        $this->addSql('ALTER TABLE user CHANGE adress address VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE necklace ADD user_id INT NOT NULL, CHANGE pet_id pet_id INT NOT NULL');
        $this->addSql('ALTER TABLE necklace ADD CONSTRAINT FK_52A27115A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_52A27115A76ED395 ON necklace (user_id)');
        $this->addSql('ALTER TABLE pet DROP FOREIGN KEY FK_E4529B8572502E8A');
        $this->addSql('DROP INDEX UNIQ_E4529B8572502E8A ON pet');
        $this->addSql('ALTER TABLE pet CHANGE necklace_id toy_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B85B524FDDC FOREIGN KEY (toy_id) REFERENCES toy (id)');
        $this->addSql('CREATE INDEX IDX_E4529B85B524FDDC ON pet (toy_id)');
        $this->addSql('ALTER TABLE user CHANGE address adress VARCHAR(255) DEFAULT NULL');
    }
}
