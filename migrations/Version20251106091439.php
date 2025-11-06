<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251106091439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skin ADD weapon_id INT NOT NULL, DROP weapon');
        $this->addSql('ALTER TABLE skin ADD CONSTRAINT FK_279681E95B82273 FOREIGN KEY (weapon_id) REFERENCES weapon (id)');
        $this->addSql('CREATE INDEX IDX_279681E95B82273 ON skin (weapon_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE skin DROP FOREIGN KEY FK_279681E95B82273');
        $this->addSql('DROP INDEX IDX_279681E95B82273 ON skin');
        $this->addSql('ALTER TABLE skin ADD weapon VARCHAR(255) NOT NULL, DROP weapon_id');
    }
}
