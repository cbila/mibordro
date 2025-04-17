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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->index();
            
            $table->foreignId('client_id')->nullable()->index();
            $table->foreignId('company_id')->nullable()->index();
            $table->foreignId('sgk_id')->nullable()->index();

            $table->string('name', 30);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('identity', 100)->nullable();
            $table->datetime('recruitment_date')->nullable();
            $table->string('gsm', 20)->nullable();
            $table->string('iban', 31)->nullable();
            $table->string('position', 20)->nullable();
            $table->string('holidays')->nullable();
            $table->text('info')->nullable();

            $table->rememberToken();
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
