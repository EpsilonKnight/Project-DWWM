<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230330112205 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE points_participants DROP FOREIGN KEY FK_868AD17654BBBFB7');
        $this->addSql('ALTER TABLE points_participants DROP FOREIGN KEY FK_868AD176752534C');
        $this->addSql('ALTER TABLE points_participants DROP FOREIGN KEY FK_868AD176838709D5');
        $this->addSql('DROP TABLE points_participants');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE points_participants (id INT AUTO_INCREMENT NOT NULL, participants_id INT DEFAULT NULL, sports_id INT DEFAULT NULL, tournois_id INT DEFAULT NULL, points DOUBLE PRECISION DEFAULT NULL, INDEX IDX_868AD176752534C (tournois_id), INDEX IDX_868AD176838709D5 (participants_id), INDEX IDX_868AD17654BBBFB7 (sports_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE points_participants ADD CONSTRAINT FK_868AD17654BBBFB7 FOREIGN KEY (sports_id) REFERENCES sports (id)');
        $this->addSql('ALTER TABLE points_participants ADD CONSTRAINT FK_868AD176752534C FOREIGN KEY (tournois_id) REFERENCES tournois (id)');
        $this->addSql('ALTER TABLE points_participants ADD CONSTRAINT FK_868AD176838709D5 FOREIGN KEY (participants_id) REFERENCES participants (id)');
    }
}
