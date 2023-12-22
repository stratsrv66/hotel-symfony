<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231221052346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category_bedroom (category_id INT NOT NULL, bedroom_id INT NOT NULL, INDEX IDX_21CD032F12469DE2 (category_id), INDEX IDX_21CD032FBDB6797C (bedroom_id), PRIMARY KEY(category_id, bedroom_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, code_postal INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, equipment_bedroom_id INT DEFAULT NULL, label VARCHAR(255) NOT NULL, INDEX IDX_D338D58394BD8DA2 (equipment_bedroom_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, quantity INT NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category_bedroom ADD CONSTRAINT FK_21CD032F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_bedroom ADD CONSTRAINT FK_21CD032FBDB6797C FOREIGN KEY (bedroom_id) REFERENCES bedroom (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D58394BD8DA2 FOREIGN KEY (equipment_bedroom_id) REFERENCES bedroom (id)');
        $this->addSql('ALTER TABLE hotel ADD city_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hotel ADD CONSTRAINT FK_3535ED98BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('CREATE INDEX IDX_3535ED98BAC62AF ON hotel (city_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hotel DROP FOREIGN KEY FK_3535ED98BAC62AF');
        $this->addSql('ALTER TABLE category_bedroom DROP FOREIGN KEY FK_21CD032F12469DE2');
        $this->addSql('ALTER TABLE category_bedroom DROP FOREIGN KEY FK_21CD032FBDB6797C');
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D58394BD8DA2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_bedroom');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP INDEX IDX_3535ED98BAC62AF ON hotel');
        $this->addSql('ALTER TABLE hotel DROP city_id');
    }
}
