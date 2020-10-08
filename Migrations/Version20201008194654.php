<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201008194654 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $sql = <<<SQL
CREATE TABLE notifications (
  id INT UNSIGNED AUTO_INCREMENT NOT NULL,
  post_id INT UNSIGNED NOT NULL,
  sender INT UNSIGNED NOT NULL,
  recipient INT UNSIGNED NOT NULL,
  was_read boolean,
  type ENUM('like') NOT NULL,
  created_at DATETIME NOT NULL,
  PRIMARY KEY(id),
  FOREIGN KEY (post_id) REFERENCES posts(id),
  FOREIGN KEY (sender) REFERENCES users(id),
  FOREIGN KEY (recipient) REFERENCES users(id)
)
SQL;
        $this->addSql($sql);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE notifications');
    }
}
