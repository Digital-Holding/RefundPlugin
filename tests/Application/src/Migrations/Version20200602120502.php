<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200602120502 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sylius_refund_application_reason (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, type VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8EA168E377153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_refund_request (id INT AUTO_INCREMENT NOT NULL, shop_user_id INT DEFAULT NULL, channel_id INT DEFAULT NULL, order_id INT DEFAULT NULL, application_reason_id INT NOT NULL, state VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_BA973537A45D93BF (shop_user_id), INDEX IDX_BA97353772F5A1AA (channel_id), INDEX IDX_BA9735378D9F6D38 (order_id), INDEX IDX_BA973537DDBA6F93 (application_reason_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_refund_request_message (id INT AUTO_INCREMENT NOT NULL, shop_user_id INT DEFAULT NULL, admin_user_id INT DEFAULT NULL, refund_request_id INT NOT NULL, datetime DATETIME NOT NULL, message VARCHAR(255) NOT NULL, INDEX IDX_EDB237DDA45D93BF (shop_user_id), INDEX IDX_EDB237DD6352511C (admin_user_id), INDEX IDX_EDB237DDA184CB09 (refund_request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_tax_item (id INT AUTO_INCREMENT NOT NULL, `label` VARCHAR(255) NOT NULL, amount INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_shop_billing_data (id INT AUTO_INCREMENT NOT NULL, company VARCHAR(255) DEFAULT NULL, tax_id VARCHAR(255) DEFAULT NULL, country_code VARCHAR(255) DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, postcode VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_refund_request_message_file (id INT AUTO_INCREMENT NOT NULL, refund_request_message_id INT NOT NULL, hash VARCHAR(255) NOT NULL, file_name VARCHAR(255) NOT NULL, mime_type VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_E0299A24E09C6B96 (refund_request_message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_line_item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, quantity INT NOT NULL, unit_net_price INT NOT NULL, unit_gross_price INT NOT NULL, net_value INT NOT NULL, gross_value INT NOT NULL, tax_amount INT NOT NULL, tax_rate VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_unreaded_refund_request_message (id INT AUTO_INCREMENT NOT NULL, shop_user_id INT DEFAULT NULL, refund_request_message_id INT NOT NULL, INDEX IDX_BA17B51DA45D93BF (shop_user_id), INDEX IDX_BA17B51DE09C6B96 (refund_request_message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_refund_payment (id INT AUTO_INCREMENT NOT NULL, payment_method_id INT DEFAULT NULL, order_number VARCHAR(255) NOT NULL, amount INT NOT NULL, currency_code VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, INDEX IDX_EC283EA55AA1164F (payment_method_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_credit_memo_sequence (id INT AUTO_INCREMENT NOT NULL, idx INT NOT NULL, version INT DEFAULT 1 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_customer_billing_data (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, street VARCHAR(255) NOT NULL, postcode VARCHAR(255) NOT NULL, country_code VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, company VARCHAR(255) DEFAULT NULL, province_name VARCHAR(255) DEFAULT NULL, province_code VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_credit_memo (id VARCHAR(255) NOT NULL, from_id INT DEFAULT NULL, to_id INT DEFAULT NULL, channel_id INT DEFAULT NULL, order_id INT DEFAULT NULL, number VARCHAR(255) NOT NULL, total INT NOT NULL, currency_code VARCHAR(255) NOT NULL, locale_code VARCHAR(255) NOT NULL, comment LONGTEXT NOT NULL, issued_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_5C4F333196901F54 (number), UNIQUE INDEX UNIQ_5C4F333178CED90B (from_id), UNIQUE INDEX UNIQ_5C4F333130354A65 (to_id), INDEX IDX_5C4F333172F5A1AA (channel_id), INDEX IDX_5C4F33318D9F6D38 (order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_credit_memo_line_items (credit_memo_id VARCHAR(255) NOT NULL, line_item_id INT NOT NULL, INDEX IDX_1453B90E8E574316 (credit_memo_id), UNIQUE INDEX UNIQ_1453B90EA7CBD339 (line_item_id), PRIMARY KEY(credit_memo_id, line_item_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_credit_memo_tax_items (credit_memo_id VARCHAR(255) NOT NULL, tax_item_id INT NOT NULL, INDEX IDX_9BBDFBE28E574316 (credit_memo_id), UNIQUE INDEX UNIQ_9BBDFBE25327F254 (tax_item_id), PRIMARY KEY(credit_memo_id, tax_item_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_refund (id INT AUTO_INCREMENT NOT NULL, order_number VARCHAR(255) NOT NULL, amount INT NOT NULL, refunded_unit_id INT DEFAULT NULL, type VARCHAR(256) NOT NULL COMMENT \'(DC2Type:sylius_refund_refund_type)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_refund_application_reason_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_D7C5EBC62C2AC5D3 (translatable_id), UNIQUE INDEX sylius_refund_application_reason_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sylius_refund_refund_request ADD CONSTRAINT FK_BA973537A45D93BF FOREIGN KEY (shop_user_id) REFERENCES sylius_shop_user (id)');
        $this->addSql('ALTER TABLE sylius_refund_refund_request ADD CONSTRAINT FK_BA97353772F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id)');
        $this->addSql('ALTER TABLE sylius_refund_refund_request ADD CONSTRAINT FK_BA9735378D9F6D38 FOREIGN KEY (order_id) REFERENCES sylius_order (id)');
        $this->addSql('ALTER TABLE sylius_refund_refund_request ADD CONSTRAINT FK_BA973537DDBA6F93 FOREIGN KEY (application_reason_id) REFERENCES sylius_refund_application_reason (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_refund_refund_request_message ADD CONSTRAINT FK_EDB237DDA45D93BF FOREIGN KEY (shop_user_id) REFERENCES sylius_shop_user (id)');
        $this->addSql('ALTER TABLE sylius_refund_refund_request_message ADD CONSTRAINT FK_EDB237DD6352511C FOREIGN KEY (admin_user_id) REFERENCES sylius_admin_user (id)');
        $this->addSql('ALTER TABLE sylius_refund_refund_request_message ADD CONSTRAINT FK_EDB237DDA184CB09 FOREIGN KEY (refund_request_id) REFERENCES sylius_refund_refund_request (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sylius_refund_refund_request_message_file ADD CONSTRAINT FK_E0299A24E09C6B96 FOREIGN KEY (refund_request_message_id) REFERENCES sylius_refund_refund_request_message (id)');
        $this->addSql('ALTER TABLE sylius_refund_unreaded_refund_request_message ADD CONSTRAINT FK_BA17B51DA45D93BF FOREIGN KEY (shop_user_id) REFERENCES sylius_shop_user (id)');
        $this->addSql('ALTER TABLE sylius_refund_unreaded_refund_request_message ADD CONSTRAINT FK_BA17B51DE09C6B96 FOREIGN KEY (refund_request_message_id) REFERENCES sylius_refund_refund_request_message (id)');
        $this->addSql('ALTER TABLE sylius_refund_refund_payment ADD CONSTRAINT FK_EC283EA55AA1164F FOREIGN KEY (payment_method_id) REFERENCES sylius_payment_method (id)');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo ADD CONSTRAINT FK_5C4F333178CED90B FOREIGN KEY (from_id) REFERENCES sylius_refund_customer_billing_data (id)');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo ADD CONSTRAINT FK_5C4F333130354A65 FOREIGN KEY (to_id) REFERENCES sylius_refund_shop_billing_data (id)');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo ADD CONSTRAINT FK_5C4F333172F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id)');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo ADD CONSTRAINT FK_5C4F33318D9F6D38 FOREIGN KEY (order_id) REFERENCES sylius_order (id)');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo_line_items ADD CONSTRAINT FK_1453B90E8E574316 FOREIGN KEY (credit_memo_id) REFERENCES sylius_refund_credit_memo (id)');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo_line_items ADD CONSTRAINT FK_1453B90EA7CBD339 FOREIGN KEY (line_item_id) REFERENCES sylius_refund_line_item (id)');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo_tax_items ADD CONSTRAINT FK_9BBDFBE28E574316 FOREIGN KEY (credit_memo_id) REFERENCES sylius_refund_credit_memo (id)');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo_tax_items ADD CONSTRAINT FK_9BBDFBE25327F254 FOREIGN KEY (tax_item_id) REFERENCES sylius_refund_tax_item (id)');
        $this->addSql('ALTER TABLE sylius_refund_application_reason_translation ADD CONSTRAINT FK_D7C5EBC62C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES sylius_refund_application_reason (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_refund_refund_request DROP FOREIGN KEY FK_BA973537DDBA6F93');
        $this->addSql('ALTER TABLE sylius_refund_application_reason_translation DROP FOREIGN KEY FK_D7C5EBC62C2AC5D3');
        $this->addSql('ALTER TABLE sylius_refund_refund_request_message DROP FOREIGN KEY FK_EDB237DDA184CB09');
        $this->addSql('ALTER TABLE sylius_refund_refund_request_message_file DROP FOREIGN KEY FK_E0299A24E09C6B96');
        $this->addSql('ALTER TABLE sylius_refund_unreaded_refund_request_message DROP FOREIGN KEY FK_BA17B51DE09C6B96');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo_tax_items DROP FOREIGN KEY FK_9BBDFBE25327F254');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo DROP FOREIGN KEY FK_5C4F333130354A65');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo_line_items DROP FOREIGN KEY FK_1453B90EA7CBD339');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo DROP FOREIGN KEY FK_5C4F333178CED90B');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo_line_items DROP FOREIGN KEY FK_1453B90E8E574316');
        $this->addSql('ALTER TABLE sylius_refund_credit_memo_tax_items DROP FOREIGN KEY FK_9BBDFBE28E574316');
        $this->addSql('DROP TABLE sylius_refund_application_reason');
        $this->addSql('DROP TABLE sylius_refund_refund_request');
        $this->addSql('DROP TABLE sylius_refund_refund_request_message');
        $this->addSql('DROP TABLE sylius_refund_tax_item');
        $this->addSql('DROP TABLE sylius_refund_shop_billing_data');
        $this->addSql('DROP TABLE sylius_refund_refund_request_message_file');
        $this->addSql('DROP TABLE sylius_refund_line_item');
        $this->addSql('DROP TABLE sylius_refund_unreaded_refund_request_message');
        $this->addSql('DROP TABLE sylius_refund_refund_payment');
        $this->addSql('DROP TABLE sylius_refund_credit_memo_sequence');
        $this->addSql('DROP TABLE sylius_refund_customer_billing_data');
        $this->addSql('DROP TABLE sylius_refund_credit_memo');
        $this->addSql('DROP TABLE sylius_refund_credit_memo_line_items');
        $this->addSql('DROP TABLE sylius_refund_credit_memo_tax_items');
        $this->addSql('DROP TABLE sylius_refund_refund');
        $this->addSql('DROP TABLE sylius_refund_application_reason_translation');
    }
}
