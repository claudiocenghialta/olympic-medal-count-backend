<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210813092608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE athlete (id INT AUTO_INCREMENT NOT NULL, nation_id INT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, INDEX IDX_C03B8321AE3899 (nation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, sport_id INT NOT NULL, date DATE NOT NULL, position INT NOT NULL, disqualified TINYINT(1) DEFAULT NULL, INDEX IDX_232B318CAC78BCF8 (sport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game_athlete (game_id INT NOT NULL, athlete_id INT NOT NULL, INDEX IDX_55F9FC0EE48FD905 (game_id), INDEX IDX_55F9FC0EFE6BCB8B (athlete_id), PRIMARY KEY(game_id, athlete_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nation (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, iso_code VARCHAR(3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_1A85EFD212469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport_category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE athlete ADD CONSTRAINT FK_C03B8321AE3899 FOREIGN KEY (nation_id) REFERENCES nation (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CAC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE game_athlete ADD CONSTRAINT FK_55F9FC0EE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_athlete ADD CONSTRAINT FK_55F9FC0EFE6BCB8B FOREIGN KEY (athlete_id) REFERENCES athlete (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sport ADD CONSTRAINT FK_1A85EFD212469DE2 FOREIGN KEY (category_id) REFERENCES sport_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_athlete DROP FOREIGN KEY FK_55F9FC0EFE6BCB8B');
        $this->addSql('ALTER TABLE game_athlete DROP FOREIGN KEY FK_55F9FC0EE48FD905');
        $this->addSql('ALTER TABLE athlete DROP FOREIGN KEY FK_C03B8321AE3899');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CAC78BCF8');
        $this->addSql('ALTER TABLE sport DROP FOREIGN KEY FK_1A85EFD212469DE2');
        $this->addSql('DROP TABLE athlete');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_athlete');
        $this->addSql('DROP TABLE nation');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE sport_category');
    }
}
