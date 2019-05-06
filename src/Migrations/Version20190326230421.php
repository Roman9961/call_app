<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190326230421 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE calling_task_calling_time (calling_task_id INT NOT NULL, calling_time_id INT NOT NULL, INDEX IDX_B217E1EC6C3A4F8F (calling_task_id), INDEX IDX_B217E1ECBF669332 (calling_time_id), PRIMARY KEY(calling_task_id, calling_time_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calling_task_calling_time ADD CONSTRAINT FK_B217E1EC6C3A4F8F FOREIGN KEY (calling_task_id) REFERENCES calling_task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE calling_task_calling_time ADD CONSTRAINT FK_B217E1ECBF669332 FOREIGN KEY (calling_time_id) REFERENCES calling_time (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE calling_time ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE calling_time ADD CONSTRAINT FK_31800BA8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_31800BA8A76ED395 ON calling_time (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE calling_task_calling_time');
        $this->addSql('ALTER TABLE calling_time DROP FOREIGN KEY FK_31800BA8A76ED395');
        $this->addSql('DROP INDEX IDX_31800BA8A76ED395 ON calling_time');
        $this->addSql('ALTER TABLE calling_time DROP user_id');
    }
}
