<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190509171426 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client_msisdn ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client_msisdn ADD CONSTRAINT FK_557EE0F7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client_msisdn ADD CONSTRAINT FK_557EE0F7727ACA70 FOREIGN KEY (parent_id) REFERENCES client_msisdn (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_557EE0F7A76ED395 ON client_msisdn (user_id)');
        $this->addSql('CREATE INDEX IDX_557EE0F7727ACA70 ON client_msisdn (parent_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client_msisdn DROP FOREIGN KEY FK_557EE0F7A76ED395');
        $this->addSql('ALTER TABLE client_msisdn DROP FOREIGN KEY FK_557EE0F7727ACA70');
        $this->addSql('DROP INDEX IDX_557EE0F7A76ED395 ON client_msisdn');
        $this->addSql('DROP INDEX IDX_557EE0F7727ACA70 ON client_msisdn');
        $this->addSql('ALTER TABLE client_msisdn DROP parent_id');
    }
}
