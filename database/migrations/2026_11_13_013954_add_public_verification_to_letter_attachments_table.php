<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('letter_attachments', function (Blueprint $table) {
            $table->string('public_id', 40)
                ->nullable()
                ->unique();

            $table->string('public_token', 64)
                ->nullable()
                ->unique();

            $table->boolean('is_public')
                ->default(false);

            $table->timestamp('published_at')
                ->nullable();

            $table->timestamp('revoked_at')
                ->nullable();

            $table->char('file_hash', 64)
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('letter_attachments', function (Blueprint $table) {
            $table->dropUnique(['public_id']);
            $table->dropUnique(['public_token']);

            $table->dropColumn([
                'public_id',
                'public_token',
                'is_public',
                'published_at',
                'revoked_at',
                'file_hash',
            ]);
        });
    }
};
