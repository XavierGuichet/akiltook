<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190920152435 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sport_team DROP FOREIGN KEY FK_B33F88E347366542');
        $this->addSql('CREATE TABLE sport_club (id INT AUTO_INCREMENT NOT NULL, logo_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_CF31168EF98F144A (logo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sport_club ADD CONSTRAINT FK_CF31168EF98F144A FOREIGN KEY (logo_id) REFERENCES media_object (id)');
        $this->addSql('DROP TABLE sports_club');
        $this->addSql('DROP INDEX IDX_B33F88E347366542 ON sport_team');
        $this->addSql('ALTER TABLE sport_team CHANGE sports_club_id sport_club_id INT NOT NULL');
        $this->addSql('ALTER TABLE sport_team ADD CONSTRAINT FK_B33F88E3C0AC4698 FOREIGN KEY (sport_club_id) REFERENCES sport_club (id)');
        $this->addSql('CREATE INDEX IDX_B33F88E3C0AC4698 ON sport_team (sport_club_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sport_team DROP FOREIGN KEY FK_B33F88E3C0AC4698');
        $this->addSql('CREATE TABLE sports_club (id INT AUTO_INCREMENT NOT NULL, logo_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, UNIQUE INDEX UNIQ_21D9EC3DF98F144A (logo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sports_club ADD CONSTRAINT FK_21D9EC3DF98F144A FOREIGN KEY (logo_id) REFERENCES media_object (id)');
        $this->addSql('DROP TABLE sport_club');
        $this->addSql('DROP INDEX IDX_B33F88E3C0AC4698 ON sport_team');
        $this->addSql('ALTER TABLE sport_team CHANGE sport_club_id sports_club_id INT NOT NULL');
        $this->addSql('ALTER TABLE sport_team ADD CONSTRAINT FK_B33F88E347366542 FOREIGN KEY (sports_club_id) REFERENCES sports_club (id)');
        $this->addSql('CREATE INDEX IDX_B33F88E347366542 ON sport_team (sports_club_id)');
    }
}
