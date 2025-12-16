<?php

use App\Models\Comment;
use App\Models\Project;
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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(Project::class)->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignIdFor(Comment::class, 'parent_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->text('content');
            $table->timestamp('created_at')->default(now());
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Project::class)->nullable();
            $table->foreignIdFor(Comment::class)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('likes');
    }
};
