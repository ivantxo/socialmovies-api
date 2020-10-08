<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201008200625 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $sql = <<<SQL
CREATE TABLE movies_preferences (
  id INT UNSIGNED AUTO_INCREMENT NOT NULL,
  movie_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  created_at DATETIME NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
)
SQL;
        $this->addSql($sql);    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE movies_preferences');
    }
}
