<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240816143720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE illustrations ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, CHANGE user_id user_id INT NOT NULL, CHANGE limit_age limit_age INT NOT NULL, CHANGE views views INT NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE born_at born_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE illustrations DROP created_at, DROP updated_at, CHANGE user_id user_id INT DEFAULT NULL, CHANGE limit_age limit_age INT DEFAULT NULL, CHANGE views views INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE born_at born_at DATETIME DEFAULT NULL');
    }
}
