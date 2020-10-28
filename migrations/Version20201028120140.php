<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201028120140 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experience_event DROP FOREIGN KEY FK_58FC76B14B89032C');
        $this->addSql('ALTER TABLE experience_event DROP FOREIGN KEY FK_58FC76B1A76ED395');
        $this->addSql('ALTER TABLE experience_event ADD CONSTRAINT FK_58FC76B14B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE experience_event ADD CONSTRAINT FK_58FC76B1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experience_event DROP FOREIGN KEY FK_58FC76B1A76ED395');
        $this->addSql('ALTER TABLE experience_event DROP FOREIGN KEY FK_58FC76B14B89032C');
        $this->addSql('ALTER TABLE experience_event ADD CONSTRAINT FK_58FC76B1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE experience_event ADD CONSTRAINT FK_58FC76B14B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
    }
}
