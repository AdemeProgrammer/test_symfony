<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250507073144 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation ADD ref_utilisateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955B61ED040 FOREIGN KEY (ref_utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_42C84955B61ED040 ON reservation (ref_utilisateur_id)');
        $this->addSql('ALTER TABLE vol ADD ref_pilote_id INT NOT NULL, ADD ref_id_pilote_id INT NOT NULL');
        $this->addSql('ALTER TABLE vol ADD CONSTRAINT FK_95C97EB864AABAC FOREIGN KEY (ref_pilote_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE vol ADD CONSTRAINT FK_95C97EB91D1D03D FOREIGN KEY (ref_id_pilote_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_95C97EB864AABAC ON vol (ref_pilote_id)');
        $this->addSql('CREATE INDEX IDX_95C97EB91D1D03D ON vol (ref_id_pilote_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955B61ED040');
        $this->addSql('DROP INDEX IDX_42C84955B61ED040 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP ref_utilisateur_id');
        $this->addSql('ALTER TABLE vol DROP FOREIGN KEY FK_95C97EB864AABAC');
        $this->addSql('ALTER TABLE vol DROP FOREIGN KEY FK_95C97EB91D1D03D');
        $this->addSql('DROP INDEX IDX_95C97EB864AABAC ON vol');
        $this->addSql('DROP INDEX IDX_95C97EB91D1D03D ON vol');
        $this->addSql('ALTER TABLE vol DROP ref_pilote_id, DROP ref_id_pilote_id');
    }
}
