<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250410110849 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE `activity` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, max_capacity INT DEFAULT NULL, start_time DATETIME DEFAULT NULL, end_time DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE `booking` (id INT AUTO_INCREMENT NOT NULL, activity_id INT NOT NULL, user_name VARCHAR(255) DEFAULT NULL, booking_time DATETIME DEFAULT NULL, participants INT DEFAULT NULL, INDEX IDX_E00CEDDE81C06096 (activity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE `booking` ADD CONSTRAINT FK_E00CEDDE81C06096 FOREIGN KEY (activity_id) REFERENCES `activity` (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE `booking` DROP FOREIGN KEY FK_E00CEDDE81C06096
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `activity`
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE `booking`
        SQL);
    }
}
