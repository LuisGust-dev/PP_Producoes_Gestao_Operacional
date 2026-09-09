<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('event_custom_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedInteger('required_quantity')->default(1);
            $table->unsignedInteger('separated_quantity')->default(0);
            $table->unsignedInteger('loaded_quantity')->default(0);
            $table->unsignedInteger('returned_quantity')->default(0);
            $table->text('observation')->nullable();
            $table->boolean('required')->default(true);
            $table->foreignId('last_updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_custom_items');
    }
};
