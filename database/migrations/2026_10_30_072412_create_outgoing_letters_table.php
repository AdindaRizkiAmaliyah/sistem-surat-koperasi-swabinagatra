
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('outgoing_letters', function (Blueprint $table) {
            $table->id();
            $table->string('letter_number', 100)->unique();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('letter_categories')
                ->nullOnDelete();

            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->nullOnDelete();

            $table->string('recipient', 150);
            $table->string('subject', 200);
            $table->date('letter_date')->nullable();
            $table->date('sent_date')->nullable();
            $table->text('summary')->nullable();

            $table->string('status', 30)->default('draft');
            $table->text('notes')->nullable();

            $table->foreignId('created_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamps();

            $table->index('sent_date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outgoing_letters');
    }
};
