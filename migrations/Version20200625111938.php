<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200625111938 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE child (id INT AUTO_INCREMENT NOT NULL, photo VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, date_naissance DATETIME NOT NULL, adresse VARCHAR(255) NOT NULL, code_postal VARCHAR(255) NOT NULL, ville VARCHAR(255) NOT NULL, securite_sociale VARCHAR(255) DEFAULT NULL, numero_caf VARCHAR(255) DEFAULT NULL, assurance_scolaire VARCHAR(255) DEFAULT NULL, nombre_freres INT DEFAULT NULL, nombre_soeurs INT DEFAULT NULL, profession_mere VARCHAR(255) DEFAULT NULL, profession_pere VARCHAR(255) DEFAULT NULL, telephone_domicile VARCHAR(255) DEFAULT NULL, telephone_pere VARCHAR(255) DEFAULT NULL, telephone_mere VARCHAR(255) DEFAULT NULL, observations VARCHAR(255) DEFAULT NULL, nom_medecin_traitant VARCHAR(255) DEFAULT NULL, telephone_medecin VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE child');
    }
}
