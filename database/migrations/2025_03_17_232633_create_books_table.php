<?php

use App\Models\User;
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
        Schema::create('books', function (Blueprint $table) {
            $table->ulid('id');
            $table->string('slug')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('title');
            $table->string('author');
            $table->text('description');
            $table->string('publisher');
            $table->string('isbn', 20)->unique();
            $table->string('category')->index();
            $table->string('cover_image')->nullable();
            $table->string('state');
            $table->date('published_at')->nullable();
            $table->integer('page_count')->default(0);
            $table->timestamp('checked_out_at')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->foreignIdFor(User::class, 'checked_out_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
