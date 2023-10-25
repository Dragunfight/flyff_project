<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230928124030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993988C0FA77');
        $this->addSql('DROP INDEX IDX_F52993988C0FA77 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP order_details_id');
        $this->addSql('ALTER TABLE order_detail ADD product_id INT NOT NULL, ADD order_associated_id INT NOT NULL');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F464584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F46E24BFBC FOREIGN KEY (order_associated_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_ED896F464584665A ON order_detail (product_id)');
        $this->addSql('CREATE INDEX IDX_ED896F46E24BFBC ON order_detail (order_associated_id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD64577843');
        $this->addSql('DROP INDEX IDX_D34A04AD64577843 ON product');
        $this->addSql('ALTER TABLE product DROP order_detail_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD order_details_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993988C0FA77 FOREIGN KEY (order_details_id) REFERENCES order_detail (id)');
        $this->addSql('CREATE INDEX IDX_F52993988C0FA77 ON `order` (order_details_id)');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F464584665A');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F46E24BFBC');
        $this->addSql('DROP INDEX IDX_ED896F464584665A ON order_detail');
        $this->addSql('DROP INDEX IDX_ED896F46E24BFBC ON order_detail');
        $this->addSql('ALTER TABLE order_detail DROP product_id, DROP order_associated_id');
        $this->addSql('ALTER TABLE product ADD order_detail_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD64577843 FOREIGN KEY (order_detail_id) REFERENCES order_detail (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD64577843 ON product (order_detail_id)');
    }
}
