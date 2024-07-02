<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702074541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE category_film (category_id INT NOT NULL, film_id INT NOT NULL, PRIMARY KEY(category_id, film_id))');
        $this->addSql('CREATE INDEX IDX_9DFC46512469DE2 ON category_film (category_id)');
        $this->addSql('CREATE INDEX IDX_9DFC465567F5183 ON category_film (film_id)');
        $this->addSql('ALTER TABLE category_film ADD CONSTRAINT FK_9DFC46512469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE category_film ADD CONSTRAINT FK_9DFC465567F5183 FOREIGN KEY (film_id) REFERENCES film (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('ALTER TABLE category_film DROP CONSTRAINT FK_9DFC46512469DE2');
        $this->addSql('ALTER TABLE category_film DROP CONSTRAINT FK_9DFC465567F5183');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE category_film');
    }
}
