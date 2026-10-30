
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incoming_letters', function (Blueprint $table) {
            $table->id();
            $table->string('agenda_number', 50)->unique();
            $table->string('letter_number', 100)->nullable();
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('letter_categories')
                ->nullOnDelete();

            $table->string('sender', 150);
            $table->string('subject', 200);
            $table->date('letter_date')->nullable();
            $table->date('received_date');
            $table->text('summary')->nullable();
            $table->string('destination', 150)->nullable();

            $table->string('status', 30)->default('registered');
            $table->text('notes')->nullable();

            $table->foreignId('created_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamps();

            $table->index('received_date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incoming_letters');
    }
};
