<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230403094312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE trophees (id INT AUTO_INCREMENT NOT NULL, tournois_id INT DEFAULT NULL, sports_id INT DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, INDEX IDX_57B7B502752534C (tournois_id), INDEX IDX_57B7B50254BBBFB7 (sports_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trophees_participants (trophees_id INT NOT NULL, participants_id INT NOT NULL, INDEX IDX_8A5B7FB5A9726DDB (trophees_id), INDEX IDX_8A5B7FB5838709D5 (participants_id), PRIMARY KEY(trophees_id, participants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE trophees ADD CONSTRAINT FK_57B7B502752534C FOREIGN KEY (tournois_id) REFERENCES tournois (id)');
        $this->addSql('ALTER TABLE trophees ADD CONSTRAINT FK_57B7B50254BBBFB7 FOREIGN KEY (sports_id) REFERENCES sports (id)');
        $this->addSql('ALTER TABLE trophees_participants ADD CONSTRAINT FK_8A5B7FB5A9726DDB FOREIGN KEY (trophees_id) REFERENCES trophees (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE trophees_participants ADD CONSTRAINT FK_8A5B7FB5838709D5 FOREIGN KEY (participants_id) REFERENCES participants (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trophees DROP FOREIGN KEY FK_57B7B502752534C');
        $this->addSql('ALTER TABLE trophees DROP FOREIGN KEY FK_57B7B50254BBBFB7');
        $this->addSql('ALTER TABLE trophees_participants DROP FOREIGN KEY FK_8A5B7FB5A9726DDB');
        $this->addSql('ALTER TABLE trophees_participants DROP FOREIGN KEY FK_8A5B7FB5838709D5');
        $this->addSql('DROP TABLE trophees');
        $this->addSql('DROP TABLE trophees_participants');
    }
}
