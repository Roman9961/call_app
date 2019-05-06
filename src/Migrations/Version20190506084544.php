<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190506084544 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE files (id INT AUTO_INCREMENT NOT NULL, image_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD file_id INT DEFAULT NULL, DROP image');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64993CB796C FOREIGN KEY (file_id) REFERENCES files (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64993CB796C ON user (file_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64993CB796C');
        $this->addSql('DROP TABLE files');
        $this->addSql('DROP INDEX UNIQ_8D93D64993CB796C ON user');
        $this->addSql('ALTER TABLE user ADD image VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, DROP file_id');
    }
}
