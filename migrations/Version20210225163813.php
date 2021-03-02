<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210225163813 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA9F2C56620');
        $this->addSql('DROP INDEX UNIQ_64C19AA9F2C56620 ON agence');
        $this->addSql('ALTER TABLE agence DROP compte_id');
        $this->addSql('ALTER TABLE compte_de_transaction ADD agence_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE compte_de_transaction ADD CONSTRAINT FK_C020B78BD725330D FOREIGN KEY (agence_id) REFERENCES agence (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C020B78BD725330D ON compte_de_transaction (agence_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agence ADD compte_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA9F2C56620 FOREIGN KEY (compte_id) REFERENCES compte_de_transaction (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19AA9F2C56620 ON agence (compte_id)');
        $this->addSql('ALTER TABLE compte_de_transaction DROP FOREIGN KEY FK_C020B78BD725330D');
        $this->addSql('DROP INDEX UNIQ_C020B78BD725330D ON compte_de_transaction');
        $this->addSql('ALTER TABLE compte_de_transaction DROP agence_id');
    }
}
