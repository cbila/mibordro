<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id()->index();
            // $table->foreignId('client_id')->nullable()->index();
            // $table->foreignId('category_id')->nullable()->cascadeOnDelete()->index();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->index();
            $table->string('disk', 72)->default('local');
            $table->string('extension', 5)->nullable();
            $table->string('file')->nullable();
            $table->string('alias', 100)->nullable();
            $table->string('mime')->nullable();
            $table->integer('size')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('read_by')->nullable();
            $table->datetime('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
