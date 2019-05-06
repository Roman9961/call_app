<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190426132246 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE calling_time DROP FOREIGN KEY FK_31800BA8A76ED395');
        $this->addSql('ALTER TABLE calling_time ADD CONSTRAINT FK_31800BA8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE calling_list DROP FOREIGN KEY FK_1ADC6BF5A76ED395');
        $this->addSql('ALTER TABLE calling_list ADD CONSTRAINT FK_1ADC6BF5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE calling_task DROP FOREIGN KEY FK_C6A48C8A76ED395');
        $this->addSql('ALTER TABLE calling_task ADD CONSTRAINT FK_C6A48C8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE calling_list DROP FOREIGN KEY FK_1ADC6BF5A76ED395');
        $this->addSql('ALTER TABLE calling_list ADD CONSTRAINT FK_1ADC6BF5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE calling_task DROP FOREIGN KEY FK_C6A48C8A76ED395');
        $this->addSql('ALTER TABLE calling_task ADD CONSTRAINT FK_C6A48C8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE calling_time DROP FOREIGN KEY FK_31800BA8A76ED395');
        $this->addSql('ALTER TABLE calling_time ADD CONSTRAINT FK_31800BA8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }
}
