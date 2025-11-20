<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251118061125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE exemplaire DROP FOREIGN KEY FK_5EF83C925843AA21');
        $this->addSql('DROP INDEX IDX_5EF83C925843AA21 ON exemplaire');
        $this->addSql('ALTER TABLE exemplaire DROP exemplaire_id');
        $this->addSql('ALTER TABLE ouvrage ADD editeur VARCHAR(100) NOT NULL, ADD categories JSON DEFAULT NULL, ADD tags JSON DEFAULT NULL, ADD annee INT DEFAULT NULL, DROP categorie, CHANGE isbn isbn VARCHAR(20) DEFAULT NULL, CHANGE langue langue VARCHAR(50) NOT NULL, CHANGE resume resume VARCHAR(2000) DEFAULT NULL, CHANGE auteur auteur VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ouvrage ADD categorie VARCHAR(255) DEFAULT NULL, DROP editeur, DROP categories, DROP tags, DROP annee, CHANGE auteur auteur VARCHAR(255) DEFAULT NULL, CHANGE isbn isbn VARCHAR(255) NOT NULL, CHANGE langue langue VARCHAR(255) DEFAULT NULL, CHANGE resume resume LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE exemplaire ADD exemplaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE exemplaire ADD CONSTRAINT FK_5EF83C925843AA21 FOREIGN KEY (exemplaire_id) REFERENCES exemplaire (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5EF83C925843AA21 ON exemplaire (exemplaire_id)');
    }
}
