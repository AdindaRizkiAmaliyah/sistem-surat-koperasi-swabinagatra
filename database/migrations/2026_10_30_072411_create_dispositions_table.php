
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dispositions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('incoming_letter_id')
                ->constrained('incoming_letters')
                ->cascadeOnDelete();

            $table->foreignId('from_user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('to_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('to_department_id')
                ->nullable()
                ->constrained('departments')
                ->nullOnDelete();

            $table->text('instruction');
            $table->text('notes')->nullable();
            $table->date('deadline')->nullable();

            $table->string('status', 30)->default('pending');
            $table->timestamp('read_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dispositions');
    }
};
