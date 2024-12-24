<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241114072436 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE query CHANGE id id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE response CHANGE id id VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE undefined CHANGE id id VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE query CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE response CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE undefined CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
