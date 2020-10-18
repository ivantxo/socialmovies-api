<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201017013033 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE likes MODIFY COLUMN created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE movies_preferences MODIFY COLUMN created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE notifications MODIFY COLUMN created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE posts MODIFY COLUMN created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('ALTER TABLE likes MODIFY COLUMN created_at DATETIME');
        $this->addSql('ALTER TABLE movies_preferences MODIFY COLUMN created_at DATETIME');
        $this->addSql('ALTER TABLE notifications MODIFY COLUMN created_at DATETIME');
        $this->addSql('ALTER TABLE posts MODIFY COLUMN created_at DATETIME');
    }
}
