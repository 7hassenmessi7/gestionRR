<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230416143503 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE like_dislike DROP FOREIGN KEY FK_ADB6A6893E2E969B');
        $this->addSql('ALTER TABLE like_dislike DROP FOREIGN KEY FK_ADB6A689A76ED395');
        $this->addSql('DROP TABLE like_dislike');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE like_dislike (id INT AUTO_INCREMENT NOT NULL, review_id INT NOT NULL, user_id INT DEFAULT NULL, type VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_ADB6A6893E2E969B (review_id), INDEX IDX_ADB6A689A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE like_dislike ADD CONSTRAINT FK_ADB6A6893E2E969B FOREIGN KEY (review_id) REFERENCES review (id)');
        $this->addSql('ALTER TABLE like_dislike ADD CONSTRAINT FK_ADB6A689A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }
}
