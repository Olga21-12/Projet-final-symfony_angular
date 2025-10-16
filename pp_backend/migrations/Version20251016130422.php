<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251016130422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'toutes les relations';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bien_confort (bien_id INT NOT NULL, confort_id INT NOT NULL, INDEX IDX_C9154065BD95B80F (bien_id), INDEX IDX_C9154065706A77EF (confort_id), PRIMARY KEY(bien_id, confort_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recherche_types_de_bien (recherche_id INT NOT NULL, types_de_bien_id INT NOT NULL, INDEX IDX_7F2A00B11E6A4A07 (recherche_id), INDEX IDX_7F2A00B1B4E43F1C (types_de_bien_id), PRIMARY KEY(recherche_id, types_de_bien_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recherche_confort (recherche_id INT NOT NULL, confort_id INT NOT NULL, INDEX IDX_EEB80E4F1E6A4A07 (recherche_id), INDEX IDX_EEB80E4F706A77EF (confort_id), PRIMARY KEY(recherche_id, confort_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bien_confort ADD CONSTRAINT FK_C9154065BD95B80F FOREIGN KEY (bien_id) REFERENCES biens (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bien_confort ADD CONSTRAINT FK_C9154065706A77EF FOREIGN KEY (confort_id) REFERENCES conforts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recherche_types_de_bien ADD CONSTRAINT FK_7F2A00B11E6A4A07 FOREIGN KEY (recherche_id) REFERENCES recherches (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recherche_types_de_bien ADD CONSTRAINT FK_7F2A00B1B4E43F1C FOREIGN KEY (types_de_bien_id) REFERENCES types_de_bien (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recherche_confort ADD CONSTRAINT FK_EEB80E4F1E6A4A07 FOREIGN KEY (recherche_id) REFERENCES recherches (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recherche_confort ADD CONSTRAINT FK_EEB80E4F706A77EF FOREIGN KEY (confort_id) REFERENCES conforts (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE biens ADD user_id INT DEFAULT NULL, ADD emplacement_id INT DEFAULT NULL, ADD type_id INT DEFAULT NULL, ADD type_activite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE biens ADD CONSTRAINT FK_1F9004DDA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE biens ADD CONSTRAINT FK_1F9004DDC4598A51 FOREIGN KEY (emplacement_id) REFERENCES emplacements (id)');
        $this->addSql('ALTER TABLE biens ADD CONSTRAINT FK_1F9004DDC54C8C93 FOREIGN KEY (type_id) REFERENCES types_de_bien (id)');
        $this->addSql('ALTER TABLE biens ADD CONSTRAINT FK_1F9004DDD0165F20 FOREIGN KEY (type_activite_id) REFERENCES types_activite (id)');
        $this->addSql('CREATE INDEX IDX_1F9004DDA76ED395 ON biens (user_id)');
        $this->addSql('CREATE INDEX IDX_1F9004DDC4598A51 ON biens (emplacement_id)');
        $this->addSql('CREATE INDEX IDX_1F9004DDC54C8C93 ON biens (type_id)');
        $this->addSql('CREATE INDEX IDX_1F9004DDD0165F20 ON biens (type_activite_id)');
        $this->addSql('ALTER TABLE offres_vente ADD user_id INT DEFAULT NULL, ADD bien_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE offres_vente ADD CONSTRAINT FK_6D25F513A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE offres_vente ADD CONSTRAINT FK_6D25F513BD95B80F FOREIGN KEY (bien_id) REFERENCES biens (id)');
        $this->addSql('CREATE INDEX IDX_6D25F513A76ED395 ON offres_vente (user_id)');
        $this->addSql('CREATE INDEX IDX_6D25F513BD95B80F ON offres_vente (bien_id)');
        $this->addSql('ALTER TABLE photos ADD bien_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE photos ADD CONSTRAINT FK_876E0D9BD95B80F FOREIGN KEY (bien_id) REFERENCES biens (id)');
        $this->addSql('CREATE INDEX IDX_876E0D9BD95B80F ON photos (bien_id)');
        $this->addSql('ALTER TABLE recherches ADD user_id INT DEFAULT NULL, ADD emplacement_id INT DEFAULT NULL, ADD type_activite_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recherches ADD CONSTRAINT FK_84050CB5A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE recherches ADD CONSTRAINT FK_84050CB5C4598A51 FOREIGN KEY (emplacement_id) REFERENCES emplacements (id)');
        $this->addSql('ALTER TABLE recherches ADD CONSTRAINT FK_84050CB5D0165F20 FOREIGN KEY (type_activite_id) REFERENCES types_activite (id)');
        $this->addSql('CREATE INDEX IDX_84050CB5A76ED395 ON recherches (user_id)');
        $this->addSql('CREATE INDEX IDX_84050CB5C4598A51 ON recherches (emplacement_id)');
        $this->addSql('CREATE INDEX IDX_84050CB5D0165F20 ON recherches (type_activite_id)');
        $this->addSql('ALTER TABLE reservations ADD user_id INT DEFAULT NULL, ADD bien_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239BD95B80F FOREIGN KEY (bien_id) REFERENCES biens (id)');
        $this->addSql('CREATE INDEX IDX_4DA239A76ED395 ON reservations (user_id)');
        $this->addSql('CREATE INDEX IDX_4DA239BD95B80F ON reservations (bien_id)');
        $this->addSql('ALTER TABLE users ADD emplacement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9C4598A51 FOREIGN KEY (emplacement_id) REFERENCES emplacements (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E9C4598A51 ON users (emplacement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bien_confort DROP FOREIGN KEY FK_C9154065BD95B80F');
        $this->addSql('ALTER TABLE bien_confort DROP FOREIGN KEY FK_C9154065706A77EF');
        $this->addSql('ALTER TABLE recherche_types_de_bien DROP FOREIGN KEY FK_7F2A00B11E6A4A07');
        $this->addSql('ALTER TABLE recherche_types_de_bien DROP FOREIGN KEY FK_7F2A00B1B4E43F1C');
        $this->addSql('ALTER TABLE recherche_confort DROP FOREIGN KEY FK_EEB80E4F1E6A4A07');
        $this->addSql('ALTER TABLE recherche_confort DROP FOREIGN KEY FK_EEB80E4F706A77EF');
        $this->addSql('DROP TABLE bien_confort');
        $this->addSql('DROP TABLE recherche_types_de_bien');
        $this->addSql('DROP TABLE recherche_confort');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9C4598A51');
        $this->addSql('DROP INDEX IDX_1483A5E9C4598A51 ON users');
        $this->addSql('ALTER TABLE users DROP emplacement_id');
        $this->addSql('ALTER TABLE photos DROP FOREIGN KEY FK_876E0D9BD95B80F');
        $this->addSql('DROP INDEX IDX_876E0D9BD95B80F ON photos');
        $this->addSql('ALTER TABLE photos DROP bien_id');
        $this->addSql('ALTER TABLE biens DROP FOREIGN KEY FK_1F9004DDA76ED395');
        $this->addSql('ALTER TABLE biens DROP FOREIGN KEY FK_1F9004DDC4598A51');
        $this->addSql('ALTER TABLE biens DROP FOREIGN KEY FK_1F9004DDC54C8C93');
        $this->addSql('ALTER TABLE biens DROP FOREIGN KEY FK_1F9004DDD0165F20');
        $this->addSql('DROP INDEX IDX_1F9004DDA76ED395 ON biens');
        $this->addSql('DROP INDEX IDX_1F9004DDC4598A51 ON biens');
        $this->addSql('DROP INDEX IDX_1F9004DDC54C8C93 ON biens');
        $this->addSql('DROP INDEX IDX_1F9004DDD0165F20 ON biens');
        $this->addSql('ALTER TABLE biens DROP user_id, DROP emplacement_id, DROP type_id, DROP type_activite_id');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239A76ED395');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239BD95B80F');
        $this->addSql('DROP INDEX IDX_4DA239A76ED395 ON reservations');
        $this->addSql('DROP INDEX IDX_4DA239BD95B80F ON reservations');
        $this->addSql('ALTER TABLE reservations DROP user_id, DROP bien_id');
        $this->addSql('ALTER TABLE recherches DROP FOREIGN KEY FK_84050CB5A76ED395');
        $this->addSql('ALTER TABLE recherches DROP FOREIGN KEY FK_84050CB5C4598A51');
        $this->addSql('ALTER TABLE recherches DROP FOREIGN KEY FK_84050CB5D0165F20');
        $this->addSql('DROP INDEX IDX_84050CB5A76ED395 ON recherches');
        $this->addSql('DROP INDEX IDX_84050CB5C4598A51 ON recherches');
        $this->addSql('DROP INDEX IDX_84050CB5D0165F20 ON recherches');
        $this->addSql('ALTER TABLE recherches DROP user_id, DROP emplacement_id, DROP type_activite_id');
        $this->addSql('ALTER TABLE offres_vente DROP FOREIGN KEY FK_6D25F513A76ED395');
        $this->addSql('ALTER TABLE offres_vente DROP FOREIGN KEY FK_6D25F513BD95B80F');
        $this->addSql('DROP INDEX IDX_6D25F513A76ED395 ON offres_vente');
        $this->addSql('DROP INDEX IDX_6D25F513BD95B80F ON offres_vente');
        $this->addSql('ALTER TABLE offres_vente DROP user_id, DROP bien_id');
    }
}
