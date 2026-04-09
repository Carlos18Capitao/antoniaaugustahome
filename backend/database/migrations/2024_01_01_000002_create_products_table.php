<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_available')->default(true);
            $table->boolean('is_active')->default(true);
            $table->string('dimensions')->nullable();
            $table->string('materials')->nullable();
            $table->string('colors')->nullable();
            $table->integer('sort_order')->default(0);
            $table->unsignedInteger('views_count')->default(0);
            $table->timestamps();

            $table->index(['is_featured', 'is_active']);
            $table->index(['category_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
