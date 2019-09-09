<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190908171845 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE retrait DROP FOREIGN KEY FK_D9846A51A76ED395');
        $this->addSql('DROP INDEX IDX_D9846A51A76ED395 ON retrait');
        $this->addSql('ALTER TABLE retrait CHANGE user_id users_id INT NOT NULL');
        $this->addSql('ALTER TABLE retrait ADD CONSTRAINT FK_D9846A5167B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D9846A5167B3B43D ON retrait (users_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE retrait DROP FOREIGN KEY FK_D9846A5167B3B43D');
        $this->addSql('DROP INDEX IDX_D9846A5167B3B43D ON retrait');
        $this->addSql('ALTER TABLE retrait CHANGE users_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE retrait ADD CONSTRAINT FK_D9846A51A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_D9846A51A76ED395 ON retrait (user_id)');
    }
}
