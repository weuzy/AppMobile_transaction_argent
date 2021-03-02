<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210227130243 extends AbstractMigration
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
        $this->addSql('ALTER TABLE depot ADD comptes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBCDCED588B FOREIGN KEY (comptes_id) REFERENCES compte_de_transaction (id)');
        $this->addSql('CREATE INDEX IDX_47948BBCDCED588B ON depot (comptes_id)');
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
        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBCDCED588B');
        $this->addSql('DROP INDEX IDX_47948BBCDCED588B ON depot');
        $this->addSql('ALTER TABLE depot DROP comptes_id');
    }
}
