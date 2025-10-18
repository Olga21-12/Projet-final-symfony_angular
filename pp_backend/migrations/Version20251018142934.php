<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251018142934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Bien: Timestampable';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE biens ADD date_inscription DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD date_modification DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP created_at, DROP updated_at');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE biens ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', DROP date_inscription, DROP date_modification');
    }
}
