<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230330120738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tournois_sports (tournois_id INT NOT NULL, sports_id INT NOT NULL, INDEX IDX_9D7D5A5752534C (tournois_id), INDEX IDX_9D7D5A554BBBFB7 (sports_id), PRIMARY KEY(tournois_id, sports_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tournois_sports ADD CONSTRAINT FK_9D7D5A5752534C FOREIGN KEY (tournois_id) REFERENCES tournois (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tournois_sports ADD CONSTRAINT FK_9D7D5A554BBBFB7 FOREIGN KEY (sports_id) REFERENCES sports (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tournois_sports DROP FOREIGN KEY FK_9D7D5A5752534C');
        $this->addSql('ALTER TABLE tournois_sports DROP FOREIGN KEY FK_9D7D5A554BBBFB7');
        $this->addSql('DROP TABLE tournois_sports');
    }
}
