<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240821141346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE illustration (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, illustration VARCHAR(255) NOT NULL, thumbnail VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, limit_age INT NOT NULL, price INT DEFAULT NULL, views INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D67B9A42A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE illustration_category (illustration_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_4CA0A4FA5926566C (illustration_id), INDEX IDX_4CA0A4FA12469DE2 (category_id), PRIMARY KEY(illustration_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, born_at DATETIME NOT NULL, pseudo VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE illustration ADD CONSTRAINT FK_D67B9A42A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE illustration_category ADD CONSTRAINT FK_4CA0A4FA5926566C FOREIGN KEY (illustration_id) REFERENCES illustration (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE illustration_category ADD CONSTRAINT FK_4CA0A4FA12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE illustrations DROP FOREIGN KEY FK_830A942DA76ED395');
        $this->addSql('ALTER TABLE illustrations_category DROP FOREIGN KEY FK_CCACBA66A32CB600');
        $this->addSql('ALTER TABLE illustrations_category DROP FOREIGN KEY FK_CCACBA6612469DE2');
        $this->addSql('DROP TABLE illustrations');
        $this->addSql('DROP TABLE illustrations_category');
        $this->addSql('DROP TABLE users');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE illustrations (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, illustration VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, thumbnail VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, limit_age INT DEFAULT NULL, price INT DEFAULT NULL, views INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_830A942DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE illustrations_category (illustrations_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_CCACBA66A32CB600 (illustrations_id), INDEX IDX_CCACBA6612469DE2 (category_id), PRIMARY KEY(illustrations_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles JSON NOT NULL, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, firstname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, born_at DATETIME DEFAULT NULL, pseudo VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE illustrations ADD CONSTRAINT FK_830A942DA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE illustrations_category ADD CONSTRAINT FK_CCACBA66A32CB600 FOREIGN KEY (illustrations_id) REFERENCES illustrations (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE illustrations_category ADD CONSTRAINT FK_CCACBA6612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE illustration DROP FOREIGN KEY FK_D67B9A42A76ED395');
        $this->addSql('ALTER TABLE illustration_category DROP FOREIGN KEY FK_4CA0A4FA5926566C');
        $this->addSql('ALTER TABLE illustration_category DROP FOREIGN KEY FK_4CA0A4FA12469DE2');
        $this->addSql('DROP TABLE illustration');
        $this->addSql('DROP TABLE illustration_category');
        $this->addSql('DROP TABLE user');
    }
}
