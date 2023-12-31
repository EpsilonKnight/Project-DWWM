<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230414141543 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires ADD sport_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sports (id)');
        $this->addSql('CREATE INDEX IDX_D9BEC0C4AC78BCF8 ON commentaires (sport_id)');
        $this->addSql('ALTER TABLE sports DROP FOREIGN KEY FK_73C9F91C17C4B2B0');
        $this->addSql('DROP INDEX IDX_73C9F91C17C4B2B0 ON sports');
        $this->addSql('ALTER TABLE sports DROP commentaires_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4AC78BCF8');
        $this->addSql('DROP INDEX IDX_D9BEC0C4AC78BCF8 ON commentaires');
        $this->addSql('ALTER TABLE commentaires DROP sport_id');
        $this->addSql('ALTER TABLE sports ADD commentaires_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sports ADD CONSTRAINT FK_73C9F91C17C4B2B0 FOREIGN KEY (commentaires_id) REFERENCES commentaires (id)');
        $this->addSql('CREATE INDEX IDX_73C9F91C17C4B2B0 ON sports (commentaires_id)');
    }
}
