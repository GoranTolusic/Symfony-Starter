<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250830145346 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create users table';
    }

    public function up(Schema $schema): void
    {
        $users = $schema->createTable("users");

        $users->addColumn("id", "bigint", ["autoincrement" => true]);
        $users->addColumn("first_name", "string", ["length" => 255, "notnull" => false]);
        $users->addColumn("last_name", "string", ["length" => 255, "notnull" => false]);
        $users->addColumn("email", "string", ["length" => 255]);
        $users->addColumn("password", "string", ["length" => 255]);
        $users->addColumn("created_at", "bigint", ["notnull" => false]);

        // Indexes, primary and uniques
        $users->setPrimaryKey(["id"]);
        $users->addUniqueIndex(["email"], "uniq_users_email");
        $users->addIndex(["email"], "idx_users_email");

    }

    public function down(Schema $schema): void
    {
        $schema->dropTable("users");
    }
}
