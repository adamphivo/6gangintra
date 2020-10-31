<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201031181654 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, date_added DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, post_id INT NOT NULL, text_content LONGTEXT NOT NULL, date_added DATETIME NOT NULL, code_block LONGTEXT DEFAULT NULL, INDEX IDX_9474526CA76ED395 (user_id), INDEX IDX_9474526C4B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE experience_event (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, post_id INT NOT NULL, experience_shift INT NOT NULL, event_type VARCHAR(255) NOT NULL, made_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_58FC76B1A76ED395 (user_id), INDEX IDX_58FC76B14B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, code_content LONGTEXT DEFAULT NULL, text_content LONGTEXT DEFAULT NULL, date_added DATETIME NOT NULL, main_text_content LONGTEXT DEFAULT NULL, github_link VARCHAR(255) DEFAULT NULL, youtube_link VARCHAR(255) DEFAULT NULL, consultation_count INT NOT NULL, INDEX IDX_5A8A6C8DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post_category (post_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_B9A190604B89032C (post_id), INDEX IDX_B9A1906012469DE2 (category_id), PRIMARY KEY(post_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE search (id INT AUTO_INCREMENT NOT NULL, search_content VARCHAR(255) NOT NULL, count INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(50) NOT NULL, user_name VARCHAR(50) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, portrait_url VARCHAR(255) DEFAULT NULL, experience INT NOT NULL, subscribed_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D64924A232CF (user_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE experience_event ADD CONSTRAINT FK_58FC76B1A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE experience_event ADD CONSTRAINT FK_58FC76B14B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_category ADD CONSTRAINT FK_B9A190604B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE post_category ADD CONSTRAINT FK_B9A1906012469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post_category DROP FOREIGN KEY FK_B9A1906012469DE2');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C4B89032C');
        $this->addSql('ALTER TABLE experience_event DROP FOREIGN KEY FK_58FC76B14B89032C');
        $this->addSql('ALTER TABLE post_category DROP FOREIGN KEY FK_B9A190604B89032C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE experience_event DROP FOREIGN KEY FK_58FC76B1A76ED395');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA76ED395');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE experience_event');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE post_category');
        $this->addSql('DROP TABLE search');
        $this->addSql('DROP TABLE user');
    }
}
