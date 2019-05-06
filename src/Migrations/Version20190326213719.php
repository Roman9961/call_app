<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190326213719 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE calling_list (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calling_list_client_msisdn (calling_list_id INT NOT NULL, client_msisdn_id INT NOT NULL, INDEX IDX_EB4413CCDC225882 (calling_list_id), INDEX IDX_EB4413CC3F090FE7 (client_msisdn_id), PRIMARY KEY(calling_list_id, client_msisdn_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client_msisdn (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calling_time (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, calling_day INT NOT NULL, start_calling_time TIME NOT NULL, end_calling_time TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calling_task (id INT AUTO_INCREMENT NOT NULL, calling_list_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C6A48C8DC225882 (calling_list_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE calling_list_client_msisdn ADD CONSTRAINT FK_EB4413CCDC225882 FOREIGN KEY (calling_list_id) REFERENCES calling_list (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE calling_list_client_msisdn ADD CONSTRAINT FK_EB4413CC3F090FE7 FOREIGN KEY (client_msisdn_id) REFERENCES client_msisdn (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE calling_task ADD CONSTRAINT FK_C6A48C8DC225882 FOREIGN KEY (calling_list_id) REFERENCES calling_list (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE calling_list_client_msisdn DROP FOREIGN KEY FK_EB4413CCDC225882');
        $this->addSql('ALTER TABLE calling_task DROP FOREIGN KEY FK_C6A48C8DC225882');
        $this->addSql('ALTER TABLE calling_list_client_msisdn DROP FOREIGN KEY FK_EB4413CC3F090FE7');
        $this->addSql('DROP TABLE calling_list');
        $this->addSql('DROP TABLE calling_list_client_msisdn');
        $this->addSql('DROP TABLE client_msisdn');
        $this->addSql('DROP TABLE calling_time');
        $this->addSql('DROP TABLE calling_task');
    }
}
