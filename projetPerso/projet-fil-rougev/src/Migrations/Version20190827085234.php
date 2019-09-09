<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190827085234 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE compte_bancaire (id INT AUTO_INCREMENT NOT NULL, partenaire_id INT NOT NULL, numero_compte VARCHAR(255) NOT NULL, solde DOUBLE PRECISION NOT NULL, INDEX IDX_50BC21DE98DE13AC (partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, id_partenaire_id INT DEFAULT NULL, image_name VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, telephone INT NOT NULL, adresse VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, etat VARCHAR(255) NOT NULL, profil VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D64926F6C2C9 (id_partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE depot (id INT AUTO_INCREMENT NOT NULL, comptb_id INT DEFAULT NULL, montant BIGINT NOT NULL, date_depot DATETIME NOT NULL, INDEX IDX_47948BBC6F125E99 (comptb_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partenaires (id INT AUTO_INCREMENT NOT NULL, raison_social VARCHAR(255) NOT NULL, ninea VARCHAR(255) NOT NULL, adress VARCHAR(255) NOT NULL, telephon INT NOT NULL, etats VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE compte_bancaire ADD CONSTRAINT FK_50BC21DE98DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaires (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64926F6C2C9 FOREIGN KEY (id_partenaire_id) REFERENCES partenaires (id)');
        $this->addSql('ALTER TABLE depot ADD CONSTRAINT FK_47948BBC6F125E99 FOREIGN KEY (comptb_id) REFERENCES compte_bancaire (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE depot DROP FOREIGN KEY FK_47948BBC6F125E99');
        $this->addSql('ALTER TABLE compte_bancaire DROP FOREIGN KEY FK_50BC21DE98DE13AC');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64926F6C2C9');
        $this->addSql('DROP TABLE compte_bancaire');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE depot');
        $this->addSql('DROP TABLE partenaires');
    }
}
