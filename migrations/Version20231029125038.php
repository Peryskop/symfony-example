<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231029125038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add deletedBy field to comment and user';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE comment ADD deleted_by INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD deleted_by INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE comment DROP deleted_by');
        $this->addSql('ALTER TABLE post DROP deleted_by');
    }
}
