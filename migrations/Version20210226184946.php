<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210226184946 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE type_de_transaction_client');
        $this->addSql('DROP TABLE type_de_transaction_user');
        $this->addSql('ALTER TABLE transaction ADD client_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, ADD is_depot TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D119EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_723705D119EB6921 ON transaction (client_id)');
        $this->addSql('CREATE INDEX IDX_723705D1A76ED395 ON transaction (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE type_de_transaction_client (id INT AUTO_INCREMENT NOT NULL, clients_id INT DEFAULT NULL, transactions_id INT DEFAULT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_845AB50BAB014612 (clients_id), INDEX IDX_845AB50B77E1607F (transactions_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE type_de_transaction_user (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, transactions_id INT DEFAULT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_D297284867B3B43D (users_id), INDEX IDX_D297284877E1607F (transactions_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE type_de_transaction_client ADD CONSTRAINT FK_845AB50B77E1607F FOREIGN KEY (transactions_id) REFERENCES transaction (id)');
        $this->addSql('ALTER TABLE type_de_transaction_client ADD CONSTRAINT FK_845AB50BAB014612 FOREIGN KEY (clients_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE type_de_transaction_user ADD CONSTRAINT FK_D297284867B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE type_de_transaction_user ADD CONSTRAINT FK_D297284877E1607F FOREIGN KEY (transactions_id) REFERENCES transaction (id)');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D119EB6921');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1A76ED395');
        $this->addSql('DROP INDEX IDX_723705D119EB6921 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D1A76ED395 ON transaction');
        $this->addSql('ALTER TABLE transaction DROP client_id, DROP user_id, DROP is_depot');
    }
}
