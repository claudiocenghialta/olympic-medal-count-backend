<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210819140216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE athlete_game (id INT AUTO_INCREMENT NOT NULL, athlete_id INT DEFAULT NULL, game_id INT DEFAULT NULL, position INT NOT NULL, disqualified TINYINT(1) DEFAULT NULL, INDEX IDX_9E8783C9FE6BCB8B (athlete_id), INDEX IDX_9E8783C9E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE athlete_game ADD CONSTRAINT FK_9E8783C9FE6BCB8B FOREIGN KEY (athlete_id) REFERENCES athlete (id)');
        $this->addSql('ALTER TABLE athlete_game ADD CONSTRAINT FK_9E8783C9E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('DROP TABLE game_athlete');
        $this->addSql('ALTER TABLE game DROP position, DROP disqualified');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game_athlete (game_id INT NOT NULL, athlete_id INT NOT NULL, INDEX IDX_55F9FC0EFE6BCB8B (athlete_id), INDEX IDX_55F9FC0EE48FD905 (game_id), PRIMARY KEY(game_id, athlete_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE game_athlete ADD CONSTRAINT FK_55F9FC0EE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE game_athlete ADD CONSTRAINT FK_55F9FC0EFE6BCB8B FOREIGN KEY (athlete_id) REFERENCES athlete (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE athlete_game');
        $this->addSql('ALTER TABLE game ADD position INT NOT NULL, ADD disqualified TINYINT(1) DEFAULT NULL');
    }
}
