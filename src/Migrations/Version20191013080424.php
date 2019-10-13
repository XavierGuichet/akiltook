<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191013080424 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sport_team (id INT AUTO_INCREMENT NOT NULL, sport_club_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_B33F88E3C0AC4698 (sport_club_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, location VARCHAR(255) DEFAULT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, discr VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport_event (id INT NOT NULL, home_team_id INT DEFAULT NULL, away_team_id INT DEFAULT NULL, INDEX IDX_8FD26BBE9C4C13F6 (home_team_id), INDEX IDX_8FD26BBE45185D02 (away_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE account (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(190) NOT NULL, roles VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, salt VARCHAR(255) DEFAULT NULL, username VARCHAR(255) NOT NULL, facebook_id VARCHAR(255) DEFAULT NULL, google_id VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_7D3656A4E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consummable (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, done_by VARCHAR(255) DEFAULT NULL, INDEX IDX_63E2BCCDB03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_object (id INT AUTO_INCREMENT NOT NULL, content_url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE generic_event (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport_club (id INT AUTO_INCREMENT NOT NULL, logo_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CF31168EF98F144A (logo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sport_team ADD CONSTRAINT FK_B33F88E3C0AC4698 FOREIGN KEY (sport_club_id) REFERENCES sport_club (id)');
        $this->addSql('ALTER TABLE sport_event ADD CONSTRAINT FK_8FD26BBE9C4C13F6 FOREIGN KEY (home_team_id) REFERENCES sport_team (id)');
        $this->addSql('ALTER TABLE sport_event ADD CONSTRAINT FK_8FD26BBE45185D02 FOREIGN KEY (away_team_id) REFERENCES sport_team (id)');
        $this->addSql('ALTER TABLE sport_event ADD CONSTRAINT FK_8FD26BBEBF396750 FOREIGN KEY (id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consummable ADD CONSTRAINT FK_63E2BCCDB03A8386 FOREIGN KEY (created_by_id) REFERENCES account (id)');
        $this->addSql('ALTER TABLE generic_event ADD CONSTRAINT FK_5292B2B5BF396750 FOREIGN KEY (id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE sport_club ADD CONSTRAINT FK_CF31168EF98F144A FOREIGN KEY (logo_id) REFERENCES media_object (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sport_event DROP FOREIGN KEY FK_8FD26BBE9C4C13F6');
        $this->addSql('ALTER TABLE sport_event DROP FOREIGN KEY FK_8FD26BBE45185D02');
        $this->addSql('ALTER TABLE sport_event DROP FOREIGN KEY FK_8FD26BBEBF396750');
        $this->addSql('ALTER TABLE generic_event DROP FOREIGN KEY FK_5292B2B5BF396750');
        $this->addSql('ALTER TABLE consummable DROP FOREIGN KEY FK_63E2BCCDB03A8386');
        $this->addSql('ALTER TABLE sport_club DROP FOREIGN KEY FK_CF31168EF98F144A');
        $this->addSql('ALTER TABLE sport_team DROP FOREIGN KEY FK_B33F88E3C0AC4698');
        $this->addSql('DROP TABLE sport_team');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE sport_event');
        $this->addSql('DROP TABLE account');
        $this->addSql('DROP TABLE consummable');
        $this->addSql('DROP TABLE media_object');
        $this->addSql('DROP TABLE generic_event');
        $this->addSql('DROP TABLE sport_club');
    }
}
