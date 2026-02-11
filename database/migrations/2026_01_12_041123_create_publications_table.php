<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('content');
            $table->enum('type', ['article', 'news'])->default('article');
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->string('thumbnail')->nullable();
            $table->string('attachment')->nullable();
            $table->boolean('show_on_banner')->default(false);
            $table->dateTime('expired_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};
