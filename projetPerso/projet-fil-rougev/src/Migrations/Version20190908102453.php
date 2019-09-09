<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190908102453 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction ADD envoyeur_id INT NOT NULL, ADD benef_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D14795A786 FOREIGN KEY (envoyeur_id) REFERENCES envoyer (id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D1CA033907 FOREIGN KEY (benef_id) REFERENCES beneficiaire (id)');
        $this->addSql('CREATE INDEX IDX_723705D14795A786 ON transaction (envoyeur_id)');
        $this->addSql('CREATE INDEX IDX_723705D1CA033907 ON transaction (benef_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D14795A786');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1CA033907');
        $this->addSql('DROP INDEX IDX_723705D14795A786 ON transaction');
        $this->addSql('DROP INDEX IDX_723705D1CA033907 ON transaction');
        $this->addSql('ALTER TABLE transaction DROP envoyeur_id, DROP benef_id');
    }
}
