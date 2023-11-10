<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502074148 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE positions (id INT AUTO_INCREMENT NOT NULL, tournois_id INT DEFAULT NULL, positions INT DEFAULT NULL, INDEX IDX_D69FE57C752534C (tournois_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE positions ADD CONSTRAINT FK_D69FE57C752534C FOREIGN KEY (tournois_id) REFERENCES tournois (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE positions DROP FOREIGN KEY FK_D69FE57C752534C');
        $this->addSql('DROP TABLE positions');
    }
}
