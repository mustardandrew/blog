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
        Schema::create('page_seos', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique()->comment('Унікальний ключ сторінки (наприклад: home, blog, contact)');
            $table->string('title')->nullable()->comment('SEO заголовок');
            $table->text('meta_description')->nullable()->comment('META опис');
            $table->text('keywords')->nullable()->comment('Ключові слова через кому');
            $table->boolean('noindex')->default(false)->comment('Заборона індексації');
            $table->boolean('nofollow')->default(false)->comment('Заборона переходу по посиланням');
            $table->json('additional_meta')->nullable()->comment('Додаткові META теги у форматі JSON');
            $table->timestamps();

            // Індекси для оптимізації пошуку
            $table->index('key');
            $table->index(['noindex', 'nofollow']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_seos');
    }
};
