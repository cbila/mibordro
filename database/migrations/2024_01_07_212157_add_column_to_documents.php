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

        Schema::table('documents', function (Blueprint $table) {
            $table->foreignId('category_id')->after('id')->nullable()->cascadeOnDelete()->index();
            $table->foreignId('client_id')->after('id')->nullable()->cascadeOnDelete()->index();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('category_id');
            $table->dropColumn('client_id');

        });
    }
};
