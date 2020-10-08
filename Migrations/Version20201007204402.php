<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201007204402 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $sql = <<<SQL
CREATE TABLE posts (
  id INT UNSIGNED AUTO_INCREMENT NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  created_at DATETIME NOT NULL,
  like_count INT UNSIGNED NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
)
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE posts');
    }
}
