<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200828201655 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE line_command (id INT AUTO_INCREMENT NOT NULL, command_id INT NOT NULL, phone_id INT NOT NULL, number INT NOT NULL, INDEX IDX_3B6E6BB333E1689A (command_id), INDEX IDX_3B6E6BB33B7323CB (phone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE line_command ADD CONSTRAINT FK_3B6E6BB333E1689A FOREIGN KEY (command_id) REFERENCES command (id)');
        $this->addSql('ALTER TABLE line_command ADD CONSTRAINT FK_3B6E6BB33B7323CB FOREIGN KEY (phone_id) REFERENCES phone (id)');
        $this->addSql('DROP TABLE linecommand');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE linecommand (id INT AUTO_INCREMENT NOT NULL, command_id INT NOT NULL, phone_id INT NOT NULL, number INT NOT NULL, INDEX IDX_3B75BEA3B7323CB (phone_id), INDEX IDX_3B75BEA33E1689A (command_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE linecommand ADD CONSTRAINT FK_3B75BEA33E1689A FOREIGN KEY (command_id) REFERENCES command (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE linecommand ADD CONSTRAINT FK_3B75BEA3B7323CB FOREIGN KEY (phone_id) REFERENCES phone (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE line_command');
    }
}
