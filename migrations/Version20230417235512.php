<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230417235512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFBA832C1C9');
        $this->addSql('DROP INDEX UNIQ_3E7B0BFBA832C1C9 ON response');
        $this->addSql('ALTER TABLE response ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE email_id reclamation_id INT DEFAULT NULL, CHANGE description content VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFB2D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('CREATE INDEX IDX_3E7B0BFB2D6BA2D9 ON response (reclamation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFB2D6BA2D9');
        $this->addSql('DROP INDEX IDX_3E7B0BFB2D6BA2D9 ON response');
        $this->addSql('ALTER TABLE response DROP created_at, CHANGE reclamation_id email_id INT DEFAULT NULL, CHANGE content description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFBA832C1C9 FOREIGN KEY (email_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3E7B0BFBA832C1C9 ON response (email_id)');
    }
}
