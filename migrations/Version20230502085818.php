<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502085818 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participants DROP FOREIGN KEY FK_716970927813DDAE');
        $this->addSql('DROP INDEX IDX_716970927813DDAE ON participants');
        $this->addSql('ALTER TABLE participants DROP positions_id');
        $this->addSql('ALTER TABLE positions ADD participants_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE positions ADD CONSTRAINT FK_D69FE57C838709D5 FOREIGN KEY (participants_id) REFERENCES participants (id)');
        $this->addSql('CREATE INDEX IDX_D69FE57C838709D5 ON positions (participants_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participants ADD positions_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE participants ADD CONSTRAINT FK_716970927813DDAE FOREIGN KEY (positions_id) REFERENCES positions (id)');
        $this->addSql('CREATE INDEX IDX_716970927813DDAE ON participants (positions_id)');
        $this->addSql('ALTER TABLE positions DROP FOREIGN KEY FK_D69FE57C838709D5');
        $this->addSql('DROP INDEX IDX_D69FE57C838709D5 ON positions');
        $this->addSql('ALTER TABLE positions DROP participants_id');
    }
}
