<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200605043303 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), UNIQUE INDEX UNIQ_880E0D76F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE clients (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, location VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales_order (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, admin_id INT NOT NULL, sales_order_no VARCHAR(255) NOT NULL, total_value DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_36D222E18B0BA53 (sales_order_no), INDEX IDX_36D222E19EB6921 (client_id), INDEX IDX_36D222E642B8210 (admin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales_order_item (id INT AUTO_INCREMENT NOT NULL, item_code VARCHAR(255) NOT NULL, item_description LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sales_order_mapping (id INT AUTO_INCREMENT NOT NULL, sales_order_id INT NOT NULL, sales_order_item_id INT NOT NULL, INDEX IDX_7ABAF372C023F51C (sales_order_id), INDEX IDX_7ABAF37221338DA6 (sales_order_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sales_order ADD CONSTRAINT FK_36D222E19EB6921 FOREIGN KEY (client_id) REFERENCES clients (id)');
        $this->addSql('ALTER TABLE sales_order ADD CONSTRAINT FK_36D222E642B8210 FOREIGN KEY (admin_id) REFERENCES admin (id)');
        $this->addSql('ALTER TABLE sales_order_mapping ADD CONSTRAINT FK_7ABAF372C023F51C FOREIGN KEY (sales_order_id) REFERENCES sales_order (id)');
        $this->addSql('ALTER TABLE sales_order_mapping ADD CONSTRAINT FK_7ABAF37221338DA6 FOREIGN KEY (sales_order_item_id) REFERENCES sales_order_item (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sales_order DROP FOREIGN KEY FK_36D222E642B8210');
        $this->addSql('ALTER TABLE sales_order DROP FOREIGN KEY FK_36D222E19EB6921');
        $this->addSql('ALTER TABLE sales_order_mapping DROP FOREIGN KEY FK_7ABAF372C023F51C');
        $this->addSql('ALTER TABLE sales_order_mapping DROP FOREIGN KEY FK_7ABAF37221338DA6');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE clients');
        $this->addSql('DROP TABLE sales_order');
        $this->addSql('DROP TABLE sales_order_item');
        $this->addSql('DROP TABLE sales_order_mapping');
    }
}
