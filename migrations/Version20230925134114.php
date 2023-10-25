<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230925134114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `character` ADD game_account_id INT NOT NULL');
        $this->addSql('ALTER TABLE `character` ADD CONSTRAINT FK_937AB03475B79857 FOREIGN KEY (game_account_id) REFERENCES game_account (id)');
        $this->addSql('CREATE INDEX IDX_937AB03475B79857 ON `character` (game_account_id)');
        $this->addSql('ALTER TABLE game_account ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE game_account ADD CONSTRAINT FK_E8F4298BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E8F4298BA76ED395 ON game_account (user_id)');
        $this->addSql('ALTER TABLE `order` ADD order_details_id INT NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993988C0FA77 FOREIGN KEY (order_details_id) REFERENCES order_detail (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F52993988C0FA77 ON `order` (order_details_id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
        $this->addSql('ALTER TABLE post ADD categories_id INT NOT NULL, ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA21214B7 FOREIGN KEY (categories_id) REFERENCES post_category (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DA21214B7 ON post (categories_id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DA76ED395 ON post (user_id)');
        $this->addSql('ALTER TABLE product ADD categories_id INT NOT NULL, ADD order_detail_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADA21214B7 FOREIGN KEY (categories_id) REFERENCES product_category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD64577843 FOREIGN KEY (order_detail_id) REFERENCES order_detail (id)');
        $this->addSql('CREATE INDEX IDX_D34A04ADA21214B7 ON product (categories_id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD64577843 ON product (order_detail_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `character` DROP FOREIGN KEY FK_937AB03475B79857');
        $this->addSql('DROP INDEX IDX_937AB03475B79857 ON `character`');
        $this->addSql('ALTER TABLE `character` DROP game_account_id');
        $this->addSql('ALTER TABLE game_account DROP FOREIGN KEY FK_E8F4298BA76ED395');
        $this->addSql('DROP INDEX IDX_E8F4298BA76ED395 ON game_account');
        $this->addSql('ALTER TABLE game_account DROP user_id');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993988C0FA77');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F52993988C0FA77 ON `order`');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP order_details_id, DROP user_id');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA21214B7');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA76ED395');
        $this->addSql('DROP INDEX IDX_5A8A6C8DA21214B7 ON post');
        $this->addSql('DROP INDEX IDX_5A8A6C8DA76ED395 ON post');
        $this->addSql('ALTER TABLE post DROP categories_id, DROP user_id');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADA21214B7');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD64577843');
        $this->addSql('DROP INDEX IDX_D34A04ADA21214B7 ON product');
        $this->addSql('DROP INDEX IDX_D34A04AD64577843 ON product');
        $this->addSql('ALTER TABLE product DROP categories_id, DROP order_detail_id');
    }
}
