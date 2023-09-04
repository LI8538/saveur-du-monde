<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230904065655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_purchase (product_id INT NOT NULL, purchase_id INT NOT NULL, INDEX IDX_AAA7BBAC4584665A (product_id), INDEX IDX_AAA7BBAC558FBEB9 (purchase_id), PRIMARY KEY(product_id, purchase_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_purchase ADD CONSTRAINT FK_AAA7BBAC4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_purchase ADD CONSTRAINT FK_AAA7BBAC558FBEB9 FOREIGN KEY (purchase_id) REFERENCES purchase (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD quantity INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_purchase DROP FOREIGN KEY FK_AAA7BBAC4584665A');
        $this->addSql('ALTER TABLE product_purchase DROP FOREIGN KEY FK_AAA7BBAC558FBEB9');
        $this->addSql('DROP TABLE product_purchase');
        $this->addSql('ALTER TABLE product DROP quantity');
    }
}
