<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240809153657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE illustrations (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, illustration VARCHAR(255) NOT NULL, thumbnail VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, limit_age INT NOT NULL, price INT DEFAULT NULL, INDEX IDX_830A942DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE illustrations_category (illustrations_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_CCACBA66A32CB600 (illustrations_id), INDEX IDX_CCACBA6612469DE2 (category_id), PRIMARY KEY(illustrations_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE illustrations ADD CONSTRAINT FK_830A942DA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE illustrations_category ADD CONSTRAINT FK_CCACBA66A32CB600 FOREIGN KEY (illustrations_id) REFERENCES illustrations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE illustrations_category ADD CONSTRAINT FK_CCACBA6612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE illustrations DROP FOREIGN KEY FK_830A942DA76ED395');
        $this->addSql('ALTER TABLE illustrations_category DROP FOREIGN KEY FK_CCACBA66A32CB600');
        $this->addSql('ALTER TABLE illustrations_category DROP FOREIGN KEY FK_CCACBA6612469DE2');
        $this->addSql('DROP TABLE illustrations');
        $this->addSql('DROP TABLE illustrations_category');
    }
}
