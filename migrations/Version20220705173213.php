<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705173213 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pet DROP FOREIGN KEY FK_E4529B8572502E8A');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B8572502E8A FOREIGN KEY (necklace_id) REFERENCES necklace (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pet DROP FOREIGN KEY FK_E4529B8572502E8A');
        $this->addSql('ALTER TABLE pet ADD CONSTRAINT FK_E4529B8572502E8A FOREIGN KEY (necklace_id) REFERENCES necklace (id)');
    }
}
