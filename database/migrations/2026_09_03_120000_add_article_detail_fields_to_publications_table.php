<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('publications')) {
            return;
        }

        $fields = [
            'article_type' => 'string',
            'publication_type' => 'string',
            'publisher' => 'string',
            'frequency' => 'string',
            'language' => 'string',
        ];

        foreach ($fields as $field => $type) {
            if (! Schema::hasColumn('publications', $field)) {
                Schema::table('publications', function (Blueprint $table) use ($field, $type) {
                    $table->{$type}($field)->nullable();
                });
            }
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('publications')) {
            return;
        }

        $columns = array_values(array_filter(
            ['article_type', 'publication_type', 'publisher', 'frequency', 'language'],
            fn (string $column) => Schema::hasColumn('publications', $column)
        ));

        if ($columns) {
            Schema::table('publications', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};
