<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200828142251 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE buyer (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE command (id INT AUTO_INCREMENT NOT NULL, buyer_id INT NOT NULL, customer_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_8ECAEAD46C755722 (buyer_id), INDEX IDX_8ECAEAD49395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer_buyer (customer_id INT NOT NULL, buyer_id INT NOT NULL, INDEX IDX_4AA52A889395C3F3 (customer_id), INDEX IDX_4AA52A886C755722 (buyer_id), PRIMARY KEY(customer_id, buyer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lineCommand (id INT AUTO_INCREMENT NOT NULL, command_id INT NOT NULL, phone_id INT NOT NULL, number INT NOT NULL, INDEX IDX_3B75BEA33E1689A (command_id), INDEX IDX_3B75BEA3B7323CB (phone_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE phone (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, image VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, number INT NOT NULL, number_sold INT NOT NULL, active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, connected_at DATETIME DEFAULT NULL, email VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D76BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD46C755722 FOREIGN KEY (buyer_id) REFERENCES buyer (id)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD49395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09BF396750 FOREIGN KEY (id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer_buyer ADD CONSTRAINT FK_4AA52A889395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer_buyer ADD CONSTRAINT FK_4AA52A886C755722 FOREIGN KEY (buyer_id) REFERENCES buyer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lineCommand ADD CONSTRAINT FK_3B75BEA33E1689A FOREIGN KEY (command_id) REFERENCES command (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lineCommand ADD CONSTRAINT FK_3B75BEA3B7323CB FOREIGN KEY (phone_id) REFERENCES phone (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD46C755722');
        $this->addSql('ALTER TABLE customer_buyer DROP FOREIGN KEY FK_4AA52A886C755722');
        $this->addSql('ALTER TABLE lineCommand DROP FOREIGN KEY FK_3B75BEA33E1689A');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD49395C3F3');
        $this->addSql('ALTER TABLE customer_buyer DROP FOREIGN KEY FK_4AA52A889395C3F3');
        $this->addSql('ALTER TABLE lineCommand DROP FOREIGN KEY FK_3B75BEA3B7323CB');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D76BF396750');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09BF396750');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE buyer');
        $this->addSql('DROP TABLE command');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE customer_buyer');
        $this->addSql('DROP TABLE lineCommand');
        $this->addSql('DROP TABLE phone');
        $this->addSql('DROP TABLE user');
    }
}
