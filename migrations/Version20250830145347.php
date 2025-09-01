<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250830145347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tags table';
    }

    public function up(Schema $schema): void
    {
        $tags = $schema->createTable("tags");

        // Columns
        $tags->addColumn("id", "bigint", ["autoincrement" => true]);
        $tags->addColumn("user_id", "bigint", ["notnull" => true]);
        $tags->addColumn("label", "string", ["length" => 100, "notnull" => true]);

        // Primary key
        $tags->setPrimaryKey(["id"]);

        // Indexes. We are adding on label because of possible LIKE 'abc%' pattern searches
        $tags->addIndex(["user_id"], "idx_tags_user_id");
        $tags->addIndex(["label"], "idx_tags_label");

        // Foreign key for user_id
        $tags->addForeignKeyConstraint(
            "users",
            ["user_id"],
            ["id"],
            ["onDelete" => "CASCADE"],
            "fk_tags_user"
        );
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable("tags");
    }
}
