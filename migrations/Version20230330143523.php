<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230330143523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tournois_participants (tournois_id INT NOT NULL, participants_id INT NOT NULL, INDEX IDX_A13D3D00752534C (tournois_id), INDEX IDX_A13D3D00838709D5 (participants_id), PRIMARY KEY(tournois_id, participants_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tournois_participants ADD CONSTRAINT FK_A13D3D00752534C FOREIGN KEY (tournois_id) REFERENCES tournois (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tournois_participants ADD CONSTRAINT FK_A13D3D00838709D5 FOREIGN KEY (participants_id) REFERENCES participants (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tournois_participants DROP FOREIGN KEY FK_A13D3D00752534C');
        $this->addSql('ALTER TABLE tournois_participants DROP FOREIGN KEY FK_A13D3D00838709D5');
        $this->addSql('DROP TABLE tournois_participants');
    }
}
